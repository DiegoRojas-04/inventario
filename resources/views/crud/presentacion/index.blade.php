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
        icon: "success",
        title: "Presentacion Actualizada"
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
        icon: "error",
        title: "Presentacion Eliminada"
    });
</script>
@endif

    <div class="form-row">
        <div class="col-sm-12 d-flex align-items-center justify-content-between">
            <a href="{{ url('/presentacion/create')}}" class="text-decoration-none text-white">
                <button type="submit" class="btn btn-primary">Agregar Presentacion</button>
            </a>


            <form action="{{'/presentacion'}}" method="GET" class="ml-auto">
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
            Presentacion
        </h1>
    </div>
    <div class="card-body">

        <table class="table">
            <thead class="thead-dark">
              <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody class="text-center">
                @foreach($presentaciones as $presentacion)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$presentacion->nombre}}</td>
                <td>{{$presentacion->descripcion}}</td>

                <td>  
                    <div class="btn-group" role="group">
                        <a href="{{ url('/presentacion/'.$presentacion->id.'/edit')}}" class="text-decoration-none text-white">
                        <button type="submit" class="btn btn-warning ">Editar</button></a>
                    </div> 
                    <div class="btn-group" role="group">
                        <form action="{{ url('/presentacion/'.$presentacion->id)}}" method="POST">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
              @endforeach
            </tbody>
        </table>   
        {{$presentaciones->links()}}
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