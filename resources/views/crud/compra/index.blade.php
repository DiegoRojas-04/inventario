@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    @if(Session::has('Mensaje'))
    <div id="alertaError" class="alert alert-danger absolute" role="alert">
        {{ Session::get('Mensaje') }}        
    </div>  
    @endif
    @if(Session::has('Mensaje2'))
    <div id="alertaExito" class="alert alert-success" role="alert">
        {{ Session::get('Mensaje2') }}        
    </div>
    @endif
    <div class="form-row">
        <div class="col-sm-12 d-flex align-items-center justify-content-between">
            <a href="{{ url('/compra/create')}}" class="text-decoration-none text-white">
                <button type="submit" class="btn btn-primary">Agregar Compra</button>
            </a>
            
            <form action="{{'/compra'}}" method="GET" class="ml-auto">
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
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody class="text-center">
                @foreach($compras as $compra)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$compra->nombre}}</td>
                <td>{{$compra->descripcion}}</td>

                <td>
                    <div class="row g-3">
                        <div class="col-md-6">
                        <form action="{{ url('/compra/'.$compra->id)}}" method="POST">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <button type="submit" class="btn btn-danger">Eliminar</button></form>
                        </div>
                        <div class="col-md-6">
                        <a href="{{ url('/compra/'.$compra->id.'/edit')}}" class="text-decoration-none text-white">
                        <button type="submit" class="btn btn-warning ">Editar</button></a>
                        </div>
                    </div>
                </td>
            </tr>
              @endforeach
            </tbody>
        </table>   
        {{$compras->links()}}
    </div>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop