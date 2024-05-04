<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Insumo;
use App\Models\Presentacione;
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
        $compras = Compra::with('comprobante')->where('estado',1)->latest()->get();
        return view('crud.compra.index',compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $insumos = Insumo::where('estado', 1)->get();
        $servicios = Servicio::where('estado', 1)->get();
        $comprobantes = Comprobante::all();
        return view('crud.compra.create', compact('insumos', 'servicios', 'comprobantes',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        // dd($request);
        try {
            DB::beginTransaction();


            $compra = Compra::create($request->validated());
            $arrayInsumo = $request->get('arrayidinsumo');
            $arrayCantidad = $request->get('arraycantidad');

            $siseArray = count($arrayInsumo);
            $cont = 0;
            while ($cont < $siseArray) {
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
    public function show(Compra $compra)
    {
        $insumo = Insumo::all();
        return view('crud.compra.show',compact('compra','insumo'));
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
