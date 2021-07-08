<?php
if(!isset($_SESSION)){
    session_start();
}

require_once("./conexion.php");
include("./valida.php");

$sql_status = sprintf("UPDATE usuarios SET usu_status = 0 where usu_mail = %s",
                     valida::convertir($mysqli, $_SESSION["user"], "text"));
$q_status = mysqli_query($mysqli, $sql_status) or die (mysqli_error($mysqli));

if(isset($_SESSION)){
    session_destroy();
}
echo "<script>window.location = '../'</script>";