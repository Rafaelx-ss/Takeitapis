<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\DireccionUsuario;

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
        // Validar los datos proporcionados
        $validatedData = $request->validate([
            'key' => 'required|string',
            'valor' => 'required',
        ]);

        // Buscar el usuario por ID
        $user = Usuario::find($usuarioID);
        if (!$user) {
            return response()->json(["message" => "Usuario no encontrado"], 404);
        }

        // Validar que el key proporcionado sea un campo válido
        $validKeys = [
            'nombreUsuario',
            'usuario',
            'email',
            'password',
            'telefonoUsuario',
            'fechaNacimientoUsuario',
            'generoUsuario',
            'rolUsuario',
            'direccion'
        ];

        // Actualizar el campo especificado con el nuevo valor
        $key = $validatedData['key'];
        $valor = $validatedData['valor'];

        if (in_array($validatedData['key'], $validKeys)) {
            if ($key === 'direccion') {
                // Buscar en la tabla direccionesusuarios y actualizar
                $direccion = DireccionUsuario::where('usuarioID', $usuarioID)->first();
                if (!$direccion) {
                    $direccion = new DireccionUsuario();
                    $direccion->usuarioID = $usuarioID;
                    $direccion->activoDireccion = 1;
                    $direccion->estadoDireccion = 1;
                    $direccion->cpDireccion = 0;
                    $direccion->municipioDireccion = '';
                    $direccion->estadoID = 1;   
                    $direccion->direccion = $valor;
                    $direccion->save();

                }else {
                    $direccion->direccion = $valor;
                    $direccion->save();
                }
                
            } else { 
                if ($key === 'password') {
                    $user->$key = bcrypt($valor);
                }  else {
                    $user->$key = $valor;
                }

                $user->save();
            }
        }else {
            return response()->json(["message" => "Campo inválido"], 400);
        }

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



