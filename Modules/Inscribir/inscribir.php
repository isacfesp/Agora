<?php
$apaterno = isset($_GET['apaterno']) ? $_GET['apaterno'] : '';
$amaterno = isset($_GET['amaterno']) ? $_GET['amaterno'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$celular = isset($_GET['celular']) ? $_GET['celular'] : '';

include '../../Config/conexion.php';

// Obtener los periodos disponibles
$sqlPeriodos = "SELECT id_periodo, fecha FROM periodo";
$resultPeriodos = $connection->query($sqlPeriodos);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="custom-container p-4">
            <button class="btn btn-success btn-aceptar mb-2" onclick="openCamera()">
                <i class="fas fa-camera"></i>
            </button>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
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
                        <select id="curso" name="curso" class="form-control" required>
                            <option value="">Selecciona una opción</option>
                            <?php
                            if ($resultPeriodos->num_rows > 0) {
                                while ($row = $resultPeriodos->fetch_assoc()) {
                                    echo "<option value='" . $row['id_periodo'] . "'>" . $row['fecha'] . "</option>";
                                }
                            }
                            ?>
                        </select>
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
                    <label for="municipio">Municipio:</label>
                    <input type="text" class="form-control" id="muni" name="municipio" placeholder="Municipio" maxlength="150" >
                </div>
                <div class="form-group">
                    <label for="codpostal">C.P:</label>
                    <input type="number" class="form-control" id="codpostal" name="codpostal" placeholder="Código Postal" title="Debe contener 5 dígitos" pattern="\d{5}" maxlength="5" onchange="codigoPos()" required>
                    
                </div>
                <div class="form-group">
                    <label for="colonia">Colonia:</label>
                    <select class="form-control" name="colonia" id="colonia" required>
                        <option value="">Colonia</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Escriba su colonia" id="otra" name="otra" style="display: none;">
                </div>
                <script>
                    document.getElementById('colonia').addEventListener('change', function() {
                        if (this.value === 'Otro') {
                            document.getElementById('otra').style.display = "block";
                        } else {
                            document.getElementById('otra').style.display = "none";
                        }
                    });

                    function codigoPos() {
                        const codigo = document.getElementById('codpostal').value;
                        if (codigo != null) {
                                console.log("Sí se recibe un cp");
                                var client = new XMLHttpRequest();
                                client.open("GET", `http://api.zippopotam.us/mx/${codigo}`, true);
                                client.onreadystatechange = function() {
                                        if (client.readyState == 4) {
                                                const respuesta = JSON.parse(client.responseText);
                                                const colonias = respuesta.places.map(colonia => colonia['place name']);
                                                const coloniasss = document.getElementById('colonia');
                                                coloniasss.innerHTML = '';
                                                colonias.forEach(colonia => {
                                                        const option = document.createElement('option');
                                                        
                                                        option.value = colonia;
                                                        option.text = colonia;
                                                       
                                                        coloniasss.appendChild(option);
                                                        
                                                });  
                                                const option2 = document.createElement('option');    
                                                option2.value = 'Otro';
                                                option2.text = 'Otro'; 
                                                coloniasss.appendChild(option2);
                                                
                                                if(coloniasss.value == 'Otro'){
                                                    console.log("El valor sí se obtiene")
                                                    document.getElementById('otra').style.display = "flex";
                                                }
                                        }
                                };
                                client.send();
                        } else {
                                console.log("No se encuentra un código postal");
                        }
                    }
                    
                </script> 
                <div class="form-group">
                    <label for="calle">Calle y No.:</label>
                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" maxlength="150" required>
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
                <!-- Campo oculto para la imagen capturada -->
                <input type="file" id="imageFile" name="imageFile" style="display: none;">
                <div class="form-group col-md-6 mt-3 d-flex justify-content-start">
                    <button type="submit" class="btn btn-success btn-aceptar mr-2" name="submit">Guardar</button>
                </div>
            </form>
            <h5><strong>VALIDACIÓN DE DOCUMENTOS:</strong></h5>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="doc1" name="doc1" value="1">
                    <label class="form-check-label" for="documento1">Acta de Nacimiento</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="doc2" name="doc2" value="1">
                    <label class="form-check-label" for="documento2">CURP</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="doc3" name="doc3" value="1">
                    <label class="form-check-label" for="documento3">Comprobante de domicilio</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="doc4" name="doc4" value="1">
                    <label class="form-check-label" for="documento4">Documento 4</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="doc5" name="doc5">
                    <label class="form-check-label" for="documento5">Documento 5</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="doc6" name="doc6">
                    <label class="form-check-label" for="documento6">Documento 6</label>
                </div>
            </div>
            <!-- Modal para la cámara -->
            <div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cameraModalLabel">Capturar Imagen</h5>
                            <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <video id="cameraStream" autoplay playsinline style="width: 100%; border-radius: 5px;"></video>
                            <canvas id="cameraCanvas" style="display: none;"></canvas>
                            <div id="imageEditor" style="display: none;">
                                <img id="capturedImage" style="max-width: 100%; display: block; margin: auto;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                            <button type="button" class="btn btn-success btn-aceptar mr-2" id="captureButton" onclick="captureImage()">
                                <i class="fas fa-camera"></i> Capturar
                            </button>
                            <button type="button" class="btn btn-primary btn-aceptar mr-2" id="saveButton" style="display: none;" onclick="saveEditedImage()">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
</body>


<script>
    const horarioU = document.getElementById('horario');

    let videoStream;
    let cropper;

    function openCamera() {
        const video = document.getElementById('cameraStream');
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                videoStream = stream;
                video.srcObject = stream;
                $('#cameraModal').modal('show');
            })
            .catch((error) => {
                console.error('Error al acceder a la cámara:', error);
                alert('No se pudo acceder a la cámara.');
            });
    }

    function captureImage() {
        const video = document.getElementById('cameraStream');
        const canvas = document.getElementById('cameraCanvas');
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL('image/png');
        const capturedImage = document.getElementById('capturedImage');
        capturedImage.src = imageData;

        document.getElementById('cameraStream').style.display = 'none';
        document.getElementById('cameraCanvas').style.display = 'none';
        document.getElementById('imageEditor').style.display = 'block';


        cropper = new Cropper(capturedImage, {
            aspectRatio: 3 / 4, 
            viewMode: 1,
            dragMode: 'move',
            zoomable: true, 
            scalable: false,
            cropBoxResizable: false, 
            cropBoxMovable: false,
            background: false,
        });


        document.getElementById('captureButton').style.display = 'none';
        document.getElementById('saveButton').style.display = 'inline-block';
    }

    function saveEditedImage() {

        const croppedCanvas = cropper.getCroppedCanvas({
            width: 300, 
            height: 400, 
        });

        croppedCanvas.toBlob(function (blob) {
            const file = new File([blob], "capturedImage.png", { type: "image/png" });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('imageFile').files = dataTransfer.files;

            console.log('Imagen lista para enviar:', file);
        });

  
        closeCamera();
    }

    function closeCamera() {
        if (videoStream) {
            const tracks = videoStream.getTracks();
            tracks.forEach((track) => track.stop());
        }
        $('#cameraModal').modal('hide');


        if (cropper) {
            cropper.destroy();
            cropper = null;
        }


        document.getElementById('cameraStream').style.display = 'block';
        document.getElementById('cameraCanvas').style.display = 'none';
        document.getElementById('imageEditor').style.display = 'none';
        document.getElementById('captureButton').style.display = 'inline-block';
        document.getElementById('saveButton').style.display = 'none';
    }


    $('#cameraModal').on('hidden.bs.modal', closeCamera);

    function openPDF() {
        var pdfUrl = 'solicitud.php';
        window.open(pdfUrl, '_blank');
    }

    function calcularEdad() {
        const nacimientoInput = document.getElementById('nacimiento').value;
        const nacimiento = new Date(nacimientoInput);
        const actual = new Date();
        if(actual.getMonth() > nacimiento.getMonth()){
            let edad = actual.getFullYear() - nacimiento.getFullYear();
            document.getElementById('edad').value = edad;
        }
        else if (actual.getMonth() == nacimiento.getMonth()) {
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
        $curso_id = $_POST['curso'];
        $horario = $_POST['horario'];

        $sqlPeriodo = "SELECT fecha FROM periodo WHERE id_periodo = '$curso_id'";
        $resultPeriodo = $connection->query($sqlPeriodo);
        $fecha = '';
        if ($rowPeriodo = $resultPeriodo->fetch_assoc()) {
            $fecha = $rowPeriodo['fecha']; 
        }


        $mes = date('m', strtotime($fecha)); 
        $anio = date('y', strtotime($fecha)); 
        $periodoMatricula = $mes . $anio; 


        $sqlMaxId = "SELECT MAX(id_alumno) AS max_id FROM alumno";
        $resultMaxId = $connection->query($sqlMaxId);
        $lastId = 0;
        if ($rowMaxId = $resultMaxId->fetch_assoc()) {
            $lastId = $rowMaxId['max_id'];
        }
        $secuencial = str_pad($lastId + 1, 3, '0', STR_PAD_LEFT); 


        $matriculaU = $periodoMatricula . $horario . $secuencial;

        $acta = isset($_POST['doc1']) ? 1 : 0;
        $curp = isset($_POST['doc2']) ? 1 : 0;
        $domicilio = isset($_POST['doc3']) ? 1 : 0;
 
        $datos = [
            'horario' => $horario,
            'matricula' => $matriculaU,
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
            'colonia' => ($_POST['colonia'] === 'Otro' && !empty($_POST['otra'])) ? $_POST['otra'] : $_POST['colonia'],
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
            'estado' => 'inactivo',
        ];


        $sqlAlumno = "INSERT INTO alumno (horario, matricula, apaterno, amaterno, nombre, nacimiento, edad, curp, tel_fijo, tel_celular, email, calle, colonia, cp, municipio, tutor_apaterno, tutor_amaterno, tutor_nombre, tutor_tel_fijo, tutor_tel_celular, tutor_email, emergencia_apaterno, emergencia_amaterno, emergencia_nombre, emergencia_parentesco, emergencia_tel, estado) 
        VALUES ('" . $datos['horario'] . "', '" . $datos['matricula'] . "', '" . $datos['apaterno'] . "', '" . $datos['amaterno'] . "', '" . $datos['nombre'] . "', '" . $datos['nacimiento'] . "', '" . $datos['edad'] . "', '" . $datos['curp'] . "', '" . $datos['telfijo'] . "', '" . $datos['celular'] . "', '" . $datos['email'] . "', '" . $datos['calle'] . "', '" . $datos['colonia'] . "', '" . $datos['codpostal'] . "', '" . $datos['municipio'] . "', '" . $datos['tutor_apaterno'] . "', '" . $datos['tutor_amaterno'] . "', '" . $datos['tutor_nombre'] . "', '" . $datos['tutor_telfijo'] . "', '" . $datos['tutor_celular'] . "', '" . $datos['tutor_email'] . "', '" . $datos['emergencia_apaterno'] . "', '" . $datos['emergencia_amaterno'] . "', '" . $datos['emergencia_nombre'] . "', '" . $datos['parentesco'] . "', '" . $datos['emergencia_telefono'] . "', '" . $datos['estado'] . "')";

        if ($connection->query($sqlAlumno) === TRUE) {

            $idAlumno = $connection->insert_id;

            $sqlDocumentacion = "INSERT INTO documentacion (id_alumno, acta_nacimiento, curp, domicilio) VALUES ('$idAlumno', '$acta', '$curp', '$domicilio')";
            if ($connection->query($sqlDocumentacion) !== TRUE) {
                echo "Error al insertar en la tabla documentacion: " . $connection->error;
            }

            $sqlInscripcion = "INSERT INTO inscripcion (id_alumno, id_periodo) VALUES ('$idAlumno', '$curso_id')";
            if ($connection->query($sqlInscripcion) === TRUE) {

                if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] === UPLOAD_ERR_OK) {
                    $imageTmpPath = $_FILES['imageFile']['tmp_name'];
                    $imagePath = "../../BD/Photos/{$datos['matricula']}.png";

                    if (move_uploaded_file($imageTmpPath, $imagePath)) {
                        echo "Imagen guardada correctamente.";
                    } else {
                        echo "Error al guardar la imagen.";
                    }
                }

                echo "<script>
                window.onload = function() {
                    document.getElementById('overlay').style.display = 'flex';
                }
                </script>";
            } else {
                echo "Error al insertar en la tabla inscripcion: " . $connection->error;
            }
        } else {
            echo "Error al insertar en la tabla alumno: " . $connection->error;
        }

        $connection->close();
    }
}
?>

</html>