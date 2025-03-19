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
                <input type="number" placeholder="Código Postal" name="codpostal">
                <input type="submit">
        </form>
</body>
</html>
<?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
                        print_r(json_decode($coloniass));
                } else{
                        echo "Error: " . $error_connection;
                }
        }
?>