<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProveedorRequest;
use App\Models\Proveedore;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datosProveedor['proveedores']=Proveedore::paginate(5);
        return view('crud.proveedor.index',$datosProveedor);    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          return view('crud.proveedor.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProveedorRequest $request)
    {
        $datosProveedor=request()->except('_token');
        Proveedore::insert($datosProveedor);
        return redirect('proveedor/create')->with('Mensaje','Proveedor Agregado Correctamente');
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
        $proveedor=Proveedore::findOrFail($id);
        return view('crud.proveedor.edit',compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datosProveedor=request()->except(['_token','_method']);
        Proveedore::where('id','=',$id)->update($datosProveedor);
        return redirect('proveedor')->with('Mensaje2','Proveedor');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Proveedore::destroy($id);
        return redirect('proveedor')->with('Mensaje','Proveedor');
    }
}
