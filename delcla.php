<?php
require_once("./clases/conexion.php");

$id = $_GET['id'];
$curCodigo = $_GET["apo"];
$idProfe = $_GET["idp"];
$curName = $_GET["nomc"];

$sql_delcla = sprintf("Delete from clases where id_clases = $id;");
$q_delcla = mysqli_query($mysqli, $sql_delcla) or die(mysqli_error($mysqli));

header("location:./gestclases.php?apo=$curCodigo&idp=$idProfe&nomc=$curName");
