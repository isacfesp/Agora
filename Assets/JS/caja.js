// filepath: c:\xampp\htdocs\Agora\Assets\JS\caja.js
$(document).ready(function () {
    // Cargar filtros
    $.getJSON('../Modules/Alumnos/get_filters.php', function (data) {
        data.grupos.forEach(grupo => {
            $('#grupoFilter').append(`<option value="${grupo.id_grupo}">Grupo ${grupo.id_grupo}</option>`);
        });
        data.grados.forEach(grado => {
            $('#gradoFilter').append(`<option value="${grado.id_grado}">${grado.descripcion}</option>`);
        });
    });

    const table = $('#cajatable').DataTable({
        ajax: {
            url: '../Modules/Caja/fetch_caja.php',
            dataSrc: '',
            data: function (d) {
                d.grupo = $('#grupoFilter').val();
                d.grado = $('#gradoFilter').val();
            }
        },
        language: {
            "decimal": ",",
            "emptyTable": "No hay datos disponibles en la tabla",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
            "infoFiltered": "(filtrado de _MAX_ entradas en total)",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se han encontrado resultados",
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        columns: [
            { data: 'id_alumno' },
            { data: 'matricula' },
            { data: 'apaterno' },
            { data: 'amaterno' },
            { data: 'nombre' },
            { data: 'id_grupo' },
            { data: 'grado' },
            {
                data: null,
                orderable: false,
                render: function (data) {
                    return `
                        <button class="btn btn-primary btn-sm" onclick="abrirModalPago('${data.id_alumno}', '${data.matricula}')">
                            <i class="fas fa-money-bill-wave"></i>
                        </button>
                    `;
                }
            }
        ]
    });

    $('#grupoFilter, #gradoFilter').on('change', function () {
        table.ajax.reload();
    });

    $('#limpiarFiltros').click(function() {
        $('#grupoFilter').val('').trigger('change');
        $('#gradoFilter').val('').trigger('change');
        table.search('').columns().search('');
        table.ajax.reload();
        table.draw();
    });

    // Manejo del formulario de pago
    $('#tipoPago').change(function() {
        if (this.value === 'colegiatura') {
            $('#colegiaturaFields').show();
            $('#cajaFields').hide();
        } else if (this.value === 'caja') {
            $('#colegiaturaFields').hide();
            $('#cajaFields').show();
        } else {
            $('#colegiaturaFields').hide();
            $('#cajaFields').hide();
        }
    });

    $('#concepto').change(function() {
        const monto = $(this).find(':selected').data('monto');
        $('#monto').val(monto);
    });

    $('#pagoForm').on('submit', function(e) {
        e.preventDefault();
        $.post('../Modules/Caja/guardar_pago.php', $(this).serialize(), function(response) {
            if (response.status === 'success') {
                showNotification('Pago guardado exitosamente', 'success');
                cargarHistorialPagos($('#alumno_id').val());
            } else {
                showNotification('Error al guardar el pago', 'error');
            }
        }, 'json');
    });

    // Cargar conceptos al abrir el modal
    cargarConceptos();

    // Enviar el formulario para guardar el pago
    $('#cajaForm').on('submit', function (e) {
        e.preventDefault(); // Evitar el comportamiento por defecto del formulario

        const idAlumno = $('#alumno_id').val();
        const idConcepto = $('#conceptoSelect').val();
        const montoFinal = $('#montoInput').data('monto-final'); // Monto ya descontado
        const metodoPago = $(this).find('[name="metodo_pago"]').val();

        if (!idConcepto || !montoFinal || !metodoPago) {
            alert('Por favor, complete todos los campos antes de guardar el pago.');
            return;
        }

        $.ajax({
            url: '../Modules/Caja/guardar_pago.php',
            type: 'POST',
            data: {
                id_alumno: idAlumno,
                concepto: idConcepto,
                monto: montoFinal,
                metodo_pago: metodoPago
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert('Pago guardado exitosamente.');
                    $('#pagoModal').modal('hide'); // Cerrar el modal
                    cargarHistorialPagos(idAlumno); // Actualizar el historial de pagos
                } else {
                    alert('Error al guardar el pago: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al guardar el pago:', error);
                alert('Error al guardar el pago. Por favor, intente nuevamente.');
            }
        });
    });

    cargarConceptos();
});

// Funciones globales
function abrirModalPago(idAlumno, matricula, nombre) {
    console.log('Abriendo modal para alumno:', idAlumno); // Debug
    $('#alumno_id').val(idAlumno);
    $('#alumno_id_col').val(idAlumno);
    $('#alumnoInfo').text(`Matrícula: ${matricula} `);
    cargarHistorialPagos(idAlumno);
    $('#pagoModal').modal('show');
}

// Agregar esta función al inicio del archivo
function showNotification(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' : 
                       type === 'error' ? 'alert-danger' : 
                       'alert-info';

    const notification = $(`
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `).appendTo('#notifications');

    setTimeout(() => notification.alert('close'), 5000);
}

function cargarHistorialPagos(idAlumno) {
    $.ajax({
        url: '../Modules/Caja/get_pagos.php',
        type: 'GET',
        data: { id_alumno: idAlumno },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                const cajaTbody = $('#historialCaja tbody');
                const colegiaturaTbody = $('#historialColegiatura tbody');
                cajaTbody.empty();
                colegiaturaTbody.empty();

                response.data.caja.forEach(pago => {
                    cajaTbody.append(`
                        <tr>
                            <td>${pago.fecha_pago}</td>
                            <td>${pago.metodo_pago}</td>
                            <td>${pago.concepto}</td>
                            <td>$${parseFloat(pago.monto).toFixed(2)}</td>
                        </tr>
                    `);
                });

                response.data.colegiatura.forEach(pago => {
                    colegiaturaTbody.append(`
                        <tr>
                            <td>${pago.fecha_pago}</td>
                            <td>${pago.metodo_pago}</td>
                            <td>${pago.mes}</td>
                            <td>$${parseFloat(pago.monto).toFixed(2)}</td>
                        </tr>
                    `);
                });
            } else {
                console.error('Error al cargar pagos:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar pagos:', error);
        }
    });
}

function cargarConceptos() {
    const idAlumno = $('#alumno_id').val(); // Obtener el ID del alumno

    $.ajax({
        url: '../Modules/Caja/get_conceptos.php',
        type: 'GET',
        data: { id_alumno: idAlumno },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                const conceptoSelect = $('#conceptoSelect');
                conceptoSelect.empty();
                conceptoSelect.append('<option value="" disabled selected>Seleccione un concepto</option>');
                response.data.forEach(concepto => {
                    conceptoSelect.append(`
                        <option value="${concepto.id_concepto}" data-precio="${concepto.precio}" data-descuento="${concepto.descuento}">
                            ${concepto.nombre}
                        </option>
                    `);
                });
            } else {
                console.error('Error al cargar conceptos:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar conceptos:', error);
        }
    });
}

$('#conceptoSelect').on('change', function() {
    const precio = $(this).find(':selected').data('precio');
    const descuento = $(this).find(':selected').data('descuento') || 0;
    const montoFinal = precio - descuento;

    // Mostrar el monto final en el campo de monto
    $('#montoInput').val(`$${montoFinal.toFixed(2)}`);
    $('#montoInput').data('monto-final', montoFinal); // Guardar el monto final internamente

    // Mostrar el descuento afuera del campo de monto
    if (descuento > 0) {
        $('#descuentoInfo').text(`Descuento aplicado: -$${descuento.toFixed(2)}`).show();
    } else {
        $('#descuentoInfo').hide();
    }
});