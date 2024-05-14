<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Insumo;
use App\Models\InsumoCaracteristica;
use App\Models\Presentacione;
use App\Models\Proveedore;
use App\Models\Servicio;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with('comprobante')->where('estado', 1)->latest()->get();
        return view('crud.compra.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $insumos = Insumo::where('estado', 1)->get();
        $proveedores = Proveedore::where('estado', 1)->get();
        $comprobantes = Comprobante::all();
        return view('crud.compra.create', compact('insumos', 'proveedores', 'comprobantes',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        try {
            DB::beginTransaction();
    
            $compra = Compra::create($request->validated());
    
            // Verificar si la compra se creó correctamente
            if ($compra) {
                // Iterar sobre cada insumo comprado
                foreach ($request->arrayidinsumo as $key => $idInsumo) {
                    // Crear una nueva instancia de InsumoCaracteristica
                    $caracteristica = new InsumoCaracteristica([
                        'invima' => $request->arraycaracteristicas[$key]['invima'],
                        'lote' => $request->arraycaracteristicas[$key]['lote'],
                        'vencimiento' => $request->arraycaracteristicas[$key]['vencimiento'],
                        'cantidad' => $request->arraycantidad[$key],
                    ]);
    
                    // Asociar la compra directamente a la característica
                    $compra->insumoCaracteristicas()->save($caracteristica);
    
                    // Obtener el insumo correspondiente
                    $insumo = Insumo::find($idInsumo);
    
                    // Asociar la característica al insumo
                    $insumo->caracteristicas()->save($caracteristica);
                }
    
                DB::commit();
                return redirect('compra')->with('Mensaje', 'Compra creada correctamente');
            } else {
                DB::rollBack();
                return redirect('compra')->with('Mensaje', 'Error al crear la compra');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('compra')->with('Mensaje', 'Error en el servidor');
        }
    }

    /**
     * Display the specified resource.
     */



   public function show($id)
{
    $compra = Compra::findOrFail($id);
    $insumosComprados = $compra->insumos;

    return view('crud.compra.show', compact('compra', 'insumosComprados'));
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
