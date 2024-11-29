<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
            $validatedData = $request->validate([
                'nombreUsuario' => 'required|string|min:2|max:100',
                'usuario' => 'required|string|min:4|max:50|unique:usuarios,usuario',
                'correoUsuario' => 'required|email|max:150|unique:usuarios,correoUsuario',
                'contrasena' => 'required|string|min:6|max:100',
                'telefonoUsuario' => 'nullable|string|min:8|max:15',
                'fechaNacimientoUsuario' => 'nullable|date',
                'generoUsuario' => 'nullable|in:MASCULINO,FEMENINO,OTRO',
                'rolUsuario' => 'required|in:participante,organizador',
            ]);

            $user = Usuario::create([
                'nombreUsuario' => $validatedData['nombreUsuario'],
                'usuario' => $validatedData['usuario'],
                'correoUsuario' => $validatedData['correoUsuario'],
                'contrasena' => Hash::make($validatedData['contrasena']), // Encriptar la contraseña
                'telefonoUsuario' => $validatedData['telefonoUsuario'] ?? null,
                'fechaNacimientoUsuario' => $validatedData['fechaNacimientoUsuario'] ?? null,
                'generoUsuario' => $validatedData['generoUsuario'] ?? null,
                'rolUsuario' => $validatedData['rolUsuario'],
            ]);

            return $this->successResponse($user->makeHidden(['contrasena']), 'Usuario registrado exitosamente', 201);

        } catch (ValidationException $e) {
            return $this->errorResponse('Datos de registro inválidos', 400, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la cuenta', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Inicia sesión con credenciales válidas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'usuario' => 'required|string',
                'contrasena' => 'required|string',
            ]);

            if (Auth::attempt(['usuario' => $credentials['usuario'], 'password' => $credentials['contrasena']])) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;

                return $this->successResponse([
                    'user' => $user,
                    'token' => $token,
                ], 'Inicio de sesión exitoso');
            }

            return $this->errorResponse('Credenciales inválidas', 401);

        } catch (ValidationException $e) {
            return $this->errorResponse('Datos de inicio de sesión inválidos', 400, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse('Error al iniciar sesión', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Cierra la sesión del usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->successResponse(null, 'Sesión cerrada exitosamente');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al cerrar sesión', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Recupera la información del usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo(Request $request)
    {
        try {
            $user = $request->user();

            return $this->successResponse($user->makeHidden(['contrasena']), 'Información del usuario');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener la información del usuario', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Respuesta estándar de éxito.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = '', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Respuesta estándar de error.
     *
     * @param  string  $message
     * @param  int  $status
     * @param  array|null  $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $status = 500, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
