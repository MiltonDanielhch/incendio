<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     $this->custom_authorize('browse_users');
    //     return User::all();

    //     return view('vendor.voyager.users.broswse');
    // }


    public function list()
    {
        // $this->custom_authorize('browse_users');
        $search = request('search');
        $paginate = request('paginate') ?? 10;

        $data = User::with(['person'])
                    ->when($search, function($query, $search) {
                        $query->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                        if (is_numeric($search)) {
                            $query->orWhere('id', $search);
                        }
                    })
                    ->when(Auth::user()->role_id != 1, function ($q) {
                        $q->where('role_id', '!=', 1);
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($paginate);
        return view('vendor.voyager.users.list', compact('data'));
    }


    public function store(Request $request)
    {
        $data = User::where('email', $request->email)->first();
        if($data)
        {
            return redirect()->route('voyager.users.index')->with(['message' => 'El correo ya existe.', 'alert-type' => 'warning    ']);
        }
        $person = Person::where('deleted_at', null)->where('status', 1)->where('id', $request->person_id)->first();

        DB::beginTransaction();
        try {

            User::create([
                'person_id' => $request->person_id,
                'name' =>  $person->first_name,
                'role_id' => $request->role_id,
                'email' => $request->email,
                'avatar' => 'users/default.png',
                'password' => bcrypt($request->password),
                // 'settings' => '{"locale":"es"}'

            ]);
            DB::commit();
            return redirect()->route('voyager.users.index')->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('voyager.users.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $data = [
                'status' => $request->has('status') ? 1 : 0,
            ];

            if ($request->filled('role_id')) {
                $data['role_id'] = $request->role_id;
            }
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }
            $user->update($data);

            DB::commit();
            return redirect()->route('voyager.users.index')->with(['message' => 'Actualizado exitosamente.', 'alert-type' => 'success']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('voyager.users.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();
            return redirect()->route('voyager.users.index')->with(['message' => 'Eliminado exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('voyager.users.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
}
