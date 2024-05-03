@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
   
@stop

@section('content')

<form action="" method="post">
    @csrf

    <div class="container mt-4">
        <div class="row gy-4">
            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de Entrega
                </div>
                <div class="p-3 border border-3 border-primary">
                    <div class="row">

                        <div class="col-md-8 mb-2">
                            <label class="form-label">Entregar:</label>
                            <select class="form-control selectpicker" data-live-search="true" data-size="1" title="Seleciona Insumo" name="nombre" id="nombre">
                                @foreach ($insumos as $item)
                                    <option value="{{$item->id}}">{{$item->codigo.$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                           <label class="form-label">Cantidad:</label>
                           <input type="number" name="cantidad" class="form-control">
                        </div>

                        <div class="col-md-12  mb-2 mt-2 text-center">
                            <button class="btn btn-primary" type="button">Agregar</button>
                         </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover" id="tabla_detalle">
                                    <thead class="bg-primary text-white text-center">
                                        <tr>
                                            <th>#</th>
                                            <th>Insumo</th>
                                            <th>Categoria</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Total</th>
                                            <th>0</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>    
                        </div>

                    </div>
                </div>
            </div>
                <div class="col-md-4">
                    <div class="text-white bg-success p-1 text-center">
                        Datos Generales
                    </div>
                    <div class="p-3 border border-3 border-success">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop