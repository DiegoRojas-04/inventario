@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    @if (Session::has('Mensaje'))
        <div id="alertaError" class="alert alert-danger absolute" role="alert">
            {{ Session::get('Mensaje') }}
        </div>
    @endif
    @if (Session::has('Mensaje2'))
        <div id="alertaExito" class="alert alert-success" role="alert">
            {{ Session::get('Mensaje2') }}
        </div>
    @endif
    <div class="form-row">
        <div class="col-sm-12 d-flex align-items-center justify-content-between">
            <a href="{{ url('/entrega/create') }}" class="text-decoration-none text-white">
                <button type="submit" class="btn btn-primary">Agregar Entrega</button>
            </a>

            <form action="{{ '/entrega' }}" method="GET" class="ml-auto">
                <div class="input-group">
                    <input type="text" class="form-control" name="texto" value="">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Vista principal de Compra</h1>
        </div>
        <div class="card-body">

            <table class="table">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th scope="col">Comprobante</th>
                        <th scope="col">Fecha y Hora</th>
                        <th scope="col">Total</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($compras as $item)
                        <tr>
                            <td>
                                <p>{{ $item->comrpobante->tipo_comprobante }}</p>
                                <p>{{ $item->comprobante->numero_comprobante }}</p>
                            </td>
                            <td>{{ $item->fecha_hora }}</td>
                            <td>{{ $item->total }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success">Ver</button>
                                    <button type="button" class="btn btn-danger">Eliminar</button>
                                </div>
                            </td>

                            <td>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <form action="{{ url('/entrega/' . $entrega->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ url('/entrega/' . $entrega->id . '/edit') }}"
                                            class="text-decoration-none text-white">
                                            <button type="submit" class="btn btn-warning ">Editar</button></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $entregas->links() }}
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
