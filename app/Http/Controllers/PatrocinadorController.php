<?php

namespace App\Http\Controllers;

use App\Models\Patrocinador;
use Illuminate\Http\Request;

class PatrocinadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $patrocinador = Patrocionador::all();
        return response()->json($patrocinador);
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
    public function show(Patrocinador $patrocinador)
    {
        //
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
    public function update(Request $request, Patrocinador $patrocinador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patrocinador $patrocinador)
    {
        //
    }
}
