<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $datosCategoria['categorias'] = Categoria::paginate(5);
    return view('crud.categoria.index', $datosCategoria);
  }
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('crud.categoria.create');
  }

  /**
   * Store a newly created resource in storage.
   */

  public function store(StoreCategoriaRequest $request)
  {
    $datosCategoria = request()->except('_token');
    Categoria::insert($datosCategoria);
    return redirect('categoria/create')->with('Mensaje', 'Categoria');
  }
  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Categoria $categoria, $id)
  {
    $categoria = Categoria::findOrFail($id);
    return view('crud.categoria.edit', compact('categoria'));
  }
  
  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateCategoriaRequest $request, string $id,)
  {

    $datosCategoria = request()->except(['_token', '_method']);
    Categoria::where('id', '=', $id)->update($datosCategoria);
    return redirect('categoria')->with('Mensaje2', 'Categoria');
  }

  /**
   * Remove the specified resource from storage.
   */

  public function destroy($id)
  {
    $categoria = Categoria::find($id);
    if ($categoria) {
      if ($categoria->estado == 1) {
        $categoria->update([
          'estado' => 0
        ]);
        return redirect('categoria')->with('Mensaje', 'Categoria eliminada');
      } else {
        $categoria->update([
          'estado' => 1
        ]);
        return redirect('categoria')->with('Mensaje3', 'Categoria restaurada');
      }
    } else {
      return redirect('categoria')->with('Mensaje', 'Categoria no encontrada');
    }
  }
}
