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
        $arrayInsumo = $request->get('arrayidinsumo');
        $arrayCantidad = $request->get('arraycantidad');
        $arrayCaracteristicas = $request->get('arraycaracteristicas');

        $size = count($arrayInsumo);
        $cont = 0;
        while ($cont < $size) {
            // Verificar si el insumo requiere características adicionales
            $insumo = Insumo::find($arrayInsumo[$cont]);
            if (!$insumo->requiere_lote && !$insumo->requiere_invima) {
                // Si no requiere características adicionales, agregar solo el stock
                $compra->insumos()->attach($arrayInsumo[$cont], ['cantidad' => $arrayCantidad[$cont]]);
                
                // Actualizar el stock del insumo
                $stockActual = $insumo->stock;
                $stockNuevo = intval($arrayCantidad[$cont]);
                $insumo->update(['stock' => $stockActual + $stockNuevo]);
            } else {
                // Si el insumo requiere características adicionales, agregar características
                $compra->insumos()->syncWithoutDetaching([
                    $arrayInsumo[$cont] => ['cantidad' => $arrayCantidad[$cont]]
                ]);

                // Actualizar el stock del insumo
                $stockActual = $insumo->stock;
                $stockNuevo = intval($arrayCantidad[$cont]);
                $insumo->update(['stock' => $stockActual + $stockNuevo]);

                // Crear las características del insumo
                $insumo->caracteristicas()->create([
                    'invima' => $arrayCaracteristicas[$cont]['invima'],
                    'lote' => $arrayCaracteristicas[$cont]['lote'],
                    'vencimiento' => $arrayCaracteristicas[$cont]['vencimiento'],
                    'cantidad' => $arrayCantidad[$cont],
                ]);
            }

            $cont++;
        }

        DB::commit();
    } catch (Exception $e) {
        DB::rollBack();
    }

    return redirect('compra')->with('Mensaje', 'Compra');
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
