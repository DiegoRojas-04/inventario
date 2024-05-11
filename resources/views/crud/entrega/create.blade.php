    @extends('adminlte::page')

    @section('title', 'Entrega')

    @section('content_header')

    @stop

    @section('content')


        <form action="{{ url('/entrega') }}" method="post">
            @csrf

            <div class="container mt-4">
                <div class="row gy-4">
                    <div class="col-md-8">
                        <div class="text-white bg-primary p-1 text-center">
                            Detalles de Entrega
                        </div>
                        <div class="p-3 border border-3 border-primary">
                            <div class="row">

                                <div class="col-md-12 mb-2">
                                    <label class="form-label">Insumos:</label>
                                    <select data-size="10" title="Seleccionar Insumos..." data-live-search="true"
                                        name="nombre" id="nombre" data-style="btn-white"
                                        class="form-control selectpicker show-tick ">
                                        @foreach ($insumos as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="form-label">Variante de Insumo:</label>
                                    <select data-size="10" title="Seleccionar Variante..." data-live-search="true"
                                        name="variante" id="variante" data-style="btn-white"
                                        class="form-control selectpicker show-tick ">

                                    </select>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">En Stock:</label>
                                    <input type="text" class="form-control">

                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Cantidad:</label>
                                    <input type="number" name="stock" id="stock" class="form-control"
                                        placeholder="0">
                                </div>

                                <div class="col-md-12 mb-2 mt-2 text-right">
                                    <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="tabla_detalle">
                                            <thead class="bg-primary text-white text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Insumo</th>
                                                    <th>Cantidad</th>
                                                    <th>Codigo</th>
                                                    <th><i class="fa fa-trash"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <th></th>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>Total</th>
                                                    <th><span id="total">0</span></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">

                                </div>
                                <div class="col-md-12 mb-2">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modalCancelar"
                                        data-bs-target="#exampleModal">
                                        Cancelar Compra
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-white bg-success p-1 text-center">
                            Datos Generales
                        </div>
                        <div class="p-3 border border-3 border-success">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="" class="form-label">Entraga Para:</label>
                                    <select data-size="5" title="Entregar A:" data-live-search="true"
                                        data-style="btn-white" name="servicio_id" id="servicio_id"
                                        class="form-control selectpicker show-tick" required>
                                        @foreach ($servicios as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label>Comprobante:</label>
                                    <select data-size="5" title="Seleccionar Comprobante..." data-live-search="true"
                                        data-style="btn-white" name="comprobante_id" id="comprobante_id"
                                        class="form-control selectpicker show-tick" required>
                                        @foreach ($comprobantes as $item)
                                            <option value="{{ $item->id }}">{{ $item->tipo_comprobante }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label>Numero de Comprobante:</label>
                                    <input required type="text" name="numero_comprobante" id="numero_comprobante"
                                        class="form-control" required>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label>Fecha:</label>
                                    <input readonly type="date" name="fecha" id="fecha" class="form-control"
                                        value="<?php echo date('Y-m-d'); ?>">
                                    <?php
                                    use Carbon\Carbon;
                                    $fecha_hora = Carbon::now()->toDateTimeString();
                                    ?>
                                    <input type="hidden" name="fecha_hora" value="{{ $fecha_hora }}">
                                </div>

                                <input type="hidden" name="user_id" value="2">

                                <div class="col-md-12 mb-2 text-center">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @stop


    @section('css')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stop
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link
        rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#nombre').change(function() {
                    let insumoId = $(this).val();
                    console.log("Insumo seleccionado:", insumoId); // Verificar el valor de insumoId
                    // Limpiar las opciones anteriores del select de variantes
                    $('#variante').empty();
                    $.ajax({
                        url: "{{ url('/get-caracteristicas') }}",
                        type: "GET",
                        data: {
                            insumo_id: insumoId
                        },
                        success: function(response) {
                            // Limpiar las opciones anteriores del select de variantes
                            $('#variante').empty();
                            // Agregar las nuevas opciones correspondientes al insumo seleccionado
                            $.each(response.caracteristicas, function(key, value) {
                                if (value.cantidad > 0 && value.insumo_id == insumoId) {
                                    $('#variante').append('<option value="' + value.id +
                                        '">' +
                                        value.invima + ' - ' + value.lote + ' - ' +
                                        value.vencimiento + '</option>');
                                }
                            });
                            // Refrescar el plugin selectpicker después de actualizar las opciones
                            $('#variante').selectpicker('refresh');
                        }
                    }).done(function() {
                        // Limpiar el select de variantes cuando se cambie la selección de insumos
                        $('#variante').selectpicker('val', '');
                    });
                });

                $('#btn_agregar').click(function() {
                    agregarinsumo();
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                $('#btn_agregar').click(function() {
                    agregarinsumo();
                });
            });

            let cont = 0;
            let total = 0;

            function agregarinsumo() {
                let id_insumo = $('#nombre').val();
                let nameinsumo = $('#nombre option:selected').text();
                let cantidad = parseInt($('#stock').val());
                let variante = $('#variante').val();


                if (id_insumo != '' && nameinsumo != '' && cantidad != '') {

                    if (cantidad > 0 && (cantidad % 1 == 0)) {

                        let fila = '<tr id="fila' + cont + '">' +
                            '<th>' + (cont + 1) + '</th>' +
                            '<td><input type="hidden" name="arrayidinsumo[]" value="' + id_insumo + '">' + nameinsumo +
                            '</td>' +
                            '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad + '</td>' +
                            '<td><input type="hidden" name="arrayvariante[]" value="' + variante + '">' + variante + '</td>' +
                            '<td><button class="btn btn-danger" type="button" onClick="eliminarInsumo(' + cont +
                            ')"><i class="fa fa-trash"></i></button></td>' +
                            '</tr>';

                        $('#tabla_detalle').append(fila);
                        limpiarCampo();
                        cont++;
                        total += cantidad;
                        $('#total').html(total);
                    } else {
                        showModal('Valores Incorrectos')
                    }


                } else {
                    showModal('Campos Obligatorios')
                }
            }

            function limpiarCampo() {
                let selectNombre = $('#nombre');
                let selectVariante = $('#variante');

                selectNombre.selectpicker('val', ''); // Limpiar select de nombre
                selectVariante.selectpicker('val', ''); // Limpiar select de 
                selectVariante.selectpicker('val', ''); // Limpiar select de 
                $('#stock').val(''); // Limpiar campo de cantidad
            }



            function eliminarInsumo(indice) {
                let cantidadEliminada = parseInt($('#fila' + indice).find('td:eq(1)').text());
                total -= cantidadEliminada;
                $('#fila' + indice).remove();
                $('#total').html(total);
            }


            function recalcularTotal() {
                total = 0;
                $('#tabla_detalle tbody tr').each(function() {
                    let cantidad = parseInt($(this).find('td:eq(1)').text());
                    total += cantidad;
                });
                $('#total').html(total);
            }

            function showModal(message, icon = 'error') {
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
                })
                Toast.fire({
                    icon: icon,
                    title: message
                })
            }
        </script>

    @stop
