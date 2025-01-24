<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscribir</title> <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f7f9fb;
        }

        .custom-container {
            background-color: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 10%;
            position: relative;
        }

        .print-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: red;
            color: white;
        }

        .btn-aceptar {
            background-color: #BBCD5D;
            border: #BBCD5D;
            color: #fff;
        }

        .btn-aceptar:hover {
            background-color: #aabb57;
            border-color: #aabb57;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: popup-animation 0.3s ease-in-out;
        }

        @keyframes popup-animation {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .checkmark {
            width: 50px;
            height: 50px;
            margin: 0 auto 20px;
            display: block;
            stroke-width: 2;
            stroke: #BBCD5D;
            stroke-miterlimit: 10;
            fill: none;
            animation: checkmark-fill 0.4s ease-in-out 0.4s forwards, checkmark-scale 0.3s ease-in-out 0.9s both;
        }

        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke: #BBCD5D;
            fill: none;
            animation: checkmark-stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark-check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            stroke: #BBCD5D;
            animation: checkmark-check-animation 0.4s cubic-bezier(0.65, 0, 0.45, 1) 1s forwards;
        }

        @keyframes checkmark-stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes checkmark-check-animation {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes checkmark-scale {

            0%,
            100% {
                transform: none;
            }

            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }

        @keyframes checkmark-fill {
            100% {
                box-shadow: none;
            }
        }

        .btn-primary {
            padding: 10px 20px;
            background-color: #BBCD5D;
            border-color: #BBCD5D;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #aabb57;
            border-color: #aabb57;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="custom-container p-4">
            <button class="btn print-button" onclick="openPDF()"><i class="fas fa-file-pdf"></i> Imprimir</button>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
                <div class="form-group">
                    <label>Carrera/Especialidad/Cursos:</label> <br>
                    <label>Mecánica en Reparación de Motocicletas</label>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="horario">Horario:</label>
                        <select class="form-control" name="horario" id="horario" required>
                            <option value="0">Selecciona una opción</option>
                            <option value="1" >Semanal</option>
                            <option value="2" >Sabatino</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="matricula">Matrícula:</label>
                        <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matrícula" required readonly>
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
                        <input type="text" class="form-control" id="amaterno" name="amaterno" placeholder="Apellido Materno" pattern="[A-Za-z\s]+" title="Solo caracteres alfabéticos" maxlength="150" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre(s)" pattern="[A-Za-z\s]+" title="Solo caracteres alfabéticos" maxlength="150" required>
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
                    <div class="form-group col-md-6 mt-3 d-flex justify-content-start">
                        <button type="submit" class="btn btn-success btn-aceptar mr-2" name="submit">Guardar</button>
                        <button class="btn print-button" type="button" onclick="document.forms[0].submit();"><i class="fas fa-file-pdf"></i> Imprimir</button>
                    </div>

                </div>
            </form>
            <!-- Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<?php
include '../../Config/conexion.php';

$sql = "SELECT MAX(matricula) FROM alumno";
$result = $connection->query($sql);
$matricula = $result->fetch_row()[0];
$matriculaDB = $matricula + 1;

?>



<script>
    function openPDF() {
        var pdfUrl = '../Modules/Inscribir/solicitud.php';
        window.open(pdfUrl, '_blank');
    }



    function calcularEdad() {
        const nacimientoInput = document.getElementById('nacimiento').value;
        const nacimiento = new Date(nacimientoInput);
        const actual = new Date();
        let edad = actual.getFullYear() - nacimiento.getFullYear();

        document.getElementById('edad').value = edad;
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
            
            matriculaDB = (matriculaDB < 10) ? '00' + matriculaDB: (matriculaDB < 100 && matriculaDB > 10 ) ? '0' + matriculaDB : matriculaDB;
            var hH = document.getElementById('horario').value;
            var mM = document.getElementById('matricula');
            mM.value = hH !== "0" ? mes + año + hH + matriculaDB: "";
        }

        document.getElementById('horario').addEventListener('change', matricula);
    });
</script>


<!--Ventanas emergentes -->
<div class="overlay" id="overlay" style="display: none;">
    <div class="popup">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark-check" fill="none" stroke="#BBCD5D" stroke-width="5"
                d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <p>¡Operación exitosa!</p>
        <button class="btn-primary" onclick="closePopup()">Aceptar</button>
        <a href="../../Templates/alumnos.html" class="btn-primary">Mostrar</a>
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