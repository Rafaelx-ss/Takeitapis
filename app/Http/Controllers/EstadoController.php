<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estado::select('estadoID', 'nombreEstado')->get();
        return response()->json($estados);
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
            'nombreEstado' => 'required|string|max:255',
            'paisID' => 'required|integer',
        ]);

        $Estado = Estado::create($validatedData);

        return response()->json($Estado, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $Estado = Estado::find($id);

        if (!$Estado) {
            return response()->json(['error' => 'Estado no encontrada'], 404);
        }

        return response()->json($Estado);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estado $estado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $Estado = Estado::find($id);

        if (!$Estado) {
            return response()->json(['error' => 'Estado no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'nombreEstado' => 'required|string|max:255',
            'paisID' => 'required|integer',
        ]);

        $Estado->update($validatedData);

        return response()->json($Estado);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $Estado = Estado::find($id);

        if (!$Estado) {
            return response()->json(['error' => 'Estado no encontrada'], 404);
        }

        $Estado->estadoEstado = 0;
        $Estado->save();

        return response()->json(['message' => 'Estado eliminada exitosamente']);
    }

    public function filter(Request $request)
    {
        $query = Estado::query();

        $filters = [
            'estadoID' => '=',
            'nombreEstado' => 'like',
            'paisID' => '=',
            'activoEstado' => '=',
            'estadoEstado' => '=',
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
        $Estado = Estado::find($id);

        if (!$Estado) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }
        $Estado->activoEstado = !$Estado->activoEstado;
        $Estado->save();

        return response()->json(['susccess' => 'Categoría actualizada exitosamente']);
    }
}


