<?php
require_once("./clases/conexion.php");

$id = $_GET['id'];
$curCodigo = $_GET["apo"];
$idProfe = $_GET["idp"];
$curName = $_GET["nomc"];
$sql_idPre = "select id_pregun from pregunta where id_evalua = $id";
$q_idPre = mysqli_query($mysqli, $sql_idPre);
$r_idPre = mysqli_fetch_assoc($q_idPre);
$t_idPre = mysqli_num_rows($q_idPre);

if ($t_idPre > 0) {
    do {
        $idPre = $r_idPre["id_pregun"];
        $sql_delop1 = sprintf("Delete from opciones where id_pregun = $idPre");
        $q_delop1 = mysqli_query($mysqli, $sql_delop1) or die("Error 1: " . mysqli_error($mysqli));
        $sql_delop2 = sprintf("delete from respuesta where id_pregun = $idPre");
        $q_delop2 = mysqli_query($mysqli, $sql_delop2) or die("Error 2: " . mysqli_error($mysqli));
        $sql_delop3 = sprintf("delete from opescogida where id_pregun = $idPre");
        $q_delop3 = mysqli_query($mysqli, $sql_delop3) or die("Error 3: " . mysqli_error($mysqli));
    } while ($r_idPre = mysqli_fetch_assoc($q_idPre));
}


$sql_deleva = sprintf("Delete from evaluacion where id_evalua = $id;");
$q_deleva = mysqli_query($mysqli, $sql_deleva) or die(mysqli_error($mysqli));
$sql_deleva = sprintf("Delete from pregunta where id_evalua = $id;");
$q_deleva = mysqli_query($mysqli, $sql_deleva) or die(mysqli_error($mysqli));

header("location:./verevas.php?apo=$curCodigo&idp=$idProfe&nomc=$curName");
