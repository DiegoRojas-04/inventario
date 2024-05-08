@extends('adminlte::page')

@section('title', 'Entrega')

@section('content_header')
    @if (session('Mensaje'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Entrega Exitosa"
            });
        </script>
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
            <h1 class="card-title">Vista principal de Entregas</h1>
        </div>
        <div class="card-body">

            <table class="table">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Entrega a</th>
                        <th>Comprobante</th>
                        <th>Numero Comprobante</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($entregas as $item)
                        <tr>
                            <td>{{ $item->servicio->nombre}}</td>
                            <td>{{ $item->comprobante->tipo_comprobante }}</td>
                            <td>{{ $item->numero_comprobante }}</td>
                            <td>{{\Carbon\Carbon::parse($item->fecha_hora)->format('d-m-Y')}}</td>
                            <td>{{\Carbon\Carbon::parse($item->fecha_hora)->format('H:i:s')}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form action="{{ route('entrega.show', ['entrega' => $item]) }}" method="get">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-eye"
                                                aria-hidden="true"></i></button>
                                    </form>
                                </div>

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-danger">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $compras->links() }} --}}
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
