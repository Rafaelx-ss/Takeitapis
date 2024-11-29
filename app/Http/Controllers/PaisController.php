<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paises = Pais::all();
        return response()->json($paises);
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

        //post
        $validatedData = $request->validate([
            'nombrePais' => 'required|string|max:255',

        ]);

        $paises = Pais::create($validatedData);

        return response()->json($paises, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($pais)
    {
        //
        $Pais = Pais::find($pais);

        if (! $Pais) {
            return response()->json(['error' => 'Pais no encontrada'], 404);
        }

        return response()->json($Pais);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pais $pais)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $pais)
    {
        //

        $Pais = Pais::find($pais);

        if (!$Pais) {
            return response()->json(['error' => 'Pais no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'nombrePais' => 'nullable|string|max:255',
        ]);

        $Pais->update($validatedData);

        return response()->json($Pais);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($pais)
    {
        //

        $Pais = Pais::find($pais);

        if (!$Pais) {
            return response()->json(['error' => 'Pais no encontrada'], 404);
        }

        $Pais->estadoPais = 0;
        $Pais->save();

        return response()->json(['message' => 'Pais eliminada exitosamente']);
    }

    public function filter(Request $request)
    {
        $query = Pais::query();

        $filters = [
            'paisID' => '=',
            'nombrePais' => 'like',
            'activoPais' => '=',
            'estadoPais' => '=',
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
        $Pais = Pais::find($id);

        if (!$Pais) {
            return response()->json(['error' => 'Pais no encontrada'], 404);
        }
        $Pais->activoPais = !$Pais->activoPais;
        $Pais->save();

        return response()->json(['susccess' => 'Pais actualizada exitosamente']);
    }
}
