$(document).ready(function () {
    // Función para manejar el cambio en el select
    $('#nombre').change(function () {
        // Obtener el valor del insumo seleccionado
        let id_insumo = $(this).val();

        // Obtener si requiere lote y mostrar u ocultar los campos
        let requiere_lote = $(this).find('option:selected').data('requiere-lote');
        if (requiere_lote == 1) {
            mostrarCamposLote();
        } else {
            ocultarCamposLote();
        }

        // Obtener si requiere invima y mostrar u ocultar los campos
        let requiere_invima = $(this).find('option:selected').data('requiere-invima');
        if (requiere_invima == 1) {
            mostrarCamposInvima();
        } else {
            ocultarCamposInvima(); n
        }
    });
});

// Funciones para mostrar y ocultar campos
function mostrarCamposLote() {
    $('#campos_lote_fecha').show();
    $('#campos_vencimiento').show();
}

function ocultarCamposLote() {
    $('#campos_lote_fecha').hide();
    $('#campos_vencimiento').hide();
}

function mostrarCamposInvima() {
    $('#campos_invima').show();
}

function ocultarCamposInvima() {
    $('#campos_invima').hide();
}

$(document).ready(function () {
    $('#btn_agregar').click(function () {
        agregarinsumo();
    });
});

let cont = 0;
let total = 0;

function agregarinsumo() {
    let id_insumo = $('#nombre').val();
    let nameinsumo = $('#nombre option:selected').text();
    let cantidad = parseInt($('#stock').val());
    let lote = $('#lote').val();
    let vencimiento = $('#vecimiento').val();
    let invima = $('#invima').val();

    // Verificar si todos los campos lote, vencimiento e invima están vacíos
    // Si están vacíos, asignarles los valores 'NR' y '0001-01-01' respectivamente
    if (lote.trim() === '' && vencimiento.trim() === '' && invima.trim() === '') {
        lote = 'NR';
        vencimiento = '0001-01-01';
        invima = 'NR';
    } else {
        // Verificar y asignar valores predeterminados para cada campo individualmente
        if (lote.trim() === '') {
            lote = 'NR';
        }

        if (vencimiento.trim() === '') {
            vencimiento = '0001-01-01';
        }

        if (invima.trim() === '') {
            invima = 'NR';
        }
    }

    if (id_insumo != '' && nameinsumo != '' && cantidad != '') {
        if (cantidad > 0 && (cantidad % 1 == 0)) {
            let fila = '<tr id="fila' + cont + '">' +
                '<th>' + (cont + 1) + '</th>' +
                '<td><input type="hidden" name="arrayidinsumo[]" value="' + id_insumo + '">' + nameinsumo +
                '</td>' +
                '<td><input type="hidden" name="arraycaracteristicas[' + cont + '][invima]" value="' + invima +
                '">' + invima + '</td>' +
                '<td><input type="hidden" name="arraycaracteristicas[' + cont + '][lote]" value="' + lote + '">' +
                lote + '</td>' +
                '<td><input type="hidden" name="arraycaracteristicas[' + cont + '][vencimiento]" value="' +
                vencimiento + '">' + vencimiento + '</td>' +
                '<td>' +

                '<div class="input-group">' +
                '<button class="btn btn-danger btn-sm" type="button" onclick="disminuirCantidad(' + cont +
                ')"><i class="fa fa-minus"></i></button>' +
                '<input type="number" name="arraycantidad[]" value="' + cantidad +
                '" class="form-control text-center" readonly>' +
                '<button class="btn btn-success btn-sm" type="button" onclick="aumentarCantidad(' + cont +
                ')"><i class="fa fa-plus"></i></button>' +
                '</div>' +
                '</td>' +
                '<td><button class="btn btn-danger" type="button" onClick="eliminarInsumo(' + cont +
                ')"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';

            $('#tabla_detalle tbody').append(fila);
            limpiarCampos();
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

function limpiarCampos() {
    let selectNombre = $('#nombre');
    let selectVariante = $('#variante');

    selectNombre.selectpicker('val', ''); // Limpiar select de nombre
    selectVariante.selectpicker('val', ''); // Limpiar select de variante
    $('#stock').val('');
    $('#invima').val('');
    $('#lote').val('');
    $('#vencimiento').val('');

}

function eliminarInsumo(indice) {
    let cantidadEliminada = parseInt($('#fila' + indice).find('input[name="arraycantidad[]"]').val());
    total -= cantidadEliminada;
    $('#fila' + indice).remove();
    $('#total').html(total);
}

function aumentarCantidad(indice) {
    let cantidadInput = $('#fila' + indice).find('input[name="arraycantidad[]"]');
    let cantidad = parseInt(cantidadInput.val());
    cantidad++;
    cantidadInput.val(cantidad);
    total++;
    $('#total').html(total);
}

function disminuirCantidad(indice) {
    let cantidadInput = $('#fila' + indice).find('input[name="arraycantidad[]"]');
    let cantidad = parseInt(cantidadInput.val());
    if (cantidad > 1) {
        cantidad--;
        cantidadInput.val(cantidad);
        total--;
        $('#total').html(total);
    } else {
        eliminarInsumo(indice);
    }
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

function confirmAndSubmit(event) {
    event.preventDefault();
    let proveedor = $('#proveedor_id').val();
    let comprobante = $('#comprobante_id').val();
    let numeroComprobante = $('#numero_comprobante').val();
    let rows = $('#tabla_detalle tbody tr').length;

    if (!proveedor || !comprobante || !numeroComprobante || rows === 1) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se puede realizar la compra'
        });
    } else {
        Swal.fire({
            title: '¿Está seguro?',
            text: 'Desea realizar la compra',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#55aa38',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Acción Exitosa',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    $('#compra-form').submit();
                }, 1500);
            }
        });
    }
}
