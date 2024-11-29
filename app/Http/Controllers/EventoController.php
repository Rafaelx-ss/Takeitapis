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
        //
        $validatedData = $request->validate([
            'patrocinadorID' => 'required|integer',
            'categoriaID' => 'required|integer',
            'subCategoriaID' => 'required|integer',
            'nombreEvento' => 'required|string|max:255',
            'lugarEvento' => 'required|string|max:255',
            'maximoParticipantesEvento' => 'nullable|string|max:255',
            'costoEvento' => 'nullable|numeric',
            'descripcionEvento' => 'nullable|string|max:255',
            'cpEvento' => 'required|string|max:255',
            'municioEvento' => 'required|string|max:255',
            'estadoID' => 'required|integer',
            'direccionEvento' => 'required|string|max:255',
            'telefonoEvento' => 'required|string|max:255',
            'fechaEvento' => 'required|string|max:255',
            'horaEvento' => 'required|string|max:255',
            'duracionEvento' => 'required|string|max:255',
            'kitEvento' => 'required|string|max:255',
        ]);

        $eventos = Evento::create($validatedData);

        return response()->json($eventos, 201);
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
            'patrocinadorID' => 'required|integer',
            'categoriaID' => 'required|integer',
            'subCategoriaID' => 'required|integer',
            'nombreEvento' => 'required|string|max:255',
            'lugarEvento' => 'required|string|max:255',
            'maximoParticipantesEvento' => 'nullable|string|max:255',
            'costoEvento' => 'nullable|numeric',
            'descripcionEvento' => 'nullable|string|max:255',
            'cpEvento' => 'required|string|max:255',
            'municioEvento' => 'required|string|max:255',
            'estadoID' => 'required|integer',
            'direccionEvento' => 'required|string|max:255',
            'telefonoEvento' => 'required|string|max:255',
            'fechaEvento' => 'required|string|max:255',
            'horaEvento' => 'required|string|max:255',
            'duracionEvento' => 'required|string|max:255',
            'kitEvento' => 'required|string|max:255',
        ]);

        $eventos->update($validatedData);

        return response()->json($eventos);
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
            'eventosID' => '=',
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
