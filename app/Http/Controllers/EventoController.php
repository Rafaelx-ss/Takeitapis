<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Subcategoria;
use Illuminate\Support\Facades\Log;
class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Evento::all();

        error_log(json_encode($eventos, JSON_PRETTY_PRINT));
        return response()->json($eventos);        
    }   

    public function page(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 10; 

        $eventos = Evento::select('eventoID', 'nombreEvento', 'fechaEvento', 'costoEvento')->where('estadoEvento', 1)->paginate($perPage);

        error_log(json_encode($eventos, JSON_PRETTY_PRINT));
        return response()->json($eventos);
    }
    /**
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $usuarioID)
    {
        $nuevaSubcategoria = null;

        if($request->input('subCategoriaID') == 0){
            $nuevaSubcategoria = Subcategoria::create([
                'categoriaID' => $request->input('categoriaID'),
                'nombreSubcategoria' => $request->input('nuevaSubcategoria'), 
                'descripcionSubcategoria' => "Esta categoría fué creada por un usuario",
                'activoSubcategoria' => 1,
                'estadoSubcategoria' => 1
            ]);
        }

        $validatedData = $request->validate([
            'categoriaID' => 'required|integer|exists:categorias,categoriaID',
            'subCategoriaID' => 'required|integer|exists:subcategorias,subcategoriaID',
            'nombreEvento' => 'required|string|max:255',
            'lugarEvento' => 'required|string|max:255',
            'maximoParticipantesEvento' => 'nullable|integer|min:1|max:10000',
            'costoEvento' => 'nullable|numeric|min:0',
            'descripcionEvento' => 'nullable|string|max:500',
            'cpEvento' => 'required|string|size:5|regex:/^\d{5}$/',
            'municioEvento' => 'required|string|max:100',
            'estadoID' => 'required|integer|exists:estados,estadoID',
            'direccionEvento' => 'required|string|max:255',
            'telefonoEvento' => 'required|string|regex:/^\d{10}$/',
            'fechaEvento' => 'required|date|',
            'horaEvento' => 'required|date_format:H:i',
            'duracionEvento' => 'required|integer|min:1|max:48',
            'kitEvento' => 'required|string|max:255',
        ], [
            'categoriaID.required' => 'La categoría es obligatoria.',
            'nombreEvento.required' => 'El nombre del evento es obligatorio.',
            'fechaEvento.after' => 'La fecha del evento debe ser posterior al día de hoy.',
            'telefonoEvento.regex' => 'El teléfono debe tener exactamente 10 dígitos.',
            'horaEvento.date_format' => 'La hora del evento debe estar en el formato HH:mm.',
            'duracionEvento.min' => 'La duración mínima del evento es de 1 hora.',
            'duracionEvento.max' => 'La duración máxima del evento es de 48 horas.',
        ]);

        try {
            $evento = Evento::create($validatedData);
            if($evento){
                $evento->usuarios()->attach($usuarioID);
                $response = [
                    'success' => true,
                    'message' => 'Evento creado exitosamente.',
                    'data' => $evento,
                ];
                error_log(json_encode($response, JSON_PRETTY_PRINT));
                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No se pudo crear el evento. Por favor verifique los datos e intente nuevamente.',
                ];
                error_log(json_encode($response, JSON_PRETTY_PRINT));
                return response()->json($response, 422);
            }
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Ocurrió un error al crear el evento. Por favor, inténtalo de nuevo.',
                'error' => $e->getMessage(),
            ];

            error_log(json_encode($response, JSON_PRETTY_PRINT));
            return response()->json($response, 500);
        }
        
    }


    /**
     * Display the specified resource.
     */
    public function show($evento)
    {
        //
        $eventos = Evento::find($evento);

        if (!$eventos) {
            return response()->json(['error' => 'Evento no encontrada'], 404);
        }

        error_log(json_encode($eventos, JSON_PRETTY_PRINT));

        return response()->json($eventos);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $eventoID)
    {

        //
        $eventos = Evento::find($eventoID);

        if (!$eventos) {
            return response()->json(['error' => 'Eventos no encontrada'], 404);
        }



        $validatedData = $request->validate([
            'categoriaID' => 'required|integer|exists:categorias,categoriaID',
            'subCategoriaID' => 'required|integer|exists:subcategorias,subcategoriaID',
            'nombreEvento' => 'required|string|max:255',
            'lugarEvento' => 'required|string|max:255',
            'maximoParticipantesEvento' => 'nullable|integer|min:1|max:10000',
            'costoEvento' => 'nullable|numeric|min:0',
            'descripcionEvento' => 'nullable|string|max:500',
            'cpEvento' => 'required|string|size:5|regex:/^\d{5}$/',
            'municioEvento' => 'required|string|max:100',
            'estadoID' => 'required|integer|exists:estados,estadoID',
            'direccionEvento' => 'required|string|max:255',
            'telefonoEvento' => 'required|string|regex:/^\d{10}$/',
            'fechaEvento' => 'required|date|',
            'horaEvento' => 'required|date_format:H:i',
            'duracionEvento' => 'required|integer|min:1|max:48',
            'kitEvento' => 'required|string|max:255',
        ], [
            'categoriaID.required' => 'La categoría es obligatoria.',
            'nombreEvento.required' => 'El nombre del evento es obligatorio.',
            'fechaEvento.after' => 'La fecha del evento debe ser posterior al día de hoy.',
            'telefonoEvento.regex' => 'El teléfono debe tener exactamente 10 dígitos.',
            'horaEvento.date_format' => 'La hora del evento debe estar en el formato HH:mm.',
            'duracionEvento.min' => 'La duración mínima del evento es de 1 hora.',
            'duracionEvento.max' => 'La duración máxima del evento es de 48 horas.',
        ]);



        try {
            $eventos->update($validatedData);
            $response = [
                'success' => true,
                'message' => 'Evento actualizado exitosamente.',
                'data' => $eventos,
            ];
            error_log(json_encode($response, JSON_PRETTY_PRINT));
            return response()->json($response, 200);
        } catch (ModelNotFoundException $e) {
            $response = [
            'success' => false,
            'message' => 'El evento con el ID especificado no se encontró.',
            ];
            error_log(json_encode($response, JSON_PRETTY_PRINT));
            return response()->json($response, 404);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Ocurrió un error al actualizar el evento. Por favor, inténtalo de nuevo.',
                'error' => $e->getMessage(),
            ];
            error_log(json_encode($response, JSON_PRETTY_PRINT));
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($eventoID)
    {
        //
        $evento = Evento::find($eventoID);

        if (!$evento) {
            error_log(response()->json(['error' => 'Eventos no encontrada'], 404));
            return response()->json(['error' => 'Eventos no encontrada'], 404);
        }

        $evento->estadoEvento = 0;
        $evento->save();

        error_log(response()->json(['message' => 'Eventos eliminada exitosamente']));
        return response()->json(['message' => 'Eventos eliminada exitosamente']);
    }

    public function filter(Request $request)
    {
        $query = Evento::query();

        $filters = [
            'eventoID' => '=',
            'patrocinadorID' => '=',
            'categoriaID' => '=',
            'subCategoriaID' => '=',
            'nombreEvento' => 'like',
            'lugarEvento' => 'like',
            'maximoParticipantesEvento' => 'like',
            'costoEvento' => 'like',
            'descripcionEvento' => 'like',
            'cpEvento' => 'like',
            'municioEvento' => 'like',
            'estadoID' => '=',
            'direccionEvento' => 'like',
            'telefonoEvento' => 'like',
            'fechaEvento' => 'like',
            'duracionEvento' => 'like',
            'kitEvento' => 'like',
            'activoEvento' => '=',
            'estadoEvento' => '=',
            'created_at' => 'like',
            'updated_at' => 'like'
        ];

        foreach ($filters as $field => $operator) {
            if ($request->has($field)) {
            $value = $request->input($field);
            $query->where($field, $operator, $operator === 'like' ? "%$value%" : $value);
            }
        }

        return response()->json($query->get());
    }

    public function toggle($id)
    {
        $eventos = Evento::find($id);

        if (!$eventos) {
            return response()->json(['error' => 'Evento no encontrada'], 404);
        }
        $eventos->activoEvento = !$eventos->activoEvento;
        $eventos->save();

        return response()->json(['susccess' => 'Evento actualizada exitosamente']);
    }

    public function miseventos(Request $request, $usuarioID)
    {
        $page = $request->input('page', 1);
        $itemsPerPage = $request->input('itemsPerPage', 10);
        $sortColumn = $request->input('sortColumn', 'eventos.eventoID'); 
        $sortDirection = $request->input('sortDirection', 'asc');
    
        $query = Evento::join('usuarioseventos', 'eventos.eventoID', '=', 'usuarioseventos.eventoID')
            ->where('usuarioseventos.usuarioID', $usuarioID)
            ->select(
                'eventos.eventoID',
                'eventos.nombreEvento',
                'eventos.fechaEvento',
                'eventos.horaEvento', 
                'eventos.lugarEvento',
                'eventos.direccionEvento',
                'eventos.costoEvento',
                'eventos.maximoParticipantesEvento',
                'eventos.activoEvento'
            );

        if ($sortColumn) {
            $query->orderBy($sortColumn, $sortDirection);
        }
    
        $eventos = $query->paginate($itemsPerPage, ['*'], 'page', $page);
    
        return response()->json([
            'eventos' => $eventos->items(),
            'totalItems' => $eventos->total()
        ]);
    }
}
