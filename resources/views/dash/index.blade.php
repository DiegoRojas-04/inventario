@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Al actualizar las categorias o cualquier otra, no cuente el id de esa</p>
    <p>La variante al momento de entregar no se duplique para realizar la venta de otro insumo</p>
    <p>Actualizar la variante individualmente</p>
    <p>Seleccionar el N° de datos para mostrar en la tabla, filtrar por categoria</p>
    <p>Al eliminar un insumo del carrito se descudra el total</p>
    <p>Los detalles de venta y de compra, mostrar bien las caracteristicas que se vendieron o compraron</p>
    <p>Ver el stock del insumo que voy a entregar y las validaciones de venta</p>
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
