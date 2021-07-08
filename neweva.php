<?php
if(!isset($_SESSION)){
    session_start();
}

include_once("./includes/login.php");
require_once("./clases/securitypr.php");

$idCurso = $_GET["apo"];
$idProfe = $_GET["idp"];
$curName = $_GET["nomc"];

if(isset($_POST["crear"])){
    $date = date("Y-m-d H:i:s");
    
    $sql_newe = sprintf("INSERT INTO evaluacion (cur_codigo, eva_nombre, eva_pregun, eva_fecha) values (%s, %s, %s, %s)",
                       valida::convertir($mysqli, $idCurso, "text"),
                       valida::convertir($mysqli, $_POST["name"], "text"),
                       valida::convertir($mysqli, $_POST["np"], "int"),
                       valida::convertir($mysqli, $date, "date"));
    $q_newe = mysqli_query($mysqli, $sql_newe);
    
    header("location:./newpre.php?apo=$idCurso&idp=$idProfe&nomc=$curName");
}
?>
<!DOCTYPE html>
<html lang="en">
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
           <div class='container' style='margin-top:30px'>
                <div class='row'>
                    <div class='col-sm-12'>
                        <form action='' method='post' enctype='multipart/form-data'>
                            <div class='form-group'>
                                <h5>Menú de creación de Evaluaciones</h5>
                                <hr class='d-sm-none'>
                            </div>
                            <div class='form-group'>
                                <label for='name'>Nombre de la evaluacion:</label>
                                <input type='text' class='form-control' id='name' name='name' autocomplete='off' required>
                            </div>
                            <div class='form-group'>
                                <label for='np'>Número de preguntas:</label>
                                <input type='number' name='np' class='form-control' min='3' max='20' required autocomplete="off">
                            </div>

                            <button type='submit' class='btn btn-primary' name='crear'>Crear</button>
                        </form>
                    </div>
                </div>
            </div>

        </main>

        <?php
        include_once("./includes/loginmodal.php");
        require_once("./includes/sweetalertas.php");
        ?>


    </body>
</html>