<?php
include("../Config/conexion.php");
include("../Modules/Alumnos/metricasAlumnos.php");
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
                <div class="metric-value"><?php echo $contar ?></div>
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
            <select id="periodoFilter" class="form-control me-2" style="width: 200px;">
                <option value="">Todos los periodos</option>
                <?php 
                $sqlPeriodos = "SELECT * FROM periodo";
                $resultPeriodos = mysqli_query($connection, $sqlPeriodos);
                while ($rowPeriodo = mysqli_fetch_assoc($resultPeriodos)) {
                    echo '<option value="' . $rowPeriodo['id_periodo'] . '">' . $rowPeriodo['descripcion'] . '</option>';
                }
                ?>
            </select>
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

        function historial(id){
            $.getJSON(`../Modules/Alumnos/fetch_alumno.php?id=${id}`, function (data) {
                const url = `../Modules/Alumnos/alumno.php?apaterno=${data.apaterno}&amaterno=${data.amaterno}&nombre=${data.nombre}&nacimiento=${data.nacimiento}&edad=${data.edad}&curp=${data.curp}&email=${data.email}&celular=${data.tel_celular}&telefono=${data.tel_fijo}&calle=${data.calle}&colonia=${data.colonia}&cp=${data.cp}&municipio=${data.municipio}&t_apaterno=${data.tutor_apaterno}&t_amaterno=${data.tutor_amaterno}&t_nombre=${data.tutor_nombre}&t_email=${data.tutor_email}&e_apaterno=${data.emergencia_apaterno}&e_amaterno=${data.emergencia_amaterno}&e_nombre=${data.emergencia_nombre}&e_parentesco=${data.emergencia_parentesco}&e_telefono=${data.emergencia_tel}`;
                window.location.href = url;
            });
        }
    </script>
</body>
</html>