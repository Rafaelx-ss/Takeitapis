<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Usuario;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            // Validar los datos de entrada
            $validatedData = $request->validate([
                'nombreUsuario' => 'required|string|min:2',
                'usuario' => 'required|string|min:4|unique:usuarios,usuario',
                'correoUsuario' => 'required|email|unique:usuarios,correoUsuario',
                'contrasena' => 'required|string|min:6',
                'telefonoUsuario' => 'nullable|string',
                'fechaNacimientoUsuario' => 'nullable|date',
                'generoUsuario' => 'nullable|in:MASCULINO,FEMENINO,OTRO',
                'rolUsuario' => 'required|in:participante,organizador',
            ]);

            // Crear el usuario (la contraseña ya se encripta en el modelo)
            $user = Usuario::create([
                'nombreUsuario' => $validatedData['nombreUsuario'],
                'usuario' => $validatedData['usuario'],
                'correoUsuario' => $validatedData['correoUsuario'],
                'contrasena' => $validatedData['contrasena'],
                'telefonoUsuario' => $validatedData['telefonoUsuario'] ?? null,
                'fechaNacimientoUsuario' => $validatedData['fechaNacimientoUsuario'] ?? null,
                'generoUsuario' => $validatedData['generoUsuario'] ?? null,
                'rolUsuario' => $validatedData['rolUsuario'],
            ]);

            // Devolver el usuario sin campos sensibles
            return $this->successResponse($user->makeHidden(['contrasena']), 'Usuario registrado exitosamente', 201);

        } catch (ValidationException $e) {
            return $this->errorResponse('Datos de registro inválidos', 400)
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la cuenta', 500);
        }
    }
}
