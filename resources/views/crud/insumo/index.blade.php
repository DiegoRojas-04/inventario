@extends('adminlte::page')

@section('title', 'Dashboard')

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
                icon: "error",
                title: "Insumo Eliminado"
            });
        </script>
    @endif

    @if (session('Mensaje2'))
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
                title: "Insumo Actualizado"
            });
        </script>
    @endif
    <a href="{{ url('/insumo/create') }}" class="text-decoration-none text-white">
        <button type="submit" class="btn btn-primary ">Agregar Insumos</button></a>
    <br>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Vista principal de los Insumos</h1>
        </div>
        <div class="card-body">

            <table class="table">
                <thead class="thead-dark">
                    <tr class="text-center">
                        {{-- <th scope="col">#</th> --}}
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Presentacion</th>
                        <th scope="col">Fecha Venci</th>
                        <th scope="col">Clasif.Riesgo</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($insumos as $insumo)
                        <tr>
                            {{-- <td>{{$loop->iteration}}</td> --}}
                            <td>{{ $insumo->nombre }}</td>
                            <td>{{ $insumo->marca->nombre }}</td>
                            <td>{{ $insumo->presentacione->nombre }}</td>
                            <td>{{ $insumo->vencimiento }}</td>
                            <td>{{ $insumo->riesgo }}</td>
                            <td>{{ $insumo->stock }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modalInsumo-{{$insumo->id}}"><i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/insumo/' . $insumo->id . '/edit') }}"
                                        class="text-decoration-none text-white">
                                        <button type="submit" class="btn btn-warning "><i class="fa fa-file" aria-hidden="true"></i></button></a>
                                </div>
                                <div class="btn-group" role="group">
                                    <form action="{{ url('/insumo/' . $insumo->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </td>
                            <!-- Modal -->
                            <div class="modal fade" id="modalInsumo-{{$insumo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title text-center font-bold" id="exampleModalLabel">Detalle del Insumo</h4>
                                        </div>
                                        <div class="modal-body">
                                            <label class="text-center font-bold"><h4>{{$insumo->nombre}}</h4></label>
                                            <div class="mb-3 border-b pb-3">
                                                <label class="block">Descripción:</label>
                                                <span class="block">{{$insumo->descripcion}}</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="block">Invima:</label>
                                                <span class="block">{{$insumo->invima}}</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="block">Lote:</label>
                                                <span class="block">{{$insumo->lote}}</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="block">Vida Util:</label>
                                                <span class="block">{{$insumo->vida_util}}</span>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-center">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $insumos->links() }}
        </div>

    </div>
@stop

@section('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop

@section('js')
    <script>
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@stop
