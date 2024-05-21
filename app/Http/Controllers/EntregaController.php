<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntregaRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use App\Models\Comprobante;
use App\Models\Entrega;
use App\Models\Insumo;
use Carbon\Carbon;
use App\Models\Servicio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntregaController extends Controller
{

    public function getStock(Request $request)
    {
        $insumoId = $request->input('insumo_id');
        $stock = Insumo::findOrFail($insumoId)->stock;
        return response()->json(['stock' => $stock]);
    }

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
    public function index(Request $request)
    {
        $query = Entrega::with('comprobante')->where('estado', 1);

        // Verifica si se enviaron fechas en la solicitud
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            // Convierte las fechas de texto en objetos Carbon para poder compararlas
            $fechaInicio = Carbon::createFromFormat('Y-m-d', $request->input('fecha_inicio'))->startOfDay();
            $fechaFin = Carbon::createFromFormat('Y-m-d', $request->input('fecha_fin'))->endOfDay();

            // Filtra las entregas dentro del rango de fechas seleccionado
            $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
        }

        // Obtén las entregas filtradas y aplica la paginación
        $entregas = $query->latest()->paginate(5); // Puedes cambiar 10 por la cantidad de elementos que quieras por página

        return view('crud.entrega.index', compact('entregas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $insumos = Insumo::where('estado', 1)->where('stock', '>', 0)->get();
        $servicios = Servicio::where('estado', 1)->get();
        $categorias = Categoria::all();
        $comprobantes = Comprobante::all();
        $todasVariantes = collect();

        foreach ($insumos as $insumo) {
            $todasVariantes = $todasVariantes->merge($insumo->caracteristicas);
        }

        // Establecer el índice predeterminado de la variante seleccionada (puedes ajustarlo según tus necesidades)
        $varianteIndex = 0;

        return view('crud.entrega.create', compact('insumos', 'servicios', 'comprobantes', 'todasVariantes', 'varianteIndex', 'categorias'));
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
            $arrayInvima = $request->get('arrayinvima'); // Agregado
            $arrayLote = $request->get('arraylote'); // Agregado
            $arrayVencimiento = $request->get('arrayvencimiento'); // Agregado
            $totalCantidadEntregada = 0;

            // Recorrer cada variante de insumo y su cantidad correspondiente
            foreach ($arrayInsumo as $key => $insumoId) {
                $variante = $arrayVariante[$key];
                $cantidad = $arrayCantidad[$key];
                $invima = $arrayInvima[$key]; // Agregado
                $lote = $arrayLote[$key]; // Agregado
                $vencimiento = $arrayVencimiento[$key]; // Agregado

                // Asociar la variante y la cantidad a la entrega
                $entrega->insumos()->attach([
                    $insumoId => [
                        'cantidad' => $cantidad,
                        'invima' => $invima, // Agregado
                        'lote' => $lote, // Agregado
                        'vencimiento' => $vencimiento, // Agregado
                    ]
                ]);

                // Aumentar el total de cantidad entregada
                $totalCantidadEntregada += $cantidad;
            }

            // Descuento de stock de las variantes
            $variantesConCantidad = array_combine($arrayVariante, $arrayCantidad);

            foreach ($variantesConCantidad as $varianteId => $cantidad) {
                // Actualizar el stock de la variante seleccionada
                DB::table('insumo_caracteristicas')
                    ->where('id', $varianteId)
                    ->decrement('cantidad', intval($cantidad));
            }

            // Descuento de stock del insumo principal
            foreach ($arrayInsumo as $key => $insumoId) {
                $cantidad = $arrayCantidad[$key];

                // Obtener el insumo asociado a la variante
                $insumo = Insumo::findOrFail($insumoId);

                // Decrementar el stock del insumo principal
                $insumo->decrement('stock', intval($cantidad));
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
    public function show($id)
    {
        $insumo = Insumo::all();
        $entrega = Entrega::with('insumos')->findOrFail($id);
        $detalleEntrega = $entrega->insumos()->with(['caracteristicas' => function ($query) {
            $query->select('insumo_id', 'invima', 'lote', 'vencimiento');
        }])->get();
        return view('crud.entrega.show', compact('entrega', 'insumo', 'detalleEntrega'));
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
