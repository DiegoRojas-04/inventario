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
        title: "Marca Eliminada"
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
        title: "Marca Actualizada"
    });
</script>
@endif
    <div class="form-row">
        <div class="col-sm-12 d-flex align-items-center justify-content-between">
            <a href="{{ url('/marca/create')}}" class="text-decoration-none text-white">
                <button type="submit" class="btn btn-primary">Agregar Marca</button>
            </a>


            <form action="{{'/marca'}}" method="GET" class="ml-auto">
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
         <h1 class="card-title">
            Marcas
        </h1>
    </div>
    <div class="card-body">

        <table class="table">
            <thead class="thead-dark">
              <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody class="text-center">
                @foreach($marcas as $marca)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$marca->nombre}}</td>
                <td>{{$marca->descripcion}}</td>
                <td>@if($marca->estado == 1)
                    <span class="fw-bolder rounded bg-success text-white p-1">Activo</span>
                    @else
                        <span class="fw-bolder rounded bg-danger text-white p-1">Eliminado</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ url('/marca/'.$marca->id.'/edit')}}" class="text-decoration-none text-white">
                            <button type="submit" class="btn btn-warning "><i class="fa fa-file" aria-hidden="true"></i></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        @if($marca->estado == 1)
                            <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#eliminar-{{$marca->id}}">Eliminar</button>
                        @else
                            <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#eliminar-{{$marca->id}}">Restaurar</button>
                        @endif
                    </div>
                </td>
            </tr>
             <!-- Modal -->
             <div class="modal fade" id="eliminar-{{$marca->id}}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{$marca->estado == 1 ? 'Eliminar Marca' : 'Restaurar Marca'}} <br>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           {{$marca->estado == 1 ? ' ¿Estas seguro que quieres Eliminar esta Marca?' : '¿Estas seguro que quieres Restaurar esta Marca?'}} <br>
                            <h5>{{$marca->nombre}}</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <form action="{{ url('/marca/' . $marca->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-primary">Confirmar</i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
              @endforeach
            </tbody>
        </table>   
        {{$marcas->links()}}
    </div>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop