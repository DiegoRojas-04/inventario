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
    <a href="{{ url('/insumo/create')}}" class="text-decoration-none text-white">
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
                <th scope="col">Descripcion</th>
                <th scope="col">Marca</th>
                <th scope="col">Presentacion</th>
                <th scope="col">Invima</th>
                <th scope="col">F.Vencimiento</th>
                <th scope="col">Lote</th>
                <th scope="col">C.Riesgo</th>
                <th scope="col">Vida Util</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody class="text-center">
                @foreach($insumos as $insumo)
            <tr>
                {{-- <td>{{$loop->iteration}}</td> --}}
                <td>{{$insumo->nombre}}</td>
                <td>{{$insumo->descripcion}}</td>
                <td>{{$insumo->marca->nombre}}</td>
                <td>{{$insumo->presentacione->nombre}}</td>
                <td>{{$insumo->invima}}</td>
                <td>{{$insumo->vencimiento}}</td>
                <td>{{$insumo->lote}}</td>
                <td>{{$insumo->riesgo}}</td>
                <td>{{$insumo->vida_util}}</td>
                <td>{{$insumo->stock}}</td>

                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ url('/insumo/'.$insumo->id.'/edit')}}" class="text-decoration-none text-white">
                        <button type="submit" class="btn btn-warning ">Editar</button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <form action="{{ url('/insumo/'.$insumo->id)}}" method="POST">
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
        {{$insumos->links()}}
 
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