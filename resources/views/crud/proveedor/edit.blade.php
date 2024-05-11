@extends('adminlte::page')

@section('title', 'Proveedor')

@section('content_header')
    <h1></h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Editar Proveedor</h1>
    </div>
    <div class="card-body">
        <form action="{{url('proveedor/'.$proveedor->id) }}" method="POST">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <label>Nombre del Proveedor:</label>
                <input type="text" name="nombre" value="{{$proveedor->nombre}}" class="form-control">
            <br>
            <label>Descripcion del Proveedor:</label>            
                <input type="text" name="descripcion" value="{{$proveedor->descripcion}}" class="form-control">
            <br>
            <button type="submit" class="btn bg-blue">{{'Actualizar'}}</button>        
        </form>
    </div>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop