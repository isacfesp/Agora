$(document).ready(function () {
    const startDateInput = $('#startDate');
    const endDateInput = $('#endDate');

    endDateInput.prop('disabled', true);

    startDateInput.on('change', function () {
        const startDate = startDateInput.val();
        if (startDate) {
            endDateInput.prop('disabled', false);
            endDateInput.attr('min', startDate);
        } else {
            endDateInput.prop('disabled', true);
        }
    });

    endDateInput.on('change', function () {
        const startDate = startDateInput.val();
        const endDate = endDateInput.val();

        if (startDate && new Date(endDate) < new Date(startDate)) {
            alert("La fecha final no puede ser antes de la fecha inicial.");
            endDateInput.val('');
        }
    });

    let table = $('#contactosTable').DataTable({
        ajax: {
            url: '../Modules/Contacts/api_contactos.php',
            dataSrc: '',
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
            },
            "aria": {
                "sortAscending": ": activar para ordenar la columna de manera ascendente",
                "sortDescending": ": activar para ordenar la columna de manera descendente"
            }
        },
        columns: [
            { data: 'id_contacto' },
            { data: 'nombre' },
            { data: 'apaterno' },
            { data: 'amaterno' },
            { data: 'numero_telefonico' },
            { data: 'whatsapp' },
            { data: 'formato' },
            { data: 'fecha_creacion' },
            {
                data: null,
                render: function (data) {
                    return `
                        <button class="btn btn-warning btn-sm edit-btn" data-id="${data.id_contacto}" onclick="abrirEdicion('${data.id_contacto}')"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${data.id_contacto}" onclick="confirmarEliminacion('${data.id_contacto}')"><i class="fas fa-trash-alt"></i></button>
                        <button class="btn btn-basic btn-sm inscribir-btn" data-id="${data.id_contacto}" onclick="inscribirContacto('${data.id_contacto}')"><i class="fa-solid fa-file"></i></button>
                    `;
                }
            }
        ]
    });

    $('#filterDate').click(function () {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        if (startDate && endDate) {
            table.ajax.url(`../Modules/Contacts/api_contactos.php?start=${startDate}&end=${endDate}`).load();
        } else {
            table.ajax.url('../Modules/Contacts/api_contactos.php').load();
        }
    });

    $('#printPDF').click(function () {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        let url = '../Modules/Contacts/reporte.php';

        if (startDate && endDate) {
            url += `?start=${startDate}&end=${endDate}`;
        }

        window.open(url, '_blank');
    });
});

function abrirEdicion(id) {
    $.getJSON(`../Modules/Contacts/fetch_contacto.php?id=${id}`, function (data) {
        $('#contactoId').val(data.id_contacto);
        $('#nombre').val(data.nombre);
        $('#apellidoPaterno').val(data.apaterno);
        $('#apellidoMaterno').val(data.amaterno);
        $('#telefono').val(data.numero_telefonico);
        $('#whatsapp').val(data.whatsapp);
        $('#formato').val(data.formato);
        $('#editar').show();
    });
}

function guardarEdicion() {
    let formData = $('#formData').serialize();
    $.post('../Modules/Contacts/Actualizar.php', formData, function () {
        $('#editar').hide();
        $('#contactosTable').DataTable().ajax.reload();
    });
}

function confirmarEliminacion(id) {
    $('#confirmDelete').off().on('click', function () {
        $.post(`../Modules/Contacts/Eliminar.php`, { id }, function () {
            $('#borrar').modal('hide');
            $('#contactosTable').DataTable().ajax.reload();
        });
    });
    $('#borrar').modal('show');
}

function inscribirContacto(id) {
    $.getJSON(`../Modules/Contacts/fetch_contacto.php?id=${id}`, function (data) {
        const url = `../Modules/Inscribir/inscribir.php?apaterno=${data.apaterno}&amaterno=${data.amaterno}&nombre=${data.nombre}&celular=${data.numero_telefonico}`;
        window.location.href = url;
    });
}

function calcularEdad() {
    const nacimientoInput = document.getElementById('nacimiento').value;
    const nacimiento = new Date(nacimientoInput);
    const actual = new Date();
    if(actual.getMonth() >= nacimiento.getMonth()){
        if(actual.getDate() >= nacimiento.getDate()){
            let edad = actual.getFullYear() - nacimiento.getFullYear();
            document.getElementById('edad').value = edad;
        } else{
            let edad = actual.getFullYear() - nacimiento.getFullYear() - 1;
            document.getElementById('edad').value = edad;
        }
    } else{
        let edad = actual.getFullYear() - nacimiento.getFullYear() - 1;
        document.getElementById('edad').value = edad;
    }
}

function guardarInscripcion(){
    let formI = $('#formI').serialize();
    $.post('../Modules/Contacts/Inscribir.php', formI, function(){
        $('#inscribir').hide();
        $('#alumnosTable').DataTable().ajax.url('alumnos.php').load();
    });
}

function cancelarInscripcion(){
    $('#inscribir').hide();
}

function cancelar() {
    $('#editar').hide();
}