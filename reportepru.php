<?php
if (!isset($_SESSION)) {
    session_start();
}

include("./includes/login.php");
include("./funciones/funciones.php");
require_once("./clases/securitypr.php");

$curCodigo = $_GET['apo'];
$idProfe = $_GET['idp'];
$curName = $_GET["nomc"];
$idEva = $_GET["id"];

$sql_notas = ("select * from nota where id_evalua = $idEva");
$q_notas = mysqli_query($mysqli, $sql_notas) or die(mysqli_error($mysqli));
$r_notas = mysqli_fetch_assoc($q_notas);


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php
    include_once("./includes/head.php");
    ?>
</head>

<body class="main">
    <?php
    include("./includes/header.php");
    include("./includes/menupro.php");
    ?>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <form action="">
                        <div class="form-group">
                            <?php
                            if (mysqli_num_rows($q_notas) > 0) {
                            ?>
                                <table class="tabla">
                                    <thead>
                                        <tr>
                                            <th>usuario</th>
                                            <th>fecha</th>
                                            <th>Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        do {
                                            $nom = $r_notas['usu_mail'];
                                            $fecha = $r_notas['eva_fecha'];
                                            $nota = $r_notas['not_nota'];


                                            echo
                                            "<tr>
                                                        <td>$nom</td>
                                                        <td>$fecha</td>
                                                        <td>$nota</td>";
                                        } while ($r_notas = mysqli_fetch_assoc($q_notas));
                                        ?>
                                    </tbody>
                                </table>
                            <?php
                                echo "<a href='verevas.php?apo=$curCodigo&idp=$idProfe&nomc=$curName' class='btn btn-primary' style='text-decoration:none'>Volver</a>";
                            } else {
                                echo "No hay reportes disponibles";
                            }
                            ?>
                        </div>
                        <div class="form-group" id="display">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php
    require_once("./includes/sweetalertas.php");
    ?>
</body>

</html>