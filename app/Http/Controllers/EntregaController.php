<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntregaRequest;
use App\Models\Caracteristica;
use App\Models\Comprobante;
use App\Models\Entrega;
use App\Models\Insumo;
use App\Models\Servicio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntregaController extends Controller
{

    // En el controlador EntregaController
    public function getCaracteristicas(Request $request)
    {
        $insumoId = $request->get('insumo_id');
        $insumo = Insumo::findOrFail($insumoId);
        $caracteristicas = $insumo->caracteristicas;
        return response()->json(['caracteristicas' => $caracteristicas]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entregas = Entrega::with('comprobante')->where('estado', 1)->latest()->get();
        return view('crud.entrega.index', compact('entregas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $insumos = Insumo::where('estado', 1)->get();
        $servicios = Servicio::where('estado', 1)->get();
        $comprobantes = Comprobante::all();
        $todasVariantes = collect(); 

        foreach ($insumos as $insumo) {
            $todasVariantes = $todasVariantes->merge($insumo->caracteristicas);
        }

        // Establecer el índice predeterminado de la variante seleccionada (puedes ajustarlo según tus necesidades)
        $varianteIndex = 0;

        return view('crud.entrega.create', compact('insumos', 'servicios', 'comprobantes', 'todasVariantes', 'varianteIndex'));
    }




    /**
     * Store a newly created resource in storage.
     */
    // EntregaController@store


    public function store(StoreEntregaRequest $request)
    {
        try {
            DB::beginTransaction();
            $entrega = Entrega::create($request->validated());
            $arrayInsumo = $request->get('arrayidinsumo');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayVariante = $request->get('arrayvariante');

            // Recorrer cada variante de insumo y su cantidad correspondiente
            foreach ($arrayInsumo as $key => $insumoId) {
                $variante = $arrayVariante;
                $cantidad = $arrayCantidad[$key];

                // Verificar si esta es la variante seleccionada en la venta
                if ($key === intval($request->get('caracteristica'))) {

                    // Actualizar el stock de la variante seleccionada
                    DB::table('insumo_caracteristicas')
                        ->where('id', $variante)
                        ->decrement('cantidad', intval($cantidad));

                    // Actualizar el stock del insumo
                    $insumo = Insumo::find($insumoId);
                    $insumo->decrement('stock', intval($cantidad));
                }

                // Asociar la variante y la cantidad a la entrega
                $entrega->insumos()->syncWithoutDetaching([
                    $insumoId => [
                        'cantidad' => $cantidad
                    ]
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            // Manejar el error según tu lógica
        }

        return redirect('entrega')->with('Mensaje', 'Entrega');
    }




    /**
     * Display the specified resource.
     */
    public function show(Entrega $entrega)
    {
        $insumo = Insumo::all();
        $caracteristica = Caracteristica::all();
        return view('crud.entrega.show', compact('entrega', 'insumo', 'caracteristica'));
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
