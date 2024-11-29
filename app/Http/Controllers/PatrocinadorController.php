<?php

namespace App\Http\Controllers;

use App\Models\Patrocinador;
use Illuminate\Http\Request;

class PatrocinadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $patrocinador = Patrocinador::all();
        return response()->json($patrocinador);
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
            'fotoPatrocinador' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'nombrePatrocinador' => 'required|string|max:255',
            'representantePatrocinador' => 'required|string|max:255',
            'rfcPatrocinador' => 'required|string|max:255',
            'correoPatrocinador' => 'required|string|max:255',
            'telefonoPatrocinador' => 'required|string|max:255',
            'numeroRepresentantePatrocinador' => 'required|string|max:255',
            
        ]);

        $patrocinador = Patrocinador::create($validatedData);

        return response()->json($patrocinador, 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $patrocinador = Patrocinador::find($id);

        if (!$patrocinador) {
            return response()->json(['error' => 'Patrocinador no encontrada'], 404);
        }

        return response()->json($patrocinador);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patrocinador $patrocinador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $patrocinador = Patrocinador::find($id);

        if (!$patrocinador) {
            return response()->json(['error' => 'Patrocinador no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'fotoPatrocinador' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'nombrePatrocinador' => 'required|string|max:255',
            'representantePatrocinador' => 'required|string|max:255',
            'rfcPatrocinador' => 'required|string|max:255',
            'correoPatrocinador' => 'required|string|max:255',
            'telefonoPatrocinador' => 'required|string|max:255',
            'numeroRepresentantePatrocinador' => 'required|string|max:255',
        ]);

        $patrocinador->update($validatedData);

        return response()->json($patrocinador);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 
        $patrocinador = Patrocinador::find($id);

        if (!$patrocinador) {
            return response()->json(['error' => 'Patrocinador no encontrada'], 404);
        }

        $patrocinador->estadoPatrocinador= 0;
        $patrocinador->save();

        return response()->json(['message' => 'Patrocinador eliminada exitosamente']);
    }

    public function filter(Request $request)
    {
        $query = Patrocinador::query();

        $filters = [
            'patrocinadorID' => '=',
            'fotoPatrocinador' => 'like',
            'representantePatrocinador' => 'like',
            'rfcPatrocinador' => 'like',
            'correoPatrocinador' => 'like',
            'telefonoPatrocinador' => 'like',
            'numeroRepresentantePatrocinador' => 'like',
            'activoPatrocinador' => '=',
            'estadoPatrocinador' => '=',
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
        $patrocinador = Patrocinador::find($id);

        if (!$patrocinador) {
            return response()->json(['error' => 'Patrocinador no encontrada'], 404);
        }
        $patrocinador->activoPatrocinador = !$patrocinador->activoPatrocinador;
        $patrocinador->save();

        return response()->json(['susccess' => 'Patrocinador actualizada exitosamente']);
    }
}


