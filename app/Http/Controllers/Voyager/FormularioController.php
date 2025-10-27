<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormularioRequest;
use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Municipio;
use App\Models\Comunidad;
use App\Models\GrupoEtario;
use App\Models\Incendio;
use App\Models\Provincia;
use App\Services\FormularioService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateFormularioRequest;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request as RequestFacade;

class FormularioController extends Controller
{
    protected FormularioService $service;

    public function __construct(FormularioService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('vendor.voyager.formularios.browse');
    }

    /**
     * Return formularios list for AJAX requests
     */
    public function list(Request $request)
    {
        $paginate = $request->input('paginate', 10);
        $search = $request->input('search', '');

        // Comienza la consulta
        $data = Formulario::with(['comunidad.municipio.provincia', 'incendio', 'asistencias'])
            ->where(function ($query) use ($search) {
                // Añadimos todas las condiciones de búsqueda aquí dentro de una función anónima
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('codigo_formulario', 'like', '%' . $search . '%')
                    ->orWhere('estado', 'like', '%' . $search . '%')
                    ->orWhereHas('comunidad', function ($query) use ($search) {
                        $query->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('comunidad.municipio', function ($query) use ($search) {
                        $query->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('comunidad.municipio.provincia', function ($query) use ($search) {
                        $query->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('incendio', function ($query) use ($search) {
                        $query->where('causas_probables', 'like', '%' . $search . '%')
                            ->orWhere('estado', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate($paginate);

        return view('vendor.voyager.formularios.list', compact('data'));
    }

    public function ver($id)
    {
        $grupoEtarios = GrupoEtario::orderBy('nombre')->get();
        $enfermedades = Catalogo::where('tipo', 'enfermedad')->get();

        $formulario = Formulario::with([
            'comunidad.municipio.provincia',
            'incendio.ubicacion'
        ])->findOrFail($id);

        return view('vendor.voyager.formularios.show', compact('formulario', 'grupoEtarios', 'enfermedades')); // o 'formularios.ver'
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provincias = Provincia::all();
        // $incendios = Incendio::where('estado', '!=', 'extinguido')->get();
        // Solo incendios activos/controlados + límite
        $incendios = Incendio::whereIn('estado', ['activo', 'controlado'])
            ->select('id', 'codigo_incendio', 'estado')
            ->orderByDesc('fecha_inicio')
            ->limit(100)          // evita miles
            ->get();

        $grupoEtarios = GrupoEtario::all();

        $ubicaciones = Ubicacion::orderBy('id')->get();

        $tipos = [
            'enfermedad', 'institucion_educativa', 'modalidad_educacion',
            'tipo_infraestructura', 'tipo_servicio_basico', 'tipo_especie',
            'tipo_cultivo', 'tipo_area_forestal', 'tipo_fauna',
            'tipo_asistencia', 'especie_reforestacion'
        ];

        $catalogos = Catalogo::whereIn('tipo', $tipos)
            ->get()
            ->groupBy('tipo');

        return view('vendor.voyager.formularios.edit-add', compact(
            'provincias',
            'incendios',
            'grupoEtarios',
            'ubicaciones'
        ));
    }

    public function store(StoreFormularioRequest $request)
    {
        // try {
            $validated = $request->validated();

            // Generar código único si no viene
            if (empty($validated['codigo_formulario'])) {
                do {
                    $codigo = 'FORM-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
                } while (Formulario::withTrashed()->where('codigo_formulario', $codigo)->exists());
                $validated['codigo_formulario'] = $codigo;
            }

            return DB::transaction(function () use ($validated, $request) {
                // 1. Crear incendio NUEVO
                $incendio = $this->service->guardarIncendio($request);

                // 2. Asignar el nuevo incendio al formulario
                $validated['incendio_id'] = $incendio->id;

                // 3. Crear formulario
                $formulario = Formulario::create($validated);

                // 4. Guardar secciones adicionales (si las tienes)
                $this->service->guardarTodo($formulario->id, $request);

                return redirect()->route('formularios.index')
                                ->with('success', 'Formulario e incendio creados exitosamente.');
            });

        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     return redirect()->back()
        //                     ->withErrors($e->validator)
        //                     ->withInput();
        // } catch (\Exception $e) {
        //     \Log::error('Error creando formulario e incendio', [
        //         'usuario' => auth()->id(),
        //         'payload' => $request->all(),
        //         'error'   => $e->getMessage(),
        //     ]);
            return redirect()->back()
                            ->with('error', 'Error al crear el formulario y el incendio: ' . $e->getMessage())
                            ->withInput();
        // }
    }

    public function edit($id)
    {
        // $formulario = Formulario::with([
        //     'comunidad.municipio.provincia',
        //     'incendio.ubicacion'
        // ])->findOrFail($id);

        $formulario = Formulario::with([
            'comunidad.municipio.provincia',
            'incendio.ubicacion',
            'salud',
            'afectadosIncendios',
            'sectoresAgricolas',
            'sectoresPecuarios',
            'areasForestales',
            'infraestructuras',
            'serviciosBasicos',
            'educaciones',
            'reporteComunitario',
            'asistencias',
            'reforestaciones'
        ])->findOrFail($id);

        $provincias = Provincia::all();
        $municipios = Municipio::where('provincia_id', $formulario->comunidad->municipio->provincia_id)
                                ->orderBy('nombre')
                                ->get();
        $comunidades = Comunidad::where('municipio_id', $formulario->comunidad->municipio_id)
                                ->orderBy('nombre')
                                ->get();

        $grupoEtarios = GrupoEtario::all();

        return view('vendor.voyager.formularios.edit-add', compact(
            'formulario',
            'provincias',
            'municipios',
            'comunidades',
            'grupoEtarios'
        ));
    }

    public function update(UpdateFormularioRequest $request, $id)
    {
        $formulario = Formulario::findOrFail($id);

        $validated = $request->validated();

        return DB::transaction(function () use ($validated, $request, $formulario) {
            // 1. Actualizar incendio asociado (sin crear uno nuevo)
            $this->service->actualizarIncendio($formulario->incendio, $request);

            // 2. Actualizar el formulario
            $formulario->update($validated);

            // 3. Guardar secciones adicionales (si las tenés)
            $this->service->guardarTodo($formulario->id, $request);
  return redirect()->route('formularios.index')
                ->with('success', 'Formulario actualizado correctamente.');
        });
    }

    public function buscar_municipio($id_provincia)
    {
        try {
            $municipios = Municipio::where('provincia_id', $id_provincia)->get();
            return response()->json($municipios);
        } catch (\Exception $exception) {
            return response()->json(['mensaje' => 'Error'], 500);
        }
    }

    /**
     * Get communities by municipality
     */
    public function buscar_comunidad($id_municipio)
    {
        try {
            $comunidades = Comunidad::where('municipio_id', $id_municipio)->get();
            return response()->json($comunidades);
        } catch (\Exception $exception) {
            return response()->json(['mensaje' => 'Error'], 500);
        }
    }

    /**
     * Get mayor name by municipality
     */
    public function getAlcalde($municipioId)
    {
        try {
            $municipio = Municipio::findOrFail($municipioId);
            return response()->json(['nombre_alcalde' => $municipio->nombre_alcalde]);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Municipio no encontrado'], 404);
        }
    }

    /**
     * Get population by municipality
     */
    public function getPoblacion($municipioId)
    {
        try {
            $municipio = Municipio::findOrFail($municipioId);
            return response()->json(['poblacion_total' => $municipio->poblacion_total]);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Municipio no encontrado'], 404);
        }
    }


    public function quickStoreComunidad(Request $request)
    {
        $request->validate([
            'municipio_id' => 'required|exists:municipios,id',
            'nombre' => 'required|string|max:255',
            'tipo_comunidad' => 'required|in:urbana,rural,intercultural,campesina,indigena',
            'poblacion_aproximada' => 'nullable|integer|min:0',
        ]);

        $comunidad = Comunidad::create([
            'municipio_id' => $request->municipio_id,
            'nombre' => $request->nombre,
            'tipo_comunidad' => $request->tipo_comunidad,
            'poblacion_aproximada' => $request->poblacion_aproximada,
        ]);

        return response()->json(['id' => $comunidad->id, 'nombre' => $comunidad->nombre]);
    }
}
