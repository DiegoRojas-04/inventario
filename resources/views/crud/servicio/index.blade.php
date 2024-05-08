@extends('adminlte::page')

@section('title', 'Servicio')

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
        title: "Servicio Eliminado"
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
        title: "Servicio Actualizado"
    });
</script>
@endif
    <a href="{{ url('/servicio/create')}}" class="text-decoration-none text-white">
        <button type="submit" class="btn btn-primary ">Agregar Servicio</button></a>
    <br>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Vista principal de servicios</h1>
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
                @foreach($servicios as $servicio)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$servicio->nombre}}</td>
                <td>{{$servicio->descripcion}}</td>

                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ url('/servicio/'.$servicio->id.'/edit')}}" class="text-decoration-none text-white">
                            <button type="submit" class="btn btn-warning "><i class="fa fa-file" aria-hidden="true"></i></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <form action="{{ url('/servicio/'.$servicio->id)}}" method="POST">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
              @endforeach
            </tbody>
        </table>
        {{$servicios->links()}}
   
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