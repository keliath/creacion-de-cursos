<?php
require_once("./clases/conexion.php");

$id = $_GET['id'];
$curCodigo = $_GET["apo"];
$idProfe = $_GET["idp"];
$curName = $_GET["nomc"];
$doc = $_GET["doc"];

$sql_deldoc = "delete from apoyo where id_apoyo = $id";
$q_deldoc = mysqli_query($mysqli, $sql_deldoc);
unlink("./cursos/$idProfe/$curCodigo/aapoyo/$doc");

header("location:./vermateriales.php?apo=$curCodigo&idp=$idProfe&nomc=$curName");