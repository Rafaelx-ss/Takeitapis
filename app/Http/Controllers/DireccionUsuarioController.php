<?php

namespace App\Http\Controllers;

use App\Models\DireccionUsuario;
use Illuminate\Http\Request;

class DireccionUsuarioController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $direccionesUsuario = DireccionUsuario::all();
        return response()->json($direccionesUsuario);
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
    public function show(DireccionUsuario $direccionUsuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DireccionUsuario $direccionUsuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DireccionUsuario $direccionUsuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DireccionUsuario $direccionUsuario)
    {
        //
    }
}
