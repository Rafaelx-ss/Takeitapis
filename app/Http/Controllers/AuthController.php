<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Helpers\ResponseHelper;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verificarcuenta']]);
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

            return ResponseHelper::success('Usuario registrado exitosamente', 
                $user->makeHidden(['password']), 201);

        } catch (ValidationException $e) {
            return ResponseHelper::error('Datos de registro inválidos', $e->errors(), 400);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al crear la cuenta', ['error' => $e->getMessage()], 500);
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
            // Validar las credenciales
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
    
            error_log('Intento de inicio de sesión con email: ' . $credentials['email']);
    
            // Intentar autenticar al usuario
            if (!$token = Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                // $response = [
                //     'success' => false,
                //     'message' => 'Credenciales inválidas',
                // ];
    
                // error_log(json_encode($response, JSON_PRETTY_PRINT));
                // return response()->json($response, 401);
                return ResponseHelper::error('Credenciales inválidas', [], 401);
            }
    
            // Obtener el usuario autenticado
            $user = Auth::user();
            error_log('Usuario autenticado: ' . $user->email);
    
            // Guardar el token en el usuario si es una instancia de Usuario
            if ($user instanceof Usuario) {
                $user->remember_token = $token;
                $user->save();
                error_log('Token guardado para el usuario: ' . $user->email);
            }
    
            // Devolver una respuesta exitosa
            // $response = [
            //     'success' => true,
            //     'message' => 'Inicio de sesión exitoso',
            //     'data' => [
            //         'user' => $user,
            //         'token' => $token,
            //         'token_type' => 'bearer',
            //         'expires_in' => Auth::factory()->getTTL() * 60,
            //     ],
            // ];
    
            // error_log(json_encode($response, JSON_PRETTY_PRINT));
            // return response()->json($response, 200);

            //Helper retorna lo mismo en el mismo formato que lo de arriba
            return ResponseHelper::success('Inicio de sesión exitoso', [
                'user' => $user,
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
                ]
            );
    
        } catch (ValidationException $e) {
            // $response = [
            //     'success' => false,
            //     'message' => 'Datos de inicio de sesión inválidos',
            //     'errors' => $e->errors(),
            // ];
    
            // error_log(json_encode($response, JSON_PRETTY_PRINT));
            // return response()->json($response, 400);

            return ResponseHelper::error('Datos de inicio de sesión inválidos', ['error' => $e->getMessage()]);


    
        } catch (\Exception $e) {
            // $response = [
            //     'success' => false,
            //     'message' => 'Error al iniciar sesión',
            //     'errors' => ['error' => $e->getMessage()],
            // ];
    
            // error_log(json_encode($response, JSON_PRETTY_PRINT));
            // return response()->json($response, 500);

            return ResponseHelper::error('Error al iniciar sesión', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = Auth::user();
        return ResponseHelper::success('Usuario autenticado obtenido exitosamente', $user);
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
            return ResponseHelper::success('Sesión cerrada exitosamente', null);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al cerrar sesión', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            $token = Auth::refresh();
            return ResponseHelper::success('Token renovado exitosamente', [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
            ]);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al renovar el token', ['error' => $e->getMessage()], 500);
        }
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

    public function verificarcuenta(Request $request)
    {

        $request->validate([
            'nombreUsuario' => 'required|string',
            'email' => 'required|email',
        ]);

    
        $nombreUsuario = $request->input('nombreUsuario');
        $email = $request->input('email');

        $existeNombreUsuario = Usuario::where('nombreUsuario', $nombreUsuario)->exists();

        $existeEmail = Usuario::where('email', $email)->exists();


        if ($existeNombreUsuario || $existeEmail) {
            return response()->json([
                'success' => false,
                'message' => 'El nombre de usuario o el correo electrónico ya están registrados.',
                'errors' => [
                    'nombreUsuario' => $existeNombreUsuario ? 'El nombre de usuario ya está en uso.' : null,
                    'email' => $existeEmail ? 'El correo electrónico ya está en uso.' : null,
                ]
            ], 200);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'El nombre de usuario y el correo electrónico están disponibles.',
        ]);
    }
}
