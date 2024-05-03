<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Insumo;
use Illuminate\Http\Request;

class EntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datosEntrega['entregas']=Entrega::paginate(5);
        return view('crud.entrega.index',$datosEntrega);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $insumos = Insumo::all();
        return view('crud.entrega.create',compact('insumos'));    

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
