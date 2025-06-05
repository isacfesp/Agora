$(document).ready(function() {
    // Cargar los datos de filtros
    $.ajax({
        url: '../Modules/Grupos/get_filtros.php',
        type: 'GET',
        success: function(response) {
            // Cargar grados
            response.grados.forEach(function(grado) {
                $('#filtroGrado').append(
                    `<option value="${grado.id}">${grado.descripcion}</option>`
                );
            });

            // Cargar profesores
            response.profesores.forEach(function(profesor) {
                $('#filtroProfesor').append(
                    `<option value="${profesor.id}">${profesor.nombre}</option>`
                );
            });

            // Cargar periodos
            response.periodos.forEach(function(periodo) {
                $('#filtroPeriodo').append(
                    `<option value="${periodo.id}">${periodo.fecha}</option>`
                );
            });
        }
    });

    // Inicializar DataTable
    let table = $('#gruposTable').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            url: '../Modules/Grupos/fetch_grupos.php',
            dataSrc: function(json) {
                // Llenar los filtros con datos únicos de la tabla
                let grupos = [...new Set(json.data.map(item => item.id_grupo))].sort((a,b) => a-b);
                let grados = [...new Set(json.data.map(item => item.grado))].sort();
                let profesores = [...new Set(json.data.map(item => item.profesor))].sort();
                let periodos = [...new Set(json.data.map(item => item.periodo))].sort();

                // Limpiar y llenar filtros
                $('#filtroGrupo').html('<option value="">Todos los grupos</option>');
                grupos.forEach(grupo => {
                    if(grupo) $('#filtroGrupo').append(`<option value="${grupo}">Grupo ${grupo}</option>`);
                });

                $('#filtroGrado').html('<option value="">Todos los grados</option>');
                $('#filtroProfesor').html('<option value="">Todos los profesores</option>');
                $('#filtroPeriodo').html('<option value="">Todos los periodos</option>');

                grados.forEach(grado => {
                    if(grado) $('#filtroGrado').append(`<option value="${grado}">${grado}</option>`);
                });
                profesores.forEach(profesor => {
                    if(profesor) $('#filtroProfesor').append(`<option value="${profesor}">${profesor}</option>`);
                });
                periodos.forEach(periodo => {
                    if(periodo) $('#filtroPeriodo').append(`<option value="${periodo}">${periodo}</option>`);
                });

                return json.data;
            }
        },
        columns: [
            { 
                data: 'id_grupo',
                title: 'Grupo',
                render: function(data) {
                    return 'Grupo ' + data;
                }
            },
            { data: 'grado' },
            { data: 'profesor' },
            { data: 'periodo' },
            { 
                data: 'total_alumnos',
                title: 'Total Alumnos',
                className: 'text-center'
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info" onclick="editarGrupo(${row.id_grupo})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarGrupo(${row.id_grupo})">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        initComplete: function () {
            // Aplicar búsqueda por columna
            this.api().columns().every(function (index) {
                var column = this;
                var footer = $(column.footer());
                var input = footer.find('input, select');

                if (input.length > 0) {
                    input.on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });

                    // Cargar opciones únicas para los selects
                    if (input.is('select')) {
                        var options = column.data().unique().sort().toArray();
                        options.forEach(function(d) {
                            if (d) input.append(`<option value="${d}">${d}</option>`);
                        });
                    }
                }
            });
        },
        language: {
            "sProcessing": "",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sInfoThousands": ",",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });

    // Eventos de filtrado
    $('#filtroGrupo, #filtroGrado, #filtroProfesor, #filtroPeriodo').on('change', function() {
        let columnIndex = $(this).parent().index();
        let searchValue = this.value;
        table.column(columnIndex).search(searchValue).draw();
    });

    // Limpiar filtros
    $('#btnLimpiarFiltros').click(function() {
        $('#filtroGrupo, #filtroGrado, #filtroProfesor, #filtroPeriodo').val('');
        table.search('').columns().search('').draw();
    });
});