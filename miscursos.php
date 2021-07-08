<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("./includes/login.php");
require_once("./clases/security.php");

$curCodigo = $_GET["cod"];
$idProfe = $_GET["idp"];
$curName = $_GET["nomc"];
$user = $_SESSION["user"];
$espago = 0;

$sql_material = sprintf("select * from apoyo a inner join curso b on a.cur_codigo = b.cur_codigo where a.cur_codigo = '$curCodigo'");
$q_material = mysqli_query($mysqli, $sql_material) or die(mysqli_error($mysqli));

$t_material = mysqli_num_rows($q_material);
$r_material = mysqli_fetch_assoc($q_material);

$sql_evas = ("select * from evaluacion where cur_codigo = '$curCodigo' order by eva_fecha desc limit 1");
$q_evas = mysqli_query($mysqli, $sql_evas);
$r_evas = mysqli_fetch_assoc($q_evas);

$sql_espago = "select * from curso where cur_codigo = '$curCodigo'";
$q_espago = mysqli_query($mysqli, $sql_espago);
$r_espago = mysqli_fetch_assoc($q_espago);

$sql_listaClases = ("select * from clases where cur_codigo = '$curCodigo'");
$q_listaClases = mysqli_query($mysqli, $sql_listaClases);
$r_listaClases = mysqli_fetch_assoc($q_listaClases);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FPPTU</title>
    <?php
    include_once("./includes/head.php");
    ?>
</head>

<body class="body">
    <?php
    include("./includes/header.php");
    include("./includes/menu.php");
    ?>

    <main>
        <?php
        if (!isset($_GET["cod"])) {
        } else {
            echo "
                <div class='container mb-5' style='background-color: rgb(255, 255, 255, 0.8)';>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <h3>Curso: $curName</h3>
                            <hr>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <h4>Clases: </h4>";

            if (mysqli_num_rows($q_listaClases) > 0) {
                do {
                    $className = $r_listaClases['cla_nombre'];
                    $carpetaClase = $r_listaClases["id_clases"];
                    $dirVideo = $r_listaClases['cla_recurso'] .".". $r_listaClases['cla_ext'];

                    //$redir = "./verclases.php?apo=$curCodigo&idp=$idProfe&nomc=$curName&clanom=$className&clavid=$r_listaClases[cla_recurso]&claext=$r_listaClases[cla_ext]";
                    $redir = "./cursos/$idProfe/$curCodigo/$carpetaClase/$dirVideo";
        ?>

                    <div class="card bg-light text-dark">
                        <a href="<?php echo $redir?>" target="_blank" class="text-dark ">
                            <div class="card-body"><?php echo $className ?></div>
                        </a>
                    </div>

                <?php
                } while ($r_listaClases = mysqli_fetch_assoc($q_listaClases));
            } else {
                echo "No hay clases disponibles";
            }

            echo "<br><div class='row'>
                        <div class='col-sm-12'>
                            <h4>Recursos: </h4>
                            ";

            if (mysqli_num_rows($q_material) > 0) {
                ?>
                <table class="tabla">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        do {
                            $nom = $r_material['apo_docume'];
                            $id = $r_material['id_apoyo'];
                            $ext = $r_material['apo_ext'];
                            $doc = $nom . "." . $ext;

                            echo
                            "<tr>
                                <td>$nom</td>
                                <td>
                                    <a  href='./cursos/$idProfe/$curCodigo/aapoyo/$doc'  target='_blank' style='margin-right:15px'>
                                        Ver
                                    </a>
                                </td>

                            </tr>";
                        } while ($r_material = mysqli_fetch_assoc($q_material));
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo "No hay documentos disponibles";
            }
            echo "
            <hr>
            </div>
        </div>
    <div class='row'>
        <div class='col-sm-12'>
            <h4>Evaluaciones: </h4>";
            if (mysqli_num_rows($q_evas) > 0) {
            ?>
                <table class="tabla">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        do {
                            $nom = $r_evas['eva_nombre'];
                            $id = $r_evas['id_evalua'];

                            $sql_reeva = "select * from nota where usu_mail='$user' and id_evalua=$id";
                            $q_reeva = mysqli_query($mysqli, $sql_reeva);
                            $r_reeva = mysqli_fetch_assoc($q_reeva);
                            $t_reeva = mysqli_num_rows($q_reeva);
                            $yaEvaluado = '';
                            $evaluar = "Evaluar";

                            if ($t_reeva) {
                                $yaEvaluado = $r_reeva['not_nota'];
                                $evaluar = "Ya Evaluado";
                            }

                            echo
                            "<tr>
                                    <td>$nom</td>
                                    <td>
                                        <a href='evaluar.php?cod=$curCodigo&idp=$idProfe&nomc=$curName&eva=$id' style='margin-right:15px'>
                                            ".$evaluar."
                                        </a>
                                    </td>
                                    <td>
                                        $yaEvaluado
                                    </td>
                                </tr>";
                        } while ($r_evas = mysqli_fetch_assoc($q_evas));
                        ?>
                    </tbody>
                </table>
        <?php
            } else {
                echo "No hay evaluaciones disponibles";
            }
            echo "
            </div>
        </div>
    </div>
";
        }
        ?>
    </main>
    <?php
    include_once("./includes/loginmodal.php");
    require_once("./includes/sweetalertas.php");
    include("./includes/foot.php");
    ?>


</body>

</html>