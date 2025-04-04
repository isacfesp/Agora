<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primario: #BBCD5D;
            --color-secundario: #3C4046;
            --color-acento: #DC3545;
        }
        
        body { 
            background-color: #f7f9fb; 
            padding: 25px;
        }
        
        .main-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .section-title {
            color: var(--color-secundario);
            border-left: 4px solid var(--color-primario);
            padding-left: 15px;
            margin: 25px 0;
            font-weight: 600;
        }
        
        .form-control:disabled {
            background: transparent;
            border: none;
            padding-left: 0;
            color: var(--color-secundario);
        }
        
        .btn-edit {
            background-color: var(--color-primario);
            border: none;
            color: var(--color-secundario);
        }
        
        .documentacion-card {
            border: 2px solid var(--color-primario);
            border-radius: 10px;
        }
        
        .form-check-input:checked {
            background-color: var(--color-primario);
            border-color: var(--color-primario);
        }
    </style>
</head>
<body>
    <div class="container main-container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0" style="color: var(--color-secundario);">Información del Alumno</h2>
                <small class="text-muted">Matrícula: 123456 | Estado: Activo</small>
            </div>
            <button class="btn btn-edit" onclick="toggleEdit()" id="btnEditar">Editar</button>
        </div>

        <!-- Datos Básicos -->
        <h4 class="section-title">Datos Personales</h4>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <label>Apellido Paterno</label>
                <input type="text" class="form-control" value="González" disabled>
            </div>
            <div class="col-md-4">
                <label>Apellido Materno</label>
                <input type="text" class="form-control" value="López" disabled>
            </div>
            <div class="col-md-4">
                <label>Nombre(s)</label>
                <input type="text" class="form-control" value="Juan Carlos" disabled>
            </div>
            
            <div class="col-md-3">
                <label>CURP</label>
                <input type="text" class="form-control" value="GOOL920101HDFLPC01" disabled>
            </div>
            <div class="col-md-3">
                <label>Fecha Nacimiento</label>
                <input type="date" class="form-control" value="1992-01-01" disabled>
            </div>
            <div class="col-md-3">
                <label>Edad</label>
                <input type="number" class="form-control" value="31" disabled>
            </div>
            <div class="col-md-3">
                <label>Horario</label>
                <input type="text" class="form-control" value="Matutino" disabled>
            </div>
        </div>

        <!-- Contacto y Dirección -->
        <div class="row">
            <div class="col-md-6">
                <h4 class="section-title">Información de Contacto</h4>
                <div class="row g-3">
                    <div class="col-12">
                        <label>Correo Electrónico</label>
                        <input type="email" class="form-control" value="juan@example.com" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Teléfono Fijo</label>
                        <input type="tel" class="form-control" value="555-1234" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Teléfono Celular</label>
                        <input type="tel" class="form-control" value="55-1234-5678" disabled>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <h4 class="section-title">Dirección</h4>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label>Calle</label>
                        <input type="text" class="form-control" value="Av. Reforma" disabled>
                    </div>
                    <div class="col-md-4">
                        <label>Número</label>
                        <input type="text" class="form-control" value="123" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Colonia</label>
                        <input type="text" class="form-control" value="Centro" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>CP</label>
                        <input type="number" class="form-control" value="06000" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Municipio</label>
                        <input type="text" class="form-control" value="CDMX" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tutores y Emergencia -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h4 class="section-title">Datos del Tutor</h4>
                <div class="row g-3">
                    <div class="col-12">
                        <label>Nombre Completo</label>
                        <input type="text" class="form-control" value="María López Hernández" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Teléfono Fijo</label>
                        <input type="tel" class="form-control" value="555-4321" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Teléfono Celular</label>
                        <input type="tel" class="form-control" value="55-8765-4321" disabled>
                    </div>
                    <div class="col-12">
                        <label>Correo Electrónico</label>
                        <input type="email" class="form-control" value="tutor@example.com" disabled>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <h4 class="section-title">Contacto de Emergencia</h4>
                <div class="row g-3">
                    <div class="col-12">
                        <label>Nombre Completo</label>
                        <input type="text" class="form-control" value="Pedro Martínez Sánchez" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Parentesco</label>
                        <input type="text" class="form-control" value="Tío" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Teléfono Contacto</label>
                        <input type="tel" class="form-control" value="55-9999-8888" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentación -->
        <div class="documentacion-card mt-4 p-4">
            <h4 class="section-title mb-4">Documentación Entregada</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="ine" disabled>
                        <label class="form-check-label" for="ine">INE/Identificación Oficial</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="acta" disabled>
                        <label class="form-check-label" for="acta">Acta de Nacimiento</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="domicilio" disabled>
                        <label class="form-check-label" for="domicilio">Comprobante de Domicilio</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="estudios" disabled>
                        <label class="form-check-label" for="estudios">Comprobante de Estudios</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="curpDoc" disabled>
                        <label class="form-check-label" for="curpDoc">CURP</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="d-flex justify-content-end gap-3 mt-4 d-none" id="botonesAccion">
            <button class="btn" onclick="cancelEdit()" 
                    style="background-color: var(--color-acento); color: white;">Cancelar</button>
            <button class="btn" onclick="saveChanges()" 
                    style="background-color: var(--color-primario); color: var(--color-secundario);">Guardar Cambios</button>
        </div>
    </div>

    <script>
        let isEditing = false;
        let originalValues = {};

        function toggleEdit() {
            isEditing = !isEditing;
            const inputs = document.querySelectorAll('input');
            const checkboxes = document.querySelectorAll('.form-check-input');
            
            inputs.forEach((input, index) => {
                if(input.type !== 'checkbox') {
                    input.disabled = !isEditing;
                    if(isEditing) {
                        originalValues[index] = input.value;
                        input.classList.add('bg-light');
                    } else {
                        input.classList.remove('bg-light');
                    }
                }
            });
            
            checkboxes.forEach(checkbox => {
                checkbox.disabled = !isEditing;
            });
            
            document.getElementById('btnEditar').classList.toggle('d-none');
            document.getElementById('botonesAccion').classList.toggle('d-none');
        }

        function saveChanges() {
            // Lógica para guardar cambios
            toggleEdit();
            alert('Cambios guardados exitosamente');
        }

        function cancelEdit() {
            // Revertir valores
            const inputs = document.querySelectorAll('input');
            inputs.forEach((input, index) => {
                if(input.type !== 'checkbox') {
                    input.value = originalValues[index];
                }
            });
            toggleEdit();
            alert('Edición cancelada');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>