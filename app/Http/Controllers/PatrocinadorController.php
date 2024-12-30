<?php

namespace App\Http\Controllers;

use App\Models\Patrocinador;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatrocinadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($usuarioID)
    {
        $patrocinadores = Patrocinador::where('usuarioID', $usuarioID)->get(['patrocinadorID', 'fotoPatrocinador', 'nombrePatrocinador', 'representantePatrocinador', 'activoPatrocinador', 'estadoPatrocinador']);

        $filteredPatrocinadores = $patrocinadores->filter(function ($patrocinador) {
            return $patrocinador->estadoPatrocinador !== false;
        });

        foreach ($filteredPatrocinadores as $patrocinador) {
            $imagePath = public_path($patrocinador->fotoPatrocinador);
            if (file_exists($imagePath) && $patrocinador->fotoPatrocinador) {
                $patrocinador->image_url = asset($patrocinador->fotoPatrocinador);
            } else {
                $patrocinador->image_url = asset('images/patrocinadores/default-logo.png');
            }
        }

        return response()->json([
            'totalPatrocinadores' => $filteredPatrocinadores->count(),
            'data' => $filteredPatrocinadores
        ]);
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


    ////////////////////////////////////////////////////////////////////
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
        try {
            
            $validatedData = $request->validate([
                'fotoPatrocinador' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'nombrePatrocinador' => 'required|string|max:255',
                'representantePatrocinador' => 'required|string|max:255',
                'rfcPatrocinador' => 'required|string|regex:/^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/|max:13',
                'correoPatrocinador' => 'required|string|email|max:255',
                'telefonoPatrocinador' => 'required|string|regex:/^[0-9]+$/|max:15',
                'numeroRepresentantePatrocinador' => 'required|string|regex:/^[0-9]+$/|max:15',
            ], [
                'fotoPatrocinador.file' => 'La foto debe ser un archivo válido.',
                'fotoPatrocinador.mimes' => 'La foto debe ser un archivo de tipo JPG, JPEG o PNG.',
                'fotoPatrocinador.max' => 'La foto no debe exceder los 2 MB.',
                'nombrePatrocinador.required' => 'El nombre del patrocinador es obligatorio.',
                'representantePatrocinador.required' => 'El representante es obligatorio.',
                'rfcPatrocinador.required' => 'El RFC es obligatorio.',
                'rfcPatrocinador.regex' => 'El RFC debe ser válido (4 letras, 6 dígitos y 3 caracteres alfanuméricos).',
                'correoPatrocinador.email' => 'El correo debe ser un email válido.',
                'telefonoPatrocinador.regex' => 'El teléfono debe contener solo números.',
                'numeroRepresentantePatrocinador.regex' => 'El número del representante debe contener solo números.',
            ]);
    
       
            $patrocinador = Patrocinador::create($validatedData);
    
          
            return response()->json([
                'success' => true,
                'message' => 'Patrocinador creado exitosamente.',
                'data' => $patrocinador,
            ], 201);
    
        } catch (ValidationException $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Errores en la validación de los datos.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
           
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al intentar crear el patrocinador.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
        try {
            
            $patrocinador = Patrocinador::findOrFail($id);

          
            $validatedData = $request->validate([
                'fotoPatrocinador' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'nombrePatrocinador' => 'required|string|max:255',
                'representantePatrocinador' => 'required|string|max:255',
                'rfcPatrocinador' => 'required|string|size:13|regex:/^[A-ZÑ&]{3,4}\d{6}[A-Z\d]{3}$/',
                'correoPatrocinador' => 'required|string|email|max:255',
                'telefonoPatrocinador' => 'required|string|regex:/^\d{10}$/',
                'numeroRepresentantePatrocinador' => 'required|string|max:255',
            ], [
                'fotoPatrocinador.file' => 'El archivo de la foto debe ser un archivo válido.',
                'fotoPatrocinador.mimes' => 'La foto debe ser un archivo JPG, JPEG o PNG.',
                'fotoPatrocinador.max' => 'La foto no debe exceder los 2 MB.',
                'nombrePatrocinador.required' => 'El nombre del patrocinador es obligatorio.',
                'representantePatrocinador.required' => 'El representante es obligatorio.',
                'rfcPatrocinador.required' => 'El RFC es obligatorio.',
                'rfcPatrocinador.regex' => 'El RFC debe ser válido (13 caracteres y formato correcto).',
                'correoPatrocinador.email' => 'El correo debe ser un email válido.',
                'telefonoPatrocinador.regex' => 'El teléfono debe contener exactamente 10 dígitos.',
            ]);

           
            $patrocinador->update($validatedData);

           
            return response()->json([
                'success' => true,
                'message' => 'Patrocinador actualizado exitosamente.',
                'data' => $patrocinador,
            ], 200);

        } catch (ModelNotFoundException $e) {
          
            return response()->json([
                'success' => false,
                'message' => 'El patrocinador con el ID especificado no se encontró.',
            ], 404);
        } catch (ValidationException $e) {
     
            return response()->json([
                'success' => false,
                'message' => 'Errores en la validación de los datos.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
      
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado al actualizar el patrocinador.',
                'error' => $e->getMessage(),
            ], 500);
        }
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


