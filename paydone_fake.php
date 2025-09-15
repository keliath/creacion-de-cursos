<?php
if (!isset($_SESSION)) {
    @session_start();
}

require_once("./clases/security.php");
require_once("./clases/valida.php");
require_once("./clases/conexion.php");

$user = $_SESSION["user"] ?? null;
if (!$user) {
    header("location:./?sec");
    exit;
}

$facco = "factura" . $user;
$facco = md5($facco);
$codi = $_GET["cod"] ?? ($_SESSION['cur'] ?? '');
$fecha = date("Y-m-d");

if (isset($_GET["faco"]) && $_GET["faco"] === $facco && $codi !== '') {
    // Insert enrollment if not exists
    $sql_check = sprintf(
        "SELECT 1 FROM matricula WHERE cur_codigo=%s AND usu_mail=%s LIMIT 1",
        valida::convertir($mysqli, $codi, "text"),
        valida::convertir($mysqli, $_SESSION["user"], "text")
    );
    $exists = mysqli_query($mysqli, $sql_check);
    if ($exists && mysqli_num_rows($exists) === 0) {
        $sql_matricular = sprintf(
            "INSERT INTO matricula (cur_codigo, usu_mail, mat_fecha) VALUES (%s, %s, %s)",
            valida::convertir($mysqli, $codi, "text"),
            valida::convertir($mysqli, $_SESSION["user"], "text"),
            valida::convertir($mysqli, $fecha, "date")
        );
        mysqli_query($mysqli, $sql_matricular);
    }
    // Clear cart for cleanliness
    if (isset($_SESSION['cart'])) { unset($_SESSION['cart']); }
    header("location:./?comok");
    exit;
} else {
    header("location:./?sec");
    exit;
}
?>
