<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function page(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 10; 

        $usuarios = Usuario::select('usuarioID', 'nombreUsuario', 'email', 'rolUsuario')->paginate($perPage);
        
        return response()->json($usuarios);
    }

    public function update(Request $request, $usuarioID)
    {
        try {
            $validatedData = $request->validate([
                'nombreUsuario' => 'required|string|min:2|max:100',
                'usuario' => 'required|string|min:4|max:50',
                'email' => 'required|email|max:150',
                'password' => 'required|string|min:6|max:100',
                'telefonoUsuario' => 'nullable|string|min:8|max:15',
                'fechaNacimientoUsuario' => 'nullable|date',
                'generoUsuario' => 'nullable|in:MASCULINO,FEMENINO,OTRO',
                'rolUsuario' => 'required|in:participante,organizador',
            ]);

            $user = Usuario::find($usuarioID);
            if (!$user) {
                return response()->json(["message" => "Usuario no encontrado"], 404);
            }

            $user->update($validatedData);

            return response()->json("Usuario editado exitosamente", 200);

        } catch (ValidationException $e) {
            return response()->json(["message" => "Datos de registro inválidos", "error" => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error al editar el usuario", "error" => $e->getMessage()], 500);
        }
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
    }

    /**
     * Display the specified resource.
     */
    public function show($usuarioID)
    {
        $usuario = Usuario::select('*')
                        ->find($usuarioID);

        return response()->json($usuario);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($usuarioID)
    {
        $usuario = Usuario::find($usuarioID);
        $usuario->estadoUsuario = 0;
        $usuario->save();
        return response()->json("Usuario eliminado exitosamente", 200);
    }
}



