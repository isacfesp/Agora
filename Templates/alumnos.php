<?php
include("../Config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../Assets/CSS/alumnos.css">
</head>
<body>
    <div class="container">
    <div class="header-section">
            <br>
            <h2 style="font-weight: 600; margin: 40px 0; font-size: 1.5rem;">Gestión de Alumnos</h2>

        </div>
        <div class="metrics-container">
            <div class="metric-card">
                <div class="metric-value">1,250</div>
                <div class="metric-label">Contactos totales</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">92%</div>
                <div class="metric-label">Activos</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">45</div>
                <div class="metric-label">Nuevos este mes</div>
            </div>
        </div>
        <div class="filter-container mb-3 d-flex justify-content-between align-items-center">
        <input type="date" id="startDate" class="form-control me-2" style="width: 160px;" placeholder="Desde">
                <input type="date" id="endDate" class="form-control me-2" style="width: 160px;" placeholder="Hasta" disabled>
                <button class="btn btn-success" id="filterDate"><i class="fas fa-filter"></i> Filtrar</button>
            </div>  
            <table id="alumnostable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Matrícula</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function (){
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
                                <a href="../Modules/Alumnos/alumno.php"><i class="fa-solid fa-sliders"></i></a>
                            `;
                        }
                    }
                ]
                });

                $('#filterDate').click(function () {
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();

            /*    if (startDate && endDate) {
                    table.ajax.url(`../Modules/Contacts/api_contactos.php?start=${startDate}&end=${endDate}`).load();
                } else {
                    table.ajax.url('../Modules/Contacts/api_contactos.php').load();
                }  */
            });
        });
    </script>
</body>
</html>