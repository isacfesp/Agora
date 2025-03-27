<?php
include "../Modules/Contacts/metricasContactos.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Contact List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../Assets/CSS/contactos.css">
</head>

<body>
    <div class="container">
        <div class="header-section">
            <br>
            <h2 style="font-weight: 600; margin: 40px 0; font-size: 1.5rem;">Gestión de Contactos</h2>

        </div>
        <div class="metrics-container">
            <div class="metric-card">
                <div class="metric-value"><?php echo $contador; ?></div>
                <div class="metric-label">Contactos totales</div>
            </div>
            <div class="metric-card">
                <div class="metric-value"></div>
                <div class="metric-label"></div>
            </div>
            <div class="metric-card">
                <div class="metric-value"><?php echo $conteoMes; ?></div>
                <div class="metric-label">Nuevos este mes</div>
            </div>
        </div>
        <div class="filter-container mb-3 d-flex justify-content-between align-items-center">
            <a href="../Modules/Contacts/Crear.php" class="btn btn-primary" id="addRecord"><i
                    class="fas fa-user-plus"></i> Crear
                Contacto</a>
            <a href="" class="btn btn-danger" id="printPDF"><i class="fas fa-file-pdf"></i> Imprimir</a>
            <div class="d-flex">
                <input type="date" id="startDate" class="form-control me-2" style="width: 160px;" placeholder="Desde">
                <input type="date" id="endDate" class="form-control me-2" style="width: 160px;" placeholder="Hasta"
                    disabled>
                <button class="btn btn-success" id="filterDate"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
        </div>
        <table id="contactosTable" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Número Telefónico</th>
                    <th>WhatsApp</th>
                    <th>Formato</th>
                    <th>Fecha Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se llenarán los datos xd -->
            </tbody>
        </table>
    </div>
    <center>

        <!-- Modal de edición -->
        <div id="editar" class="overlay">
            <div class="popup">
                <h2>Edición de Datos</h2>
                <form id="formData">
                    <input type="hidden" id="contactoId" name="contactoId">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>

                    <label for="apellidoPaterno">Apellido Paterno:</label>
                    <input type="text" id="apellidoPaterno" name="apellidoPaterno"
                        placeholder="Ingrese su apellido paterno" required>

                    <label for="apellidoMaterno">Apellido Materno:</label>
                    <input type="text" id="apellidoMaterno" name="apellidoMaterno"
                        placeholder="Ingrese su apellido materno" required>

                    <label for="telefono">Número Telefónico:</label>
                    <input type="text" id="telefono" name="telefono" placeholder="Ingrese su número telefónico"
                        required>

                    <label for="whatsapp">Whatsapp:</label>
                    <select class="form-control" id="whatsapp" name="whatsapp" required>
                        <option value="">Selecciona una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>

                    <label for="formato">Formato:</label>
                    <input type="text" id="formato" name="formato" placeholder="Ingrese el formato" required>

                    <div>
                        <button type="button" class="btn btn-success" onclick="guardarEdicion()">Guardar</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelar()">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </center>

    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="borrar" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este contacto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <center>
        <!--Inscribir-->
        <div id="inscribir" class="overlay">
            <div class="popup">
                <form id="formI" action="../Modules/Contacts/inscribir.php" method="post" target="_blank">
                    <h4><strong>Inscribir Contacto</strong></h4>
                    <div class="form-group">
                        <label>Carrera/Especialidad/Cursos:</label> <br>
                        <label>Mecánica en Reparación de Motocicletas</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="horario">Horario:</label>
                            <select class="form-control" name="horario" id="horario" required>
                                <option value="">Selecciona una opción</option>
                                <option value="Semanal">Semanal</option>
                                <option value="Sabatino">Sabatino</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="matricula">Matrícula:</label>
                            <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matrícula" required>
                        </div>
                    </div>
                    <h5><strong>DATOS DEL ALUMNO:</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="apaterno">Apellido Paterno:</label>
                            <input type="text" class="form-control" id="apaterno" name="apaterno" placeholder="Apellido Paterno" pattern="[A-Za-z\s]+" title="Solo caracteres alfabéticos" maxlength="150" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amaterno">Apellido Materno:</label>
                            <input type="text" class="form-control" id="amaterno" name="amaterno" placeholder="Apellido Materno"  pattern="[A-Za-z\s]+" title="Solo caracteres  alfabéticos" maxlength="150" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombre(s):</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nombre(s)" pattern="[A-Za-z\s]+" title="Solo caracteres alfabéticos" maxlength="150" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nacimiento">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" id="nacimiento" name="nacimiento" placeholder="DD/MM/AAAA" onchange="calcularEdad()" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="edad">Edad:</label>
                            <input type="text" class="form-control" id="edad" name="edad" placeholder="Edad" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="curp">CURP:</label>
                            <input type="text" class="form-control" id="curp" name="curp" placeholder="CURP" pattern="^[A-Z0-9]{18}$" title="Debe contener 18 caracteres alfanúmericos" minlength="18" maxlength="18" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="telfijo">Teléfono Fijo:</label>
                            <input type="tel" class="form-control" id="telfijo" pattern="[+()0-9\s-]+" name="telfijo" placeholder="Teléfono Fijo" title="Debe contener al menos 10 dígitos" minlength="10" maxlength="20" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="celular">Teléfono Celular:</label>
                            <input type="tel" class="form-control" id="celular" pattern="[+()0-9\s-]+" name="celular" placeholder="Teléfono Celular" title="Debe contener al menos 10 dígitos" minlength="10" maxlength="20" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <h5><strong>DIRECCIÓN:</strong></h5>
                    <div class="form-group">
                        <label for="calle">Calle y No.:</label>
                        <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" maxlength="150" required>
                    </div>
                 <div class="form-group">
                        <label for="colonia">Colonia:</label>
                        <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia" maxlength="150" required>
                    </div>
                    <div class="form-group">
                        <label for="codpostal">C.P:</label>
                        <input type="number" class="form-control" id="codpostal" name="codpostal" placeholder="Código Postal" title="Debe contener 5 dígitos" pattern="\d{5}"   maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label for="municipio">Municipio:</label>
                        <input type="text" class="form-control" id="municipio" name="municipio" placeholder="Municipio" maxlength="150" required>
                    </div>
                    <h5><strong>DATOS DEL PADRE O TUTOR:</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tutor_apaterno">Apellido Paterno:</label>
                            <input type="text" class="form-control" id="tutor_apaterno" name="tutor_apaterno"  placeholder="Apellido Paterno" pattern="[A-Za-z\s]+" title="Solo caracteres alfabéticos" maxlength="150" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tutor_amaterno">Apellido Materno:</label>
                            <input type="text" class="form-control" id="tutor_amaterno" name="tutor_amaterno" title="Solo caracteres alfabéticos" placeholder="Apellido Materno" pattern="[A-Za-z\s]+" maxlength="150" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tutor_nombre">Nombre(s):</label>
                            <input type="text" class="form-control" id="tutor_nombre" name="tutor_nombre" title="Solo caracteres alfabéticos" placeholder="Nombre(s)" pattern="[A-Za-z\s]+" maxlength="150" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tutor_telfijo">Teléfono Fijo:</label>
                            <input type="tel" class="form-control" minlength="10" pattern="[+()0-9\s-]+" id="tutor_telfijo" name="tutor_telfijo" title="Debe contener al menos 10 dígitos" placeholder="Teléfono Fijo" maxlength="20" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tutor_celular">Teléfono Celular:</label>
                            <input type="tel" class="form-control" minlength="10" pattern="[+()0-9\s-]+" id="tutor_celular" name="tutor_celular" title="Debe contener al menos 10 dígitos" placeholder="Teléfono Celular" maxlength="20" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tutor_email">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="tutor_email" name="tutor_email" placeholder="Email" required>
                        </div>
                    </div>
                    <h5><strong>EN CASO DE EMERGENCIA COMUNICARSE CON:</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="emergencia_apaterno">Apellido Paterno:</label>
                            <input type="text" class="form-control" id="emergencia_apaterno" name="emergencia_apaterno" title="Solo caracteres alfabéticos" placeholder="Apellido Paterno" pattern="[A-Za-z\s]+" maxlength="150" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emergencia_amaterno">Apellido Materno:</label>
                            <input type="text" class="form-control" id="emergencia_amaterno" name="emergencia_amaterno" title="Solo caracteres alfabéticos" placeholder="Apellido Materno" pattern="[A-Za-z\s]+" maxlength="150" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="emergencia_nombre">Nombre(s):</label>
                            <input type="text" class="form-control" id="emergencia_nombre" name="emergencia_nombre" title="Solo caracteres alfabéticos" placeholder="Nombre(s)" pattern="[A-Za-z\s]+" maxlength="150" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-11">
                                <label for="parentesco">Parentesco:</label>
                                <input type="text" class="form-control" id="parentesco" name="parentesco" title="Solo caracteres alfabéticos" placeholder="Parentesco" pattern="[A-Za-z\s]+" maxlength="150" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="emergencia_telefono">Teléfono:</label>
                            <input type="tel" class="form-control" minlength="10" pattern="[+()0-9\s-]+" id="emergencia_telefono" title="Debe contener al menos 10 dígitos" name="emergencia_telefono" placeholder="Teléfono" maxlength="20" required>
                        </div> 
                        <div>
                            <button type="submit" class="btn btn-success" onclick="guardarInscripcion()">Guardar</button>
                            <button type="submit" class="btn btn-danger" onclick="cancelarInscripcion()">Cancelar</button>
                        </div> 
                    </div>
                </form>
            </div> 
        </div>
    </center>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../Assets/JS/contactos.js"></script>
</body>
</html>