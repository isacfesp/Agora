<?php
$apaterno = isset($_GET['apaterno']) ? $_GET['apaterno'] : '';
$amaterno = isset($_GET['amaterno']) ? $_GET['amaterno'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$celular = isset($_GET['celular']) ? $_GET['celular'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscribir</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../Assets/CSS/inscribir.css">
</head>

<body>
    <div class="container mt-5">
        <div class="custom-container p-4">
            <button class="btn print-button" onclick="openPDF()"><i class="fas fa-file-pdf"></i> Imprimir</button>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label>Carrera/Especialidad/Cursos:</label> <br>
                    <label>Mecánica en Reparación de Motocicletas</label>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="horario">Horario:</label>
                        <select class="form-control" name="horario" id="horario" required>
                            <option value="0">Selecciona una opción</option>
                            <option value="1">Semanal</option>
                            <option value="2">Sabatino</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="periodo">Periodo:</label>
                        <input type="text" class="form-control" id="periodo" name="periodo" placeholder="Periodo" required readonly>
                    </div>
                </div>
                <h5><strong>DATOS DEL ALUMNO:</strong></h5>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="apaterno">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="apaterno" name="apaterno" placeholder="Apellido Paterno" pattern="[A-Za-z\s]+" title="Solo caracteres alfabéticos" maxlength="150" required value="<?php echo $apaterno; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="amaterno">Apellido Materno:</label>
                        <input type="text" class="form-control" id="amaterno" name="amaterno" placeholder="Apellido Materno" pattern="[A-Za-z\s]+" title="Solo caracteres alfabéticos" maxlength="150" required value="<?php echo $amaterno; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre(s)" pattern="[A-Za-z\s]+" title="Solo caracteres alfabéticos" maxlength="150" required value="<?php echo $nombre; ?>">
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
                        <input type="tel" class="form-control" id="telfijo" pattern="[+()0-9\s-]+" name="telfijo" placeholder="Teléfono Fijo" title="Debe contener al menos 10 dígitos" minlength="10" maxlength="20">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="celular">Teléfono Celular:</label>
                        <input type="tel" class="form-control" id="celular" pattern="[+()0-9\s-]+" name="celular" placeholder="Teléfono Celular" title="Debe contener al menos 10 dígitos" minlength="10" maxlength="20" required value="<?php echo $celular; ?>">
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
                    <input type="number" class="form-control" id="codpostal" name="codpostal" placeholder="Código Postal" title="Debe contener 5 dígitos" pattern="\d{5}" maxlength="5" required>
                </div>
                <div class="form-group">
                    <label for="municipio">Municipio:</label>
                    <input type="text" class="form-control" id="municipio" name="municipio" placeholder="Municipio" maxlength="150" required>
                </div>
                <h5><strong>DATOS DEL PADRE O TUTOR:</strong></h5>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tutor_apaterno">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="tutor_apaterno" name="tutor_apaterno" placeholder="Apellido Paterno" pattern="[A-Za-z\s]+" title="Solo caracteres alfabéticos" maxlength="150" required>
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
                    
                </div>
            </form>
            <h5><strong>VALIDACIÓN DE DOCUMENTOS:</strong></h5>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="documento1" name="documento1">
                    <label class="form-check-label" for="documento1">Documento 1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="documento2" name="documento2">
                    <label class="form-check-label" for="documento2">Documento 2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="documento3" name="documento3">
                    <label class="form-check-label" for="documento3">Documento 3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="documento4" name="documento4">
                    <label class="form-check-label" for="documento4">Documento 4</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="documento5" name="documento5">
                    <label class="form-check-label" for="documento5">Documento 5</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="documento6" name="documento6">
                    <label class="form-check-label" for="documento6">Documento 6</label>
                </div>
                <div class="form-group col-md-6 mt-3 d-flex justify-content-start">
                        <button type="submit" class="btn btn-success btn-aceptar mr-2" name="submit">Guardar</button>
                    </div>
            </div>
            <!-- Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<?php
include '../../Config/conexion.php';

$sql = "SELECT MAX(id_alumno) FROM alumno";
$result = $connection->query($sql);
$matricula = $result->fetch_row()[0];
$matriculaDB = $matricula + 1;

?>

<script>
    function openPDF() {
        var pdfUrl = 'solicitud.php';
        window.open(pdfUrl, '_blank');
    }

    function calcularEdad() {
        const nacimientoInput = document.getElementById('nacimiento').value;
        const nacimiento = new Date(nacimientoInput);
        const actual = new Date();
        if (actual.getMonth() >= nacimiento.getMonth()) {
            if (actual.getDate() >= nacimiento.getDate()) {
                let edad = actual.getFullYear() - nacimiento.getFullYear();
                document.getElementById('edad').value = edad;
            } else {
                let edad = actual.getFullYear() - nacimiento.getFullYear() - 1;
                document.getElementById('edad').value = edad;
            }
        } else {
            let edad = actual.getFullYear() - nacimiento.getFullYear() - 1;
            document.getElementById('edad').value = edad;
        }
    }

    function closePopup() {
        document.getElementById('overlay').style.display = 'none';
    }

    document.addEventListener("DOMContentLoaded", function() {
        function matricula() {
            const today = new Date();
            let mes = today.getMonth() + 1;
            let anio = today.getFullYear();

            mes = (mes < 10) ? '0' + mes : mes;
            anio = (anio < 10) ? '0' + anio : anio;

            let año = anio.toString().slice(-2);
            let matriculaDB = "<?php echo "$matriculaDB" ?>";

            matriculaDB = (matriculaDB < 10) ? '00' + matriculaDB : (matriculaDB < 100 && matriculaDB > 10) ? '0' + matriculaDB : matriculaDB;
            var hH = document.getElementById('horario').value;
            var mM = document.getElementById('matricula');
            mM.value = hH !== "0" ? mes + año + hH + matriculaDB : "";
        }

        document.getElementById('horario').addEventListener('change', matricula);
    });
</script>

<!--Ventanas emergentes -->
<div class="overlay" id="overlay" style="display: none;">
    <div class="popup">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark-check" fill="none" stroke="#BBCD5D" stroke-width="5" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <p>¡Operación exitosa!</p>
        <button class="btn-primary" onclick="closePopup()">Aceptar</button>
        <a href="../../Templates/alumnos.php" class="btn-primary">Mostrar</a>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {

        $datos = [
            'horario' => $_POST['horario'],
            'matricula' => $_POST['matricula'],
            'apaterno' => $_POST['apaterno'],
            'amaterno' => $_POST['amaterno'],
            'nombre' => $_POST['nombre'],
            'nacimiento' => $_POST['nacimiento'],
            'edad' => $_POST['edad'],
            'curp' => $_POST['curp'],
            'telfijo' => $_POST['telfijo'],
            'celular' => $_POST['celular'],
            'email' => $_POST['email'],
            'calle' => $_POST['calle'],
            'colonia' => $_POST['colonia'],
            'codpostal' => $_POST['codpostal'],
            'municipio' => $_POST['municipio'],
            'tutor_apaterno' => $_POST['tutor_apaterno'],
            'tutor_amaterno' => $_POST['tutor_amaterno'],
            'tutor_nombre' => $_POST['tutor_nombre'],
            'tutor_telfijo' => $_POST['tutor_telfijo'],
            'tutor_celular' => $_POST['tutor_celular'],
            'tutor_email' => $_POST['tutor_email'],
            'emergencia_apaterno' => $_POST['emergencia_apaterno'],
            'emergencia_amaterno' => $_POST['emergencia_amaterno'],
            'emergencia_nombre' => $_POST['emergencia_nombre'],
            'parentesco' => $_POST['parentesco'],
            'emergencia_telefono' => $_POST['emergencia_telefono'],
        ];

        include "../../Config/conexion.php";

        $sql = "INSERT INTO alumno (horario, matricula, apaterno, amaterno, nombre, nacimiento, edad, curp, tel_fijo, tel_celular, email, calle, colonia, cp, municipio, tutor_apaterno, tutor_amaterno, tutor_nombre, tutor_tel_fijo, tutor_tel_celular, tutor_email, emergencia_apaterno, emergencia_amaterno, emergencia_nombre, emergencia_parentesco, emergencia_tel) 
VALUES ('" . $datos['horario'] . "', '" . $datos['matricula'] . "', '" . $datos['apaterno'] . "', '" . $datos['amaterno'] . "', '" . $datos['nombre'] . "', '" . $datos['nacimiento'] . "', '" . $datos['edad'] . "', '" . $datos['curp'] . "', '" . $datos['telfijo'] . "', '" . $datos['celular'] . "', '" . $datos['email'] . "', '" . $datos['calle'] . "', '" . $datos['colonia'] . "', '" . $datos['codpostal'] . "', '" . $datos['municipio'] . "', '" . $datos['tutor_apaterno'] . "', '" . $datos['tutor_amaterno'] . "', '" . $datos['tutor_nombre'] . "', '" . $datos['tutor_telfijo'] . "', '" . $datos['tutor_celular'] . "', '" . $datos['tutor_email'] . "', '" . $datos['emergencia_apaterno'] . "', '" . $datos['emergencia_amaterno'] . "', '" . $datos['emergencia_nombre'] . "', '" . $datos['parentesco'] . "', '" . $datos['emergencia_telefono'] . "')";

        if ($connection->query($sql) === TRUE) {
            $_SESSION['datos'] = $datos;

            header("Location: solicitudLlenado.php");
            echo "<script>
        window.onload = function() {
            document.getElementById('overlay').style.display = 'flex';
        }
        </script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }

        $connection->close();
    }
}
?>

</html>