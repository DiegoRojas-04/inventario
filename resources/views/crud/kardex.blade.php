@extends('adminlte::page')

@section('title', 'Kardex')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <h3>Kardex Mes de
                        {{ DateTime::createFromFormat('!m', $selectedMonth)->format('F') }} de {{ $selectedYear }}</h1>
                </div>
                <div class="col-md-2">
                    <label for="id_categoria" class="sr-only">Categoría</label>
                    <select name="id_categoria" id="id_categoria" class="form-control">
                        <option value="">Categorías</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ request('id_categoria') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <form action="{{ route('kardex.index') }}" method="GET">
                        <label for="mes" class="sr-only">Mes</label>
                        <select name="mes" id="mes" class="form-control">
                            <option value="">Selecciona un Mes</option>
                            @foreach (range(1, 12) as $month)
                                <option value="{{ $month }}" @if ($month == $selectedMonth) selected @endif>
                                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-2">
                    <label for="anno" class="sr-only">Año</label>
                    <input type="number" name="anno" id="anno" class="form-control" placeholder="Ingresa el Año"
                        value="{{ $selectedYear }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filtrar Fecha Kardex</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>Insumo</th>
                            <th>Inicio Mes</th>
                            <th>Ingresos</th>
                            <th>Egresos</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($insumos as $insumo)
                            <tr>
                                <td>{{ $insumo->nombre }}</td>
                                <td>{{ round($insumo->cantidad_inicial_mes) }}</td>
                                <td>{{ round($insumo->ingresos_mes) }}</td>
                                <td>{{ round($insumo->egresos_mes) }}</td>
                                <td>{{ round($insumo->saldo_final_mes) }}</td>
                                <td>
                                    <!-- Botón para mostrar detalles de ingresos -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalIngresos{{ $insumo->id }}">
                                        Ver Ingresos
                                    </button>
                                    <!-- Botón para mostrar detalles de egresos -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalEgresos{{ $insumo->id }}">
                                        Ver Egresos
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {{ $insumos->links()}} --}}
            </div>
        </div>
    </div>
    @foreach ($insumos as $insumo)
        <div class="modal fade" id="modalIngresos{{ $insumo->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalles de Ingresos - {{ $insumo->nombre }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insumo->detallesTransaccion as $detalle)
                                    <tr>
                                        <td>{{ $detalle->fecha }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal para mostrar detalles de egresos -->
    @foreach ($insumos as $insumo)
        <div class="modal fade" id="modalEgresos{{ $insumo->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalles de Egresos - {{ $insumo->nombre }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insumo->detallesTransaccion as $detalle)
                                    <tr>
                                        <td>{{ $detalle->fecha }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/js.js"></script>
@stop
