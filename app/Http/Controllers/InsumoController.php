<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInsumoRequest;
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
        $datosInsumo['insumos']=Insumo::paginate(5);
        return view('crud.insumo.index',$datosInsumo);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::where('estado', 1)->get();
        $marcas = Marca::where('estado', 1)->get();
        $presentaciones = Presentacione::where('estado', 1)->get();
        return view('crud.insumo.create', compact('categorias','presentaciones','marcas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInsumoRequest $request)
    {
        $datosInsumo=request()->except('_token');       
        Insumo::insert($datosInsumo);
        return redirect('insumo/create')->with('Mensaje','Insumo');
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
        $insumo=Insumo::findOrFail($id);
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $presentaciones = Presentacione::all();
        return view('crud.insumo.edit', compact('insumo','categorias','marcas','presentaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datosInsumo=request()->except(['_token','_method']);
        Insumo::where('id','=',$id)->update($datosInsumo);
  
        return redirect('insumo')->with('Mensaje2','Insumo Actualizada Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Insumo::destroy($id);
        return redirect('insumo')->with('Mensaje','insumo');
    }
}
