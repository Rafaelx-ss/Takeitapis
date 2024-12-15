<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Evento::all();
        return response()->json($eventos);
    }
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
    public function store(Request $request)
{
    // Validaciones con reglas y mensajes personalizados
    $validatedData = $request->validate([
        'patrocinadorID' => 'required|integer|exists:patrocinadores,patrocinadorID',
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
        'patrocinadorID.required' => 'El ID del patrocinador es obligatorio.',
        'patrocinadorID.integer' => 'El ID del patrocinador debe ser un número entero.',
        'categoriaID.required' => 'La categoría es obligatoria.',
        'nombreEvento.required' => 'El nombre del evento es obligatorio.',
        'fechaEvento.after' => 'La fecha del evento debe ser posterior al día de hoy.',
        'telefonoEvento.regex' => 'El teléfono debe tener exactamente 10 dígitos.',
        'horaEvento.date_format' => 'La hora del evento debe estar en el formato HH:mm.',
        'duracionEvento.min' => 'La duración mínima del evento es de 1 hora.',
        'duracionEvento.max' => 'La duración máxima del evento es de 48 horas.',
    ]);

    try {
        // Crear el evento en la base de datos
        $evento = Evento::create($validatedData);

        // Respuesta exitosa
        return response()->json([
            'success' => true,
            'message' => 'Evento creado exitosamente.',
            'data' => $evento,
        ], 201);

    } catch (\Exception $e) {
        // Manejo de errores
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al crear el evento. Por favor, inténtalo de nuevo.',
            'error' => $e->getMessage(),
        ], 500);
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
    public function update(Request $request,  $evento)
    {
        //
        $eventos = Evento::find($evento);

        if (!$eventos) {
            return response()->json(['error' => 'Eventos no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'patrocinadorID' => 'required|integer|exists:patrocinadores,patrocinadorID',
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
            'patrocinadorID.required' => 'El ID del patrocinador es obligatorio.',
            'patrocinadorID.integer' => 'El ID del patrocinador debe ser un número entero.',
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
    
        
            return response()->json([
                'success' => true,
                'message' => 'Evento actualizado exitosamente.',
                'data' => $eventos,
            ], 200);
        } catch (ModelNotFoundException $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'El evento con el ID especificado no se encontró.',
            ], 404);
        } catch (\Exception $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al actualizar el evento. Por favor, inténtalo de nuevo.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($evento)
    {
        //
        $evento = Evento::find($evento);

        if (!$evento) {
            return response()->json(['error' => 'Eventos no encontrada'], 404);
        }

        $evento->estadoEvento = 0;
        $evento->save();

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
}
