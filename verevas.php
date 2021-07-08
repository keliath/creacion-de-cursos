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

$sql_evas = ("select * from evaluacion where cur_codigo = '$curCodigo'");
$q_evas = mysqli_query($mysqli, $sql_evas);
$r_evas = mysqli_fetch_assoc($q_evas);


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
                            if (mysqli_num_rows($q_evas) > 0) {
                            ?>
                                <table class="tabla">
                                    <thead>
                                        <tr>
                                            <th>Evaluación</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        do {
                                            $nom = $r_evas['eva_nombre'];
                                            $id = $r_evas['id_evalua'];


                                            echo
                                            "<tr>
                                                        <td>$nom</td>
                                                        <td>";
                                        ?>

                                            <a href='#' onclick="alerta('info', 'en construccion', 'info')" style='margin-right:15px'>
                                                Ver
                                            </a>
                                            <a href='#' onclick="alerta('info', 'en construccion', 'info')" style='margin-right:15px'>
                                                Editar
                                            </a>
                                        <?php
                                            echo    "

                                                            <a href='reportepru.php?apo=$curCodigo&idp=$idProfe&nomc=$curName&id=$id' style='margin-right:15px'>
                                                                Reportes
                                                            </a>

                                                            <a href='delpru.php?apo=$curCodigo&idp=$idProfe&nomc=$curName&id=$id'>
                                                                Borrar
                                                            </a>
                                                        </td>
                                                    </tr>";
                                        } while ($r_evas = mysqli_fetch_assoc($q_evas));
                                        ?>
                                    </tbody>
                                </table>
                            <?php
                                echo "<a href='gestcur.php?gest=$curCodigo' class='btn btn-primary' style='text-decoration:none'>Volver</a>";
                            } else {
                                echo "No hay evaluaciones, de click <a href='./neweva.php?apo=<?php echo $curCodigo ?>&idp=<?php echo $idProfe ?>&nomc=<?php echo $curName ?>'>aquí</a> para crear una";
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