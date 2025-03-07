<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class SubcategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategorias = Subcategoria::where('estadoSubcategoria', 1)->get();
        return ResponseHelper::success('Lista de subcategorías obtenida exitosamente', $subcategorias);
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
        $validatedData = $request->validate([
            'categoriaID' => 'required|integer|exists:categorias,categoriaID',
            'nombreSubcategoria' => 'required|string|max:255',
            'descripcionSubcategoria' => 'nullable|string',
        ]);

        $subcategoria = Subcategoria::create($validatedData);

        return ResponseHelper::success('Subcategoría creada exitosamente', $subcategoria);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $subcategoria = Subcategoria::find($id);

        if (!$subcategoria) {
            return ResponseHelper::error('Subcategoría no encontrada', [], 404);
        }

        return ResponseHelper::success('Subcategoría encontrada exitosamente', $subcategoria);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategoria $subcategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subcategoria = Subcategoria::find($id);

        if (!$subcategoria) {
            return ResponseHelper::error('Subcategoría no encontrada', [], 404);
        }

        $validatedData = $request->validate([
            'categoriaID' => 'nullable|integer|exists:categorias,categoriaID',
            'nombreSubcategoria' => 'nullable|string|max:255',
            'descripcionSubcategoria' => 'nullable|string',
            'activoSubcategoria' => 'nullable|boolean',
        ]);

        try {
            $subcategoria->update($validatedData);

            return ResponseHelper::success('Subcategoría actualizada exitosamente', $subcategoria);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al actualizar la subcategoría', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subcategoria = Subcategoria::find($id);

        if (!$subcategoria) {
            return ResponseHelper::error('Subcategoría no encontrada', [], 404);
        }

        $subcategoria->estadoSubcategoria = 0;
        $subcategoria->save();

        return ResponseHelper::success('Subcategoría eliminada exitosamente', $subcategoria);
    }

    public function toggle($id)
    {
        $subcategoria = Subcategoria::find($id);

        if (!$subcategoria) {
            return ResponseHelper::error('Subcategoría no encontrada', [], 404);
        }

        $subcategoria->activoSubcategoria = !$subcategoria->activoSubcategoria;
        $subcategoria->save();

        return ResponseHelper::success('Estado de subcategoría actualizado exitosamente', $subcategoria);
    }
}
