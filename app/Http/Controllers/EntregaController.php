<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntregaRequest;
use App\Models\Comprobante;
use App\Models\Entrega;
use App\Models\Insumo;
use App\Models\Servicio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entregas = Entrega::with('comprobante')->where('estado',1)->latest()->get();
        return view('crud.entrega.index',compact('entregas'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $insumos = Insumo::where('estado', 1)->get();
        $servicios = Servicio::where('estado', 1)->get();
        $comprobantes = Comprobante::all();
        return view('crud.entrega.create', compact('insumos', 'servicios', 'comprobantes',));   

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntregaRequest $request)
    {
         try {
            DB::beginTransaction();

            $entrega = Entrega::create($request->validated());
            $arrayInsumo = $request->get('arrayidinsumo');
            $arrayCantidad = $request->get('arraycantidad');

            $siseArray = count($arrayInsumo);
            $cont = 0;
            while ($cont < $siseArray) {
                $entrega->insumos()->syncWithoutDetaching([
                    $arrayInsumo[$cont] => [
                        'cantidad' => $arrayCantidad[$cont]
                    ]
                ]);

                $insumo = Insumo::find($arrayInsumo[$cont]);
                $stockActual = $insumo->stock;
                $stockNuevo = intval($arrayCantidad[$cont]);

                DB::table('insumos')->where('id', $insumo->id)->update([
                    'stock' => $stockActual - $stockNuevo
                ]);

                $cont++;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return redirect('entrega')->with('Mensaje', 'entrega');
    }

    /**
     * Display the specified resource.
     */
    public function show(Entrega $entrega)
    {
        $insumo = Insumo::all();
        return view('crud.entrega.show',compact('entrega','insumo'));
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
