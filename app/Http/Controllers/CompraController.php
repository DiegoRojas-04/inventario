<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Insumo;
use App\Models\Presentacione;
use App\Models\Servicio;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datosCompra['compras']=Compra::paginate(5);
        return view('crud.compra.index',$datosCompra);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $insumos = Insumo::all();
        $servicios = Servicio::all();
        $comprobantes = Comprobante::all();
        $categorias = Categoria::all();
        return view('crud.compra.create',compact('insumos','servicios','comprobantes','categorias'));

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
