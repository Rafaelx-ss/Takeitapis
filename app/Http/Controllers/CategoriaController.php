<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    /**
     * Obtener una categoría específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria);
    }

    /**
     * Crear una nueva categoría.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombreCategoria' => 'required|string|max:255',
            'descripcionCategoria' => 'nullable|string',
            'activoCategoria' => 1,
            'estadoCategoria' => 1,
        ]);

        $categoria = Categoria::create($validatedData);

        return response()->json($categoria, 201);
    }

    /**
     * Actualizar una categoría existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'nombreCategoria' => 'nullable|string|max:255',
            'descripcionCategoria' => 'nullable|string',
            'activoCategoria' => 1,
            'estadoCategoria' => 1,
        ]);

        $categoria->update($validatedData);

        return response()->json($categoria);
    }

    /**
     * Eliminar una categoría.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $categoria->activoCategoria = !$categoria->activoCategoria;
        $categoria->save();

        return response()->json(['message' => 'Categoría eliminada exitosamente']);
    }

    /**
     * Filtrar categorías por estado o actividad.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $query = Categoria::query();

        if ($request->has('activoCategoria')) {
            $query->where('activoCategoria', $request->activoCategoria);
        }

        if ($request->has('estadoCategoria')) {
            $query->where('estadoCategoria', $request->estadoCategoria);
        }

        return response()->json($query->get());
    }

    /**
     * Activar o desactivar una categoría.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }
        $categoria->activoCategoria = !$categoria->activoCategoria;
        $categoria->save();

        return response()->json($categoria);
    }
}
