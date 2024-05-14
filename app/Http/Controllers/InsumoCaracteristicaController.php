<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\InsumoCaracteristica;
use Illuminate\Http\Request;

class InsumoCaracteristicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($insumoId, $caracteristicaId)
    {
        $insumo = Insumo::findOrFail($insumoId);
        $caracteristica = InsumoCaracteristica::findOrFail($caracteristicaId);
        return view('crud.caracteristica.edit', compact('insumo', 'caracteristica'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $insumoId, $caracteristicaId)
    {
        $caracteristica = InsumoCaracteristica::findOrFail($caracteristicaId);
        $caracteristica->update($request->all());
    
        return redirect('insumo')->with('Mensaje2','Insumo Actualizada Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
