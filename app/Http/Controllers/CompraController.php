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

    public function index(Request $request)
    {
        $query = Compra::query();

        // Verifica si se enviaron fechas en la solicitud
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            // Convierte las fechas de texto en objetos Carbon para poder compararlas
            $fechaInicio = Carbon::createFromFormat('Y-m-d', $request->input('fecha_inicio'))->startOfDay();
            $fechaFin = Carbon::createFromFormat('Y-m-d', $request->input('fecha_fin'))->endOfDay();

            // Filtra las compras dentro del rango de fechas seleccionado
            $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
        }

        $compras = $query->latest()->paginate(5);

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
                $insumo = Insumo::find($arrayInsumo[$cont]);
                if (!$insumo->requiere_lote && !$insumo->requiere_invima) {
                    $compra->insumos()->attach($arrayInsumo[$cont], ['cantidad' => $arrayCantidad[$cont]]);
                    $insumo->update(['stock' => $insumo->stock + intval($arrayCantidad[$cont])]);
                } else {
                    $compra->insumos()->syncWithoutDetaching([
                        $arrayInsumo[$cont] => ['cantidad' => $arrayCantidad[$cont]]
                    ]);
                    $insumo->update(['stock' => $insumo->stock + intval($arrayCantidad[$cont])]);

                    $insumo->caracteristicas()->create([
                        'invima' => $arrayCaracteristicas[$cont]['invima'],
                        'lote' => $arrayCaracteristicas[$cont]['lote'],
                        'vencimiento' => $arrayCaracteristicas[$cont]['vencimiento'],
                        'cantidad' => $arrayCantidad[$cont],
                        'compra_id' => $compra->id,  // Asegúrate de almacenar la compra_id aquí
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

        // Obtener los insumos con las características específicas de esa compra
        $insumosConCaracteristicas = $compra->insumos->map(function ($insumo) use ($compra) {
            $insumo->caracteristicasCompra = $insumo->caracteristicas()->where('compra_id', $compra->id)->get();
            return $insumo;
        });

        return view('crud.compra.show', compact('compra', 'insumosConCaracteristicas'));
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
