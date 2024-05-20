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

   public function index(Request $request)
{
    $query = Insumo::query();
    $categorias = Categoria::all();

    // Filtrar por categoría si se proporciona
    if ($request->has('id_categoria') && !empty($request->id_categoria)) {
        $query->where('id_categoria', $request->id_categoria);
    }

    // Filtrar y ordenar por estado (primero estado 1, luego estado 0)
    $insumos = $query->orderBy('estado', 'desc')->paginate($request->input('page_size', 10));

    return view('crud.insumo.index', compact('insumos', 'categorias'));
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
        //
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
        $request->validate([
            'nombre' => 'required|max:60|unique:insumos,nombre,' . $id,
            'descripcion' => 'nullable|max:255',
        ]);
        $insumo = Insumo::findOrFail($id);
        $insumo->fill([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'requiere_invima' => $request->filled('requiere_invima')  ? 1 : 0,
            'requiere_lote' => $request->filled('requiere_lote') ? 1 : 0,
            'id_categoria' => $request->input('id_categoria'),
            'id_marca' => $request->input('id_marca'),
            'id_presentacion' => $request->input('id_presentacion'),
            'riesgo' => $request->input('riesgo'),
            'vida_util' => $request->input('vida_util'),
            // 'stock' => $request->input('stock'),
        ]);
        $insumo->save();
        return redirect('insumo')->with('Mensaje2', 'Insumo Actualizada Correctamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
  {
    $insumo = Insumo::find($id);
    if ($insumo) {
      if ($insumo->estado == 1) {
        $insumo->update([
          'estado' => 0
        ]);
        return redirect('insumo')->with('Mensaje', 'insumo eliminada');
      } else {
        $insumo->update([
          'estado' => 1
        ]);
        return redirect('insumo')->with('Mensaje3', 'insumo restaurada');
      }
    } else {
      return redirect('insumo')->with('Mensaje', 'insumo no encontrada');
    }
  }
}
