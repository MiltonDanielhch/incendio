<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
// Es recomendable usar Form Requests para encapsular la validación
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;

class PersonController extends Controller
{
    // Inyectar dependencias es una mejor práctica que instanciar controladores
    public function __construct(protected StorageController $storageController)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->custom_authorize('browse_people');

        return view('administrations.people.browse');
    }

   public function list()
    {
        // Parámetros de entrada
        $search   = request('search');
        $paginate = request('paginate', 10);

        // Consulta más segura y legible
        $data = Person::query()
            ->select('id', 'ci', 'first_name', 'middle_name', 'paternal_surname', 'maternal_surname', 'phone', 'email', 'image', 'status')
            ->selectRaw("CONCAT_WS(' ', first_name, middle_name, paternal_surname, maternal_surname) as full_name")
            ->when($search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->where('ci', 'like', "%{$search}%")
                          ->orWhere('phone', 'like', "%{$search}%")
                          ->orWhere('first_name', 'like', "%{$search}%")
                          ->orWhere('middle_name', 'like', "%{$search}%")
                          ->orWhere('paternal_surname', 'like', "%{$search}%")
                          ->orWhere('maternal_surname', 'like', "%{$search}%")
                          ->orWhereRaw("CONCAT_WS(' ', first_name, middle_name, paternal_surname, maternal_surname) LIKE ?", ["%{$search}%"]);

                    if (is_numeric($search)) {
                        $query->orWhere('id', $search);
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate($paginate);

        return view('administrations.people.list', compact('data'));
    }

    // Usar FormRequest para validación
    public function store(StorePersonRequest $request)
    {
        $this->custom_authorize('add_people');

        DB::beginTransaction();
        try {
            $validated = $request->validated();
            if ($request->hasFile('image')) {
                $validated['image'] = $this->storageController->store_image($request->file('image'), 'people');
            }
            Person::create($validated);

            DB::commit();
            return redirect()->route('voyager.people.index')->with(['message' => 'Registrado exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('voyager.people.index')->with(['message' => $th->getMessage(), 'alert-type' => 'error']);
        }
    }


    public function update(UpdatePersonRequest $request, Person $person){
        $this->custom_authorize('edit_people');

        DB::beginTransaction();
        try {
            $validated = $request->validated();

            // El status se puede manejar directamente en el request si se define como booleano
            $validated['status'] = $request->has('status');

            if ($request->hasFile('image')) {
                // Opcional: borrar imagen anterior si existe
                // if($person->image) { $this->storageController->delete_image($person->image); }
                $validated['image'] = $this->storageController->store_image($request->file('image'), 'people');
            }

            $person->update($validated);

            DB::commit();
            return redirect()->route('voyager.people.index')->with(['message' => 'Actualizada exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('voyager.people.index')->with(['message' => $th->getMessage(), 'alert-type' => 'error']);
        }
    }
}
