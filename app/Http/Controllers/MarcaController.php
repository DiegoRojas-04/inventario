<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMarcaRequest;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $datosMarca['marcas']=Marca::paginate(10);
      return view('crud.marca.index',$datosMarca);    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud.marca.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcaRequest $request)
    {
      $datosMarca=request()->except('_token');
      Marca::insert($datosMarca);
      return redirect('marca/create')->with('Mensaje','Marca');  

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
    public function edit($id)
    {
      $marca=Marca::findOrFail($id);
      return view('crud.marca.edit',compact('marca'));
    }
  
      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, $id)
      {
        $datosMarca=request()->except(['_token','_method']);
        Marca::where('id','=',$id)->update($datosMarca);
        return redirect('marca')->with('Mensaje2','Marca');
  
      }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
  {
    $marca = Marca::find($id);
    if ($marca) {
      if ($marca->estado == 1) {
        $marca->update([
          'estado' => 0
        ]);
        return redirect('marca')->with('Mensaje', 'marca eliminada');
      } else {
        $marca->update([
          'estado' => 1
        ]);
        return redirect('marca')->with('Mensaje3', 'marca restaurada');
      }
    } else {
      return redirect('marca')->with('Mensaje', 'marca no encontrada');
    }
  }
}
