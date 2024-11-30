<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


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
                'email' => 'required|email|max:150|unique:usuarios,email',
                'password' => 'required|string|min:6|max:100',
                'telefonoUsuario' => 'nullable|string|min:8|max:15',
                'fechaNacimientoUsuario' => 'nullable|date',
                'generoUsuario' => 'nullable|in:MASCULINO,FEMENINO,OTRO',
                'rolUsuario' => 'required|in:participante,organizador',
            ]);


            $user = Usuario::create($validatedData);

            return $this->successResponse($user->makeHidden(['password']), 'Usuario registrado exitosamente', 201);

        } catch (ValidationException $e) {
            return $this->errorResponse('Datos de registro inválidos', 400, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la cuenta', 500, ['error' => $e->getMessage()]);
        }
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (!$token = Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                return $this->errorResponse('Credenciales inválidas', 401);
            }

            $user = Auth::user();

            return $this->successResponse([
                'user' => $user,
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ], 'Inicio de sesión exitoso');

        } catch (ValidationException $e) {
            return $this->errorResponse('Datos de inicio de sesión inválidos', 400, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse('Error al iniciar sesión', 500, ['error' => $e->getMessage()]);
        }
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            return $this->successResponse(null, 'Sesión cerrada exitosamente');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al cerrar sesión', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
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
