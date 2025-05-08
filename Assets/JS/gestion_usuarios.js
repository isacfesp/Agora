$(document).ready(function() {
    const usuariosTable = $('#usuariosTable').DataTable({
        ajax: {
            url: '../Modules/Gestion_Usuarios/apiUsuario.php',
            dataSrc: ''
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
         //   url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        columns: [
            { data: 'id_usuario' },
            { data: 'email' },
            { 
                data: null,
                render: function(data, type, row) {
                    return row.nombre + ' ' + row.apaterno + ' ' + row.amaterno;
                }
            },
            { 
                data: 'estado',
                render: function(data, type, row) {
                    const estado = parseInt(data) === 1 ? 'Activo' : 'Inactivo';
                    const color = parseInt(data) === 1 ? '#198754' : '#DC3545';
                    return `<div class="d-flex align-items-center gap-2">
                        <span class="estado-circle" style="background-color: ${color}"></span>
                        ${estado}
                    </div>`;
                }
            },
            { data: 'tipo_usuario' },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-warning edit-btn" data-id="${data.id_usuario}" onclick="EditarUsuario('${data.id_usuario}')" title="Editar usuario">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" data id="${data.id_usuario}" onclick="EliminarUsuario('${data.id_usuario}')" title="Eliminar usuario">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-sm view-btn" style="background-color: #3C4046; color: white;" data-id="${data.id_usuario}" title="Ver detalles">
                                <i class="fas fa-circle-info"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        order: [[0, 'desc']],
        responsive: true
    });

    // Event handlers for buttons
    $('#usuariosTable').on('click', '.edit-btn', function() {
        const userId = $(this).data('id');
        // Implement edit functionality
        console.log('Edit user:', userId);
    });

    $('#usuariosTable').on('click', '.view-btn', function() {
        const userId = $(this).data('id');
        // Implement view functionality
        console.log('View user:', userId);
    });

    // Add new user button handler
    $('#addUser').on('click', function(e) {
        e.preventDefault();
        // Implement add user functionality
        console.log('Add new user');
    });

});

function EditarUsuario(id){
    $.getJSON(`../Modules/Gestion_Usuarios/fetch_usuario.php?id=${id}`, function (data, type, row){
        $('#email').val(data.email);
        $('#nombre').val(data.nombre + '' + data.apaterno + '' + data.amaterno);
        $('estado').val(data.estado);
        $('#tipo').val(data.tipo_usuario);
        $('#editarU').show();
    });
}

function guardarE(){
    let formE = $('#formE').serialize();
    $.post('../Modules/Gestion_Usuarios/actualizar_usuario.php', formE, function () {
        $('#editarU').hide();
        $('#usuariosTable').DataTable().ajax.reload();
    });
}

function cancelarE(){
    $('#editarU').hide();
}

function EliminarUsuario(id){
    $('#borrar').show();
}

function eliminarU(id){
    $.post(`../Modules/Gestion_Usuarios/eliminar_usuario.php`, {id}, function(){
        $('#borrar').hide();
        $('#usuariosTable').DataTable().ajax.reload();
    });
}

function cancelarD(){
    $('#borrar').hide();
}
