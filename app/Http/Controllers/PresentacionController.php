<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePresentacioneRequest;
use App\Models\Presentacione;
use Illuminate\Http\Request;

class PresentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datosPresentacion['presentaciones']=Presentacione::paginate(5);
        return view('crud.presentacion.index',$datosPresentacion);    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud.presentacion.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacioneRequest $request)
    {
        $datosPresentacion=request()->except('_token');
        Presentacione::insert($datosPresentacion);
        return redirect('presentacion/create')->with('Mensaje','Presentacion');  
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
        $presentacion=Presentacione::findOrFail($id);
        return view('crud.presentacion.edit',compact('presentacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datosPresentacion=request()->except(['_token','_method']);
        Presentacione::where('id','=',$id)->update($datosPresentacion);
        return redirect('presentacion')->with('Mensaje','Presentacion');
  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { 
        Presentacione::destroy($id);
        return redirect('presentacion')->with('Mensaje2','Presentacion');

    }
}
