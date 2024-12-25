<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Subcategoria;
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

    public function form()
    {
        $categorias = Categoria::
            select('categoriaID', 'nombreCategoria')
            ->where('estadoCategoria', 1)
            ->get();
        return response()->json($categorias);
    }

    public function subcategoria($categoriaID)
    {
        $subcategorias = Subcategoria::
            select('subcategoriaID', 'nombreSubcategoria')
            ->where('categoriaID', $categoriaID)
            ->where('estadoSubcategoria', 1)
            ->get();

        return response()->json($subcategorias);
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

        $categoria->estadoCategoria = 0;
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

        $filters = [
            'categoriaID' => '=',
            'nombreCategoria' => 'like',
            'descripcionCategoria' => 'like',
            'activoCategoria' => '=',
            'estadoCategoria' => '=',
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

        return response()->json(['susccess' => 'Categoría actualizada exitosamente']);
    }
}
