@extends('adminlte::page')

@section('title', 'Entrega')

@section('content_header')
    <div class="form-row">
        <div class="col-sm-12 d-flex align-items-center justify-content-between">
            <a href="{{ url('/entrega') }}" class="text-decoration-none text-white">
                <button type="submit" class="btn btn-primary">Ver Entregas</button>
            </a>
        </div>
    @stop

    @section('content')
        <div class="container w-100 border border-3 rounded p-4 mt-3">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-user-md"></i></span>
                        <input disabled type="text" class="form-control" value="Entrega realizada Por:">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{ $entrega->user->name }}">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-users"></i></span>
                        <input disabled type="text" class="form-control" value="Entrega realizada a:">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{ $entrega->servicio->nombre }}">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-file"></i></span>
                        <input disabled type="text" class="form-control" value="Tipo de Comprobante:">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control"
                        value="{{ $entrega->comprobante->tipo_comprobante }}">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-list-ol"></i></span>
                        <input disabled type="text" class="form-control" value="Numero de Comprobante:">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{ $entrega->numero_comprobante }}">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        <input disabled type="text" class="form-control" value="Fecha y Hora:">
                    </div>
                </div>
                <div class="col-sm-4">
                    <input disabled type="text" class="form-control"
                        value="{{ \Carbon\Carbon::parse($entrega->fecha_hora)->format('d-m-Y') }}">
                </div>
                <div class="col-sm-4">
                    <input disabled type="text" class="form-control"
                        value="{{ \Carbon\Carbon::parse($entrega->fecha_hora)->format('H:i:s') }}">
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header text-center">
                    <h5> Detalle de Entrega</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Producto</th>
                                <th>Marca</th>
                                <th>Presentacion</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entrega->insumos as $item)
                                <tr>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->marca->nombre }}</td>
                                    <td>{{ $item->presentacione->nombre }}</td>
                                    <td>{{ $item->pivot->cantidad }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @stop

    @section('css')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stop

    @section('js')
        <script>
            console.log("Hi, I'm using the Laravel-AdminLTE package!");
        </script>
    @stop
    {{-- 

    <table class="table table-striped">
        <thead class="bg-primary text-white text-center">
            <tr>
                <th>Producto</th>
                <th>Marca</th>
                <th>Presentacion</th>
                <th>INVIMA</th>
                <th>Lote</th>
                <th>Vencimiento</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($detalleEntrega as $item)
                @foreach ($item->caracteristicas as $caracteristica)
                    <tr>
                        <td>{{ $loop->first ? $item->nombre : '' }}</td>
                        <td>{{ $loop->first ? $item->marca->nombre : '' }}</td>
                        <td>{{ $loop->first ? $item->presentacione->nombre : '' }}</td>
                        <td>{{ $caracteristica->invima }}</td>
                        <td>{{ $caracteristica->lote }}</td>
                        <td>{{ $caracteristica->vencimiento }}</td>
                        <td>{{ $loop->last ? $item->pivot->cantidad : '' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table> --}}
