<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInsumoRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use App\Models\Insumo;
use App\Models\Marca;
use App\Models\Presentacione;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datosInsumo['insumos'] = Insumo::paginate(10);
        $categorias = Categoria::all();
        return view('crud.insumo.index', $datosInsumo)->with('categorias', $categorias); 
       }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::where('estado', 1)->get();
        $marcas = Marca::where('estado', 1)->get();
        $presentaciones = Presentacione::where('estado', 1)->get();

        // Obtener todas las características disponibles de los insumos
        $variantes = Caracteristica::all();

        return view('crud.insumo.create', compact('categorias', 'presentaciones', 'marcas', 'variantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInsumoRequest $request)
    {
        $datosInsumo = request()->except('_token');
        Insumo::insert($datosInsumo);
        return redirect('insumo/create')->with('Mensaje', 'Insumo');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $post = Insumo::find($id);
        // return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $insumo = Insumo::findOrFail($id);
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $presentaciones = Presentacione::all();
        $caracteristicas = $insumo->caracteristicas;
        return view('crud.insumo.edit', compact('insumo', 'categorias', 'marcas', 'presentaciones', 'caracteristicas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $insumo = Insumo::findOrFail($id);

        $insumo->nombre = $request->input('nombre');
        $insumo->descripcion = $request->input('descripcion');
        $insumo->requiere_invima = $request->has('requiere_invima') ? 1 : 0;
        $insumo->requiere_lote = $request->has('requiere_lote') ? 1 : 0;
        $insumo->id_categoria = $request->input('id_categoria');
        $insumo->id_marca = $request->input('id_marca');
        $insumo->id_presentacion = $request->input('id_presentacion');
        $insumo->riesgo = $request->input('riesgo');
        $insumo->vida_util = $request->input('vida_util');
        $insumo->stock = $request->input('stock');

        $insumo->save();
        return redirect('insumo')->with('Mensaje2', 'Insumo Actualizada Correctamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Insumo::destroy($id);
        return redirect('insumo')->with('Mensaje', 'insumo');
    }

    
}
