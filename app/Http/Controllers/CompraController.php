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
                $compra->insumos()->syncWithoutDetaching([
                    $arrayInsumo[$cont] => [
                        'cantidad' => $arrayCantidad[$cont]
                    ]
                ]);

                $insumo = Insumo::find($arrayInsumo[$cont]);
                $stockActual = $insumo->stock;
                $stockNuevo = intval($arrayCantidad[$cont]);

                DB::table('insumos')->where('id', $insumo->id)->update([
                    'stock' => $stockActual + $stockNuevo
                ]);

                $insumo->caracteristicas()->create([
                    'invima' => $arrayCaracteristicas[$cont]['invima'],
                    'lote' => $arrayCaracteristicas[$cont]['lote'],
                    'vencimiento' => $arrayCaracteristicas[$cont]['vencimiento'],
                    'cantidad' => $arrayCantidad[$cont],
                ]);

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

        // Obtener los insumos asociados a la compra actual
        $insumosComprados = $compra->insumos;

        // Inicializar un array para almacenar las características de los insumos de la compra
        $caracteristicasCompradas = [];

        // Iterar sobre los insumos comprados y obtener sus características asociadas
        foreach ($insumosComprados as $insumo) {
            $caracteristicas = InsumoCaracteristica::where('insumo_id', $insumo->id)->get();
            $caracteristicasCompradas[$insumo->id] = $caracteristicas;
        }

        return view('crud.compra.show', compact('compra', 'caracteristicasCompradas'));
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
