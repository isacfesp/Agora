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
    
    let table = $('#alumnostable').DataTable({
        ajax: {
            url: '../Modules/Alumnos/fetch_alumnos.php',
            dataSrc: '',
            data: function(d) {
                d.periodo = $('#periodoFilter').val();
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
            },
            "aria": {
                "sortAscending": ": activar para ordenar la columna de manera ascendente",
                "sortDescending": ": activar para ordenar la columna de manera descendente"
            }
        },
        columns: [
            { data: 'id_alumno' },
            { data: 'matricula' },
            { data: 'apaterno' },
            { data: 'amaterno' },
            { data: 'nombre' },
            {
                data: null,
                render: function (data) {
                    return `
                        <button class="btn btn-default btn-sm historial-btn" data-id="${data.id_alumno}" onclick="historial('${data.id_alumno}')"><i class="fa-solid fa-sliders"></i></button>
                    `;
                }
            }
        ]
    });

    $('#periodoFilter').on('change', function() {
        table.ajax.reload();
    });

    $('#filterDate').click(function () {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        table.ajax.reload();
    });
});

function historial(id) {
    $.getJSON(`../Modules/Alumnos/fetch_alumno.php?id=${id}`, function (data) {
        const url = `../Modules/Alumnos/alumno.php?id_alumno=${data.id_alumno}`;
        window.location.href = url;
    });
}