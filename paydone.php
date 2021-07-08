<?php
if(!isset($_SESSION)){
    @session_start();
}else{
    $user = $_SESSION["nivel"];
}

require_once("./clases/security.php");
require_once("./includes/login.php");

$user = $_SESSION["user"];
$facco = "factura" . $user;
$facco = md5($facco);
$codi = $_GET["cod"];
$fecha = date("Y-m-d");
if(isset($_GET["faco"]) and $_GET["faco"]  == $facco ){
    $sql_matricular = sprintf("insert into matricula (cur_codigo, usu_mail, mat_fecha) values (%s, %s, %s)",
                              valida::convertir($mysqli, $codi, "text"),
                              valida::convertir($mysqli, $_SESSION["user"], "text"),
                              valida::convertir($mysqli, $fecha, "date"));
    $q_matricular = mysqli_query($mysqli, $sql_matricular) or die (mysqli_error($mysqli));

    header("location:./?comok");
}else{
    header("location:./?sec"); 
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tienda</title>
        <?php
        include_once("./includes/headconf.php");
        ?>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Pago realizado exitosamente</h1>
                    <a href="./index.php" class="btn btn-default">Regresar</a>
                </div>

            </div>
        </div>

    </body>
</html>