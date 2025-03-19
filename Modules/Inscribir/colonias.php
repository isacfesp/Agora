<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Prueba</title>
</head>
<body>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="">Ingrese código postal</label>
                <input type="number" placeholder="Código Postal" id="codpostal" name="codpostal" onchange="codigoP()">
                <div id="colonias">
                        
                </div>
           <!--     <input type="submit"> -->
        </form>

        <script>
                async function codigoP(){
                        const cpInput = document.getElementById('codpostal').value;
                        console.log("Codigo postal ingresado: " , cpInput);
                                if(cpInput.length === 5){
                                        const consulta = `https://api.copomex.com/query/get_colonia_por_cp/${cpInput}?token=5ca44c82-8279-4e9c-acb6-456663c20d13` ;
                                        const respuesta = await fetch(consulta);
                                        console.log("Respuesta de la API: " , respuesta);
                                        const datos = await respuesta.json();
                                        console.log("Datos obtenidos: " , datos);
                                        const opciones = datos.response.colonia.map(colonia => `<option value="${colonia}">${colonia}</option>`);
                                        const sselect = `<select>${opciones.join('')}</select>`;
                                        console.log("HTML generado: " , sselect);
                                        document.getElementById('colonias').innerHTML = sselect;
                                } else {
                                        document.getElementById('colonias').innerHTML = '';
                                }
                };
        </script>

<?php
     /*   if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $codigo = $_POST['codpostal'];
                $consulta = "https://api.copomex.com/query/get_colonia_por_cp/$codigo?token=5ca44c82-8279-4e9c-acb6-456663c20d13";
                $ch = curl_init($consulta);
                curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1);
                curl_setopt($ch , CURLOPT_TIMEOUT , 1);
                $coloniass = curl_exec($ch);
                $httpcode = curl_getinfo($ch , CURLINFO_HTTP_CODE);
                $error_connection = curl_error($ch);
                curl_close($ch);

                if($httpcode==200){
                        $opciones = json_decode($coloniass, true);
                        $opciones_html = '';
                        foreach($opciones['response']['colonia'] as $colonia){
                                $opciones_html .= '<option value="' . $colonia . '">' . $colonia . '</option>';
                        } 
                } else{
                        echo "Error: " . $error_connection;
                }
        } */
?>
        <!-- <select> <?php /* echo $opciones_html;*/ ?></select> -->
</body>
</html>