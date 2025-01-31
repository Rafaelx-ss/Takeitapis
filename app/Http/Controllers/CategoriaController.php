<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Subcategoria;
use App\Helpers\ResponseHelper;

class CategoriaController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categorias = Categoria::all();
        return ResponseHelper::success('Lista de categorias exitosamente', $categorias);

    }

    public function form()
    {
        $categorias = Categoria::
            select('categoriaID', 'nombreCategoria')
            ->where('estadoCategoria', 1)
            ->get();


        return ResponseHelper::success('Lista de categorias activas exitosamente.', $categorias);
    }

    public function subcategoria($categoriaID)
    {
        $subcategorias = Subcategoria::
            select('subcategoriaID', 'nombreSubcategoria')
            ->where('categoriaID', $categoriaID)
            ->where('estadoSubcategoria', 1)
            ->get();


        return ResponseHelper::success('Lista de subcategorias de categoriaID = '.$categoriaID .' exitosamente.', $subcategorias);
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
            return ResponseHelper::error('Categoría no encontrada', [], 404);
        }
        return ResponseHelper::success('Lista de Categoría de categoriaID = '.$id .' exitosamente.', $categoria);
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

        return ResponseHelper::success('Categoria creada exitosamente.', $categoria);
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

        return ResponseHelper::success('Categoria actualizada exitosamente.', $categoria);  
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
            return ResponseHelper::error('Categoría no encontrada categoriaID = '.$id, [], 404);
        }

        $categoria->estadoCategoria = 0;
        $categoria->save();

        return ResponseHelper::success('Categoria eliminada exitosamente.', $categoria);
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

        return ResponseHelper::success('Categoria encontrada.', $query->get());
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
            return ResponseHelper::error('Categoría no encontrada', [], 404);

        }
        $categoria->activoCategoria = !$categoria->activoCategoria;
        $categoria->save();

        return ResponseHelper::success('Categoría actualizado exitosamente');

    }
}
