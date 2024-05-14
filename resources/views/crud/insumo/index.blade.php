@extends('adminlte::page')

@section('title', 'Insumo')

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
            <div class="row g-3">

                <div class="col-md-1">
                    <select class="form-control " id="pageSize">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select data-size="5" title="Seleccionar Categoria" data-live-search="true" name="id_categoria"
                        id="id_categoria" class="form-control selectpicker show-tick">
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                
                <div class="col-md-3">
                    <select data-size="5" title="Seleccionar Categoria" data-live-search="true" name="id_categoria"
                        id="id_categoria" class="form-control selectpicker show-tick">
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-5 input-group">
                    <input type="text" class="form-control" placeholder="Buscar" id="search">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">

            <table class="table" id="datos">
                <thead class="thead-dark">
                    <tr class="text-center">
                        {{-- <th scope="col">#</th> --}}
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Presentacion</th>
                        <th scope="col">Vida Util</th>
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
                            <td>{{ $insumo->vida_util }}</td>
                            {{-- <td>{{ $insumo->caracteristicas()->exists() ? $insumo->caracteristicas->first()->invima ?? 'N/A' : 'N/A' }}</td> --}}
                            <td>{{ $insumo->riesgo }}</td>
                            <td>{{ $insumo->stock }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modalInsumo-{{ $insumo->id }}"><i class="fa fa-eye"
                                            aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/insumo/' . $insumo->id . '/edit') }}"
                                        class="text-decoration-none text-white">
                                        <button type="submit" class="btn btn-warning "><i class="fa fa-file"
                                                aria-hidden="true"></i></button></a>
                                </div>
                                <div class="btn-group" role="group">
                                    <form action="{{ url('/insumo/' . $insumo->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"
                                                aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $insumos->links() }}
        </div>
    </div>

    @foreach ($insumos as $insumo)
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="modalInsumo-{{ $insumo->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-bold" id="exampleModalLabel">Detalle del Insumo</h4>
                    </div>
                    <div class="modal-body  text-center">
                        <label class="text-center font-bold">
                            <h4>{{ $insumo->nombre }}</h4>
                        </label>
                        <div class="mb-3 border-b pb-3">
                            <label class="block">Descripción:</label>
                            <span class="block">{{ $insumo->descripcion }}</span>
                        </div>
                        <!-- Subtabla para mostrar características adicionales -->
                        <div class="mb-3">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>Invima</th>
                                        <th>Lote</th>
                                        <th>Fecha de Vencimiento</th>
                                        <th>Cantidad</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($insumo->caracteristicas as $caracteristica)
                                        @if ($caracteristica->cantidad > 0)
                                            <tr>
                                                <td>{{ $caracteristica->invima }}</td>
                                                <td>{{ $caracteristica->lote }}</td>
                                                <td>{{\Carbon\Carbon::parse($caracteristica->vencimiento)->format('d-m-Y')}}</td>
                                                <td>{{ $caracteristica->cantidad }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ url('/insumo/' . $insumo->id . '/caracteristica/' . $caracteristica->id . '/edit') }}"
                                                            class="text-decoration-none text-white">
                                                            <button type="submit" class="btn btn-warning "><i
                                                                    class="fa fa-file" aria-hidden="true"></i></button></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@stop

@section('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop

@section('js')
    <script></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#search").keyup(function() {

                _this = this;



                $.each($("#datos tbody tr"), function() {

                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)

                        $(this).hide();

                    else

                        $(this).show();

                });

            });

        });
        
    </script>
@stop
