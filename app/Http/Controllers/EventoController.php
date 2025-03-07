<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Subcategoria;
use App\Helpers\ResponseHelper;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 
use App\Models\Qr_code;
use App\Models\Usuario;


class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Evento::all();
        return ResponseHelper::success('Lista de eventos obtenida exitosamente', $eventos);
    }

    public function page(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 10; 

        $eventos = Evento::select('*')->where('estadoEvento', 1)->paginate($perPage);

        return ResponseHelper::success('Eventos paginados obtenidos exitosamente', $eventos);
    }
    
    /**
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
    public function store(Request $request, $usuarioID)
    {
        $nuevaSubcategoria = null;

        if($request->input('subCategoriaID') == 0){
            $nuevaSubcategoria = Subcategoria::create([
                'categoriaID' => $request->input('categoriaID'),
                'nombreSubcategoria' => $request->input('nuevaSubcategoria'), 
                'descripcionSubcategoria' => "Esta categoría fué creada por un usuario",
                'activoSubcategoria' => 1,
                'estadoSubcategoria' => 1
            ]);
        }

        $usuario = Usuario::find($usuarioID);

        if(!$usuario){
            return ResponseHelper::error('Usuario no encontrado', [], 404);
        }

        $request->merge(['createby' => $usuario->usuarioID]);

        // -- Ejemplo de como se guarda en la base de datos los costos
        // -- "costoEvento": [
        // --     {
        // --         "nombre": "entrada_general",
        // --         "precio": 10
        // --     },
        // --     {
        // --         "nombre": "entrada_vip",
        // --          "precio": 20
        // --     },
        // --     {
        // --        "nombre": "entrada_palco",
        // --        "precio": 30
        // --     }
        // --     ]

        // Ejemplo de lo que trae el backend:
        // {
        //     "nombreEvento": "TESTESTTESTEST",
        //     "categoriaID": 11,
        //     "subCategoriaID": 24,
        //     "lugarEvento": "TESTESTTESTEST",
        //     "maximoParticipantesEvento": 1,
        //     "costoEvento": 1,
        //     "descripcionEvento": "TESTESTTESTESTTESTEST",
        //     "cpEvento": "97160",
        //     "municioEvento": "Merida",
        //     "estadoID": 31,
        //     "direccionEvento": "TESTESTTESTESTTESTEST",
        //     "telefonoEvento": "9999583010",
        //     "fechaEvento": "2025-03-06",
        //     "horaEvento": "21:04",
        //     "duracionEvento": 1,
        //     "kitEvento": "TESTEST",
        //     "nuevaSubcategoria": "",
        //     "nombreTipoEntrada2": "VIP",
        //     "costoTipoEntrada2": 2,
        //     "nombreTipoEntrada3": "PREMIUN",
        //     "costoTipoEntrada3": 3,
        //     "countCostoEvento": 3,
        //     "categoriaNombre": "",
        //     "subCategoriaNombre": "",
        //     "tipo_creador": "O",
        //     "imagen_evento": null
        //   }


        $costoEvento = [];

        if ($request->input('countCostoEvento') >= 1) {
            $costoEvento[] = [
                'nombre' => "entrada_general",
                'precio' => $request->input('costoEvento') ?? 0
            ];
        }

        if ($request->input('countCostoEvento') >= 2) {
            $costoEvento[] = [
                'nombre' => $request->input('nombreTipoEntrada2') ?? "Entrada VIP",
                'precio' => $request->input('costoTipoEntrada2') ?? 0
            ];
        }

        if ($request->input('countCostoEvento') == 3) {
            $costoEvento[] = [
                'nombre' => $request->input('nombreTipoEntrada3') ?? "Entrada Palco",
                'precio' => $request->input('costoTipoEntrada3') ?? 0
            ];
        }

        $request->merge(['costoEvento' => json_encode($costoEvento)]);



        $validatedData = $request->validate([
            'categoriaID' => 'required|integer|exists:categorias,categoriaID',
            'subCategoriaID' => 'required|integer|exists:subcategorias,subcategoriaID',
            'nombreEvento' => 'required|string|max:255',
            'lugarEvento' => 'required|string|max:255',
            'maximoParticipantesEvento' => 'nullable|integer|min:1|max:10000',
            // 'costoEvento' => 'nullable|numeric|min:0',
            'costoEvento' => 'json|required',
            'descripcionEvento' => 'nullable|string|max:500',
            'cpEvento' => 'required|string|size:5|regex:/^\d{5}$/',
            'municioEvento' => 'required|string|max:100',
            'estadoID' => 'required|integer|exists:estados,estadoID',
            'direccionEvento' => 'required|string|max:255',
            'telefonoEvento' => 'required|string|regex:/^\d{10}$/',
            'fechaEvento' => 'required|date|',
            'horaEvento' => 'required|date_format:H:i',
            'duracionEvento' => 'required|integer|min:1|max:48',
            'kitEvento' => 'required|string|max:255',
            'tipo_creador' => 'required|string|in:O,E',
            'createby' => 'required|integer|exists:usuarios,usuarioID',
        ], [
            'categoriaID.required' => 'La categoría es obligatoria.',
            'nombreEvento.required' => 'El nombre del evento es obligatorio.',
            'fechaEvento.after' => 'La fecha del evento debe ser posterior al día de hoy.',
            'telefonoEvento.regex' => 'El teléfono debe tener exactamente 10 dígitos.',
            'horaEvento.date_format' => 'La hora del evento debe estar en el formato HH:mm.',
            'duracionEvento.min' => 'La duración mínima del evento es de 1 hora.',
            'duracionEvento.max' => 'La duración máxima del evento es de 48 horas.',
            'tipo_creador.in' => 'El tipo de creador debe ser O o E.',
            'createby.required' => 'El creador es obligatorio.',
            'createby.exists' => 'El creador no existe.',
        ]);

        try {
            $evento = Evento::create($validatedData);
            if($evento){
                $evento->usuarios()->attach($usuarioID);
                return ResponseHelper::success('Evento creado exitosamente', $evento, 201);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No se pudo crear el evento. Por favor verifique los datos e intente nuevamente.',
                ];
                error_log(json_encode($response, JSON_PRETTY_PRINT));
                return response()->json($response, 422);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error('Ocurrió un error al crear el evento', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($eventoID)
    {
        $evento = Evento::find($eventoID);
    
        if (!$evento) {
            return ResponseHelper::error('Evento no encontrado', [], 404);
        }
    
        return ResponseHelper::success('Evento obtenido exitosamente', $evento);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $eventoID)
    {

        //
        $eventos = Evento::find($eventoID);

        if (!$eventos) {
            return response()->json(['error' => 'Eventos no encontrada'], 404);
        }



        $validatedData = $request->validate([
            'categoriaID' => 'required|integer|exists:categorias,categoriaID',
            'subCategoriaID' => 'required|integer|exists:subcategorias,subcategoriaID',
            'nombreEvento' => 'required|string|max:255',
            'lugarEvento' => 'required|string|max:255',
            'maximoParticipantesEvento' => 'nullable|integer|min:1|max:10000',
            'costoEvento' => 'nullable|numeric|min:0',
            'descripcionEvento' => 'nullable|string|max:500',
            'cpEvento' => 'required|string|size:5|regex:/^\d{5}$/',
            'municioEvento' => 'required|string|max:100',
            'estadoID' => 'required|integer|exists:estados,estadoID',
            'direccionEvento' => 'required|string|max:255',
            'telefonoEvento' => 'required|string|regex:/^\d{10}$/',
            'fechaEvento' => 'required|date|',
            'horaEvento' => 'required|date_format:H:i',
            'duracionEvento' => 'required|integer|min:1|max:48',
            'kitEvento' => 'required|string|max:255',
        ], [
            'categoriaID.required' => 'La categoría es obligatoria.',
            'nombreEvento.required' => 'El nombre del evento es obligatorio.',
            'fechaEvento.after' => 'La fecha del evento debe ser posterior al día de hoy.',
            'telefonoEvento.regex' => 'El teléfono debe tener exactamente 10 dígitos.',
            'horaEvento.date_format' => 'La hora del evento debe estar en el formato HH:mm.',
            'duracionEvento.min' => 'La duración mínima del evento es de 1 hora.',
            'duracionEvento.max' => 'La duración máxima del evento es de 48 horas.',
        ]);



        try {
            $eventos->update($validatedData);
            $response = [
                'success' => true,
                'message' => 'Evento actualizado exitosamente.',
                'data' => $eventos,
            ];
            error_log(json_encode($response, JSON_PRETTY_PRINT));
            return response()->json($response, 200);
        } catch (ModelNotFoundException $e) {
            $response = [
            'success' => false,
            'message' => 'El evento con el ID especificado no se encontró.',
            ];
            error_log(json_encode($response, JSON_PRETTY_PRINT));
            return response()->json($response, 404);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Ocurrió un error al actualizar el evento. Por favor, inténtalo de nuevo.',
                'error' => $e->getMessage(),
            ];
            error_log(json_encode($response, JSON_PRETTY_PRINT));
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($eventoID)
    {
        $evento = Evento::find($eventoID);
    
        if (!$evento) {
            return ResponseHelper::error('Evento no encontrado', [], 404);
        }
    
        $evento->estadoEvento = 0;
        $evento->save();
    
        return ResponseHelper::success('Evento eliminado exitosamente', null);
    }
    
    public function filter(Request $request)
    {
        $query = Evento::query();

        $filters = [
            'eventoID' => '=',
            'patrocinadorID' => '=',
            'categoriaID' => '=',
            'subCategoriaID' => '=',
            'nombreEvento' => 'like',
            'lugarEvento' => 'like',
            'maximoParticipantesEvento' => 'like',
            'costoEvento' => 'like',
            'descripcionEvento' => 'like',
            'cpEvento' => 'like',
            'municioEvento' => 'like',
            'estadoID' => '=',
            'direccionEvento' => 'like',
            'telefonoEvento' => 'like',
            'fechaEvento' => 'like',
            'duracionEvento' => 'like',
            'kitEvento' => 'like',
            'activoEvento' => '=',
            'estadoEvento' => '=',
            'created_at' => 'like',
            'updated_at' => 'like'
        ];

        foreach ($filters as $field => $operator) {
            if ($request->has($field)) {
            $value = $request->input($field);
            $query->where($field, $operator, $operator === 'like' ? "%$value%" : $value);
            }
        }

        return ResponseHelper::success('Eventos filtrados obtenidos exitosamente', $query->get());
    }

    public function toggle($id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return ResponseHelper::error('Evento no encontrado', [], 404);
        }
        $evento->activoEvento = !$evento->activoEvento;
        $evento->save();

        return ResponseHelper::success('ActivoEvento evento actualizado exitosamente', $evento);
    }

    public function miseventos(Request $request, $usuarioID)
    {
        $page = $request->input('page', 1);
        $itemsPerPage = $request->input('itemsPerPage', 10);
        $sortColumn = $request->input('sortColumn', 'eventos.eventoID'); 
        $sortDirection = $request->input('sortDirection', 'asc');
    
        $query = Evento::join('usuarioseventos', 'eventos.eventoID', '=', 'usuarioseventos.eventoID')
            ->where('usuarioseventos.usuarioID', $usuarioID)
            ->select(
                'eventos.eventoID',
                'eventos.nombreEvento',
                'eventos.fechaEvento',
                'eventos.horaEvento', 
                'eventos.lugarEvento',
                'eventos.direccionEvento',
                'eventos.costoEvento',
                'eventos.maximoParticipantesEvento',
                'eventos.activoEvento'
            );

        if ($sortColumn) {
            $query->orderBy($sortColumn, $sortDirection);
        }
    
        $eventos = $query->paginate($itemsPerPage, ['*'], 'page', $page);
    
        return response()->json([
            'eventos' => $eventos->items(),
            'totalItems' => $eventos->total()
        ]);
    }

    public function eventosstarting()
    {
        $eventos = Evento::where('fechaEvento', '>', date('Y-m-d'))
            ->where('fechaEvento', '<=', date('Y-m-d', strtotime('+5 days')))
            ->where('estadoEvento', 1)
            ->where('tipo_creador', 'O')
            ->select('eventoID', 'nombreEvento', 'fechaEvento')
            ->orderBy('fechaEvento', 'asc')
            ->limit(5)
            ->get();

        foreach ($eventos as $evento) {
            $evento->imagenEvento = 'images/eventos/mario-kart.png';
        }
            

        return ResponseHelper::success('Eventos próximos a iniciar obtenidos exitosamente', $eventos);
    }

    public function usuario($usuarioID)
    {
        $eventos = Evento::whereHas('usuarios', function ($query) use ($usuarioID) {
            $query->where('usuarios.usuarioID', $usuarioID);
        })
        ->join('categorias', 'eventos.categoriaID', '=', 'categorias.categoriaID') // Hacemos el JOIN
        ->select('eventos.eventoID', 'eventos.nombreEvento', 'categorias.nombreCategoria', 'eventos.fechaEvento', 'eventos.lugarEvento', 'eventos.costoEvento')
        ->orderBy('eventos.fechaEvento', 'desc')  // Ordenar por fecha de manera descendente
        ->get();
    
        foreach ($eventos as $evento) {
            $evento->imagenEvento = 'images/eventos/mario-kart.png';
        }
    
        return ResponseHelper::success('Eventos del usuario obtenidos exitosamente', $eventos);
    }

    public function admin($usuarioID, Request $request)
{
    $page = $request->query('page', 1);
    $limit = $request->query('limit', 10);
    $offset = ($page - 1) * $limit;

    $eventos = Evento::whereHas('usuarios', function ($query) use ($usuarioID) {
            $query->where('usuarios.usuarioID', $usuarioID);
        })
        ->join('categorias', 'eventos.categoriaID', '=', 'categorias.categoriaID')
        ->select(
            'eventos.eventoID', 
            'eventos.nombreEvento', 
            'categorias.nombreCategoria as categoriaNombre', 
            'eventos.fechaEvento', 
            'eventos.lugarEvento', 
            'eventos.costoEvento'
        )
        ->offset($offset)
        ->limit($limit)
        ->get();

    foreach ($eventos as $evento) {
        $evento->imagenEvento = 'images/eventos/mario-kart.png';
    }

    return ResponseHelper::success('Eventos del usuario obtenidos exitosamente', $eventos);
}


    public function inscribirUsuario(Request $request)
    {
        // $qr_code = [];
        // $qr_code['qr_code'] = 'qr_codes/evento_7_usuario_2_xS4urpNGI0.svg'; 

        // return ResponseHelper::success('Prueba de exutito', [$qr_code], 200);

        $usuarioID = $request->input('usuarioID');
        $eventoID = $request->input('eventoID');
    
        $evento = Evento::find($eventoID);
    
        if (!$evento) {
            return ResponseHelper::error('Evento no encontrado', [], 404);
        }
    
        // Verificar si el usuario ya está inscrito para evitar duplicados
        if ($evento->usuarios()->where('usuarios.usuarioID', $usuarioID)->exists()) {
            return ResponseHelper::error('¡Ya te has inscrito al evento!', [], 400);
        }
    
        // Generar la información del QR
        $qrData = json_encode([
            'usuarioID' => $usuarioID,
            'eventoID' => $eventoID,
            'nombreEvento' => $evento->nombreEvento,
            'fechaEvento' => $evento->fechaEvento
        ]);
    
        // Nombre del archivo QR en formato SVG
        $qrFileName = "qr_codes/evento_{$eventoID}_usuario_{$usuarioID}_" . Str::random(10) . "_" . now()->timestamp . ".svg";
    
        // Generar el QR en formato SVG en lugar de PNG
        $qrImage = QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H')
            ->generate($qrData);
        
        if(!$qrImage){
            return ResponseHelper::error('No se pudo generar el QR', [], 400);
        }
    
        // Guardar el QR en el almacenamiento público
        if(!Storage::disk('public')->put($qrFileName, $qrImage)){
            return ResponseHelper::error('No se pudo guardar el QR', [], 400);
        }

        // Inscribir al usuario en el evento
        // if(!){
        //     return ResponseHelper::error('No se pudo inscribir al usuario en el evento', [], 400);
        // }
        $evento->usuarios()->attach($usuarioID);

        // Guardar el QR en la base de datos
        $qrCode = new Qr_code();
        $qrCode->eventoID = $eventoID;
        $qrCode->usuarioID = $usuarioID;
        $qrCode->rutaqr = $qrFileName;

        if(!$qrCode->save()){
            return ResponseHelper::error('No se pudo guardar el QR en la base de datos', [], 400);
        }
    
        // Obtener la URL del QR para acceso público
        // $qrUrl = asset("storage/{$qrFileName}"); // <- {http://localhost:8000/storage/qr_codes/evento_1_usuario_1_1712987400.svg}
    
        return ResponseHelper::success('Usuario inscrito y QR generado exitosamente', [$qrCode]);
    }
}
