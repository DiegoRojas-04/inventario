@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>CATEGORIAS PARA LOS DIFERENTES KARDEX, Y A LA HORA DE REALIZAR LA ENTREGA PUEDE FILTRAR POR CATEGORIAS PARA QUE
        SOLO SALGAN LOS INSUMOS DE ESE SERVICIO QUE SE VA A ENTRREGAR</p>
        <P>Ingreso de insumos sin I L F</P>
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
