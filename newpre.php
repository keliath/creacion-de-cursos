<?php
if(!isset($_SESSION)){
    session_start();
}

include_once("./includes/login.php");
require_once("./clases/securitypr.php");

$idCurso = $_GET["apo"];
$idProfe = $_GET["idp"];
$curName = $_GET["nomc"];
$idEvalua = '';
$nPregun = '';
if(!isset($_GET["id"])){
    $sql_adonde = "SELECT id_evalua, eva_pregun FROM evaluacion order by id_evalua DESC LIMIT 1";
    $q_adonde = mysqli_query($mysqli, $sql_adonde);
    $r_adonde = mysqli_fetch_assoc($q_adonde);
    $idEvalua = $r_adonde["id_evalua"];
    $nPregun = $r_adonde["eva_pregun"];
}

if(isset($_GET["id"])){
    $idEvalua = $_GET["id"];
    $nPregun = $_GET["n"];
}
$fin = $nPregun -1;

$sql_preactual = "SELECT count(id_evalua) n FROM pregunta where id_evalua = $idEvalua";
$q_preactual = mysqli_query($mysqli,$sql_preactual);
$r_preactual = mysqli_fetch_assoc($q_preactual);
$preActual = $r_preactual["n"];

if(isset($_POST["crear"])){

    $sql_pregunta = sprintf("insert into pregunta (id_evalua, pre_pregun, pre_tipo) values (%s, %s, %s)",
                            valida::convertir($mysqli, $idEvalua, "int"),
                            valida::convertir($mysqli, $_POST["pregunta"], "text"),
                            valida::convertir($mysqli, "multiple", "text"));
    $q_pregunta = mysqli_query($mysqli, $sql_pregunta);

    $sql_idpre = "SELECT id_pregun FROM pregunta order by id_pregun DESC LIMIT 1";
    $q_idpre = mysqli_query($mysqli, $sql_idpre);
    $r_idpre = mysqli_fetch_assoc($q_idpre);
    $idPregun = $r_idpre["id_pregun"];

    for($x = 1; $x <= 4; $x++){
        if($_POST["correcta"] != "op".$x){
            $sql_opciones = sprintf("insert into opciones (id_pregun, opc_opcion) values (%s, %s)",
                                    valida::convertir($mysqli, $idPregun, "int"),
                                    valida::convertir($mysqli, $_POST["op".$x], "text"));
            $q_opciones = mysqli_query($mysqli, $sql_opciones);
        }else{
            $sql_correcta = sprintf("insert into respuesta (id_pregun, res_respuesta) values (%s, %s)",
                                    valida::convertir($mysqli, $idPregun, "int"),
                                    valida::convertir($mysqli, $_POST["op".$x], "text"));
            $q_correcta = mysqli_query($mysqli, $sql_correcta);
        }
    }

    if($fin == $preActual){
        header("location:./profesor.php?pok");
    }else{
    header("location:./newpre.php?apo=$idCurso&idp=$idProfe&nomc=$curName&id=$idEvalua&n=$nPregun");
    }
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
                                <h5>Menú de creación de Evaluación curso: <?php echo $curName;?></h5>
                                <hr class='d-sm-none'>
                            </div>
                            <div class='form-group'>
                                <label for="npregunta">Número de pregunta:</label>
                                <select name="npregunta" id="" class="form-control" onchange="alert('dd')">
                                    <option value="">Seleccione un número de pregunta si desea editarla</option>
                                    <?php
                                    for($x = 1; $x <= $preActual; $x++){
                                        echo "<option value'$x'>$x</option>";
                                    }
                                    ?>
                                </select>
                                <hr class='d-sm-none'>
                            </div>
                            <div class='form-group'>
                                <label for='pregunta'>Pregunta:</label>
                                <textarea class="form-control" name="pregunta" id="pregunta" cols="30" rows="5" required></textarea>
                            </div>
                            <div class='form-group'>
                                <label for="tipo">Tipo de pregunta:</label>
                                <select name="tipo" id="" class="form-control">
                                    <option value="multiple">Opción múltiple</option>
                                    <option value="lineas" disabled>Unir con líneas (Proximamente)</option>
                                    <option value="complete" disabled>Completar (Proximamente)</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="radio" name='correcta' value="op1"> 
                                    </div>
                                </div>
                                <input type="text" name="op1" class="form-control" placeholder="Opcion 1" autocomplete="off" required>
                            </div>
                            <div class="input-group mb-3 ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="radio" name='correcta' value="op2"> 
                                    </div>
                                </div>
                                <input type="text" name="op2" class="form-control" placeholder="Opcion 2" autocomplete="off" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="radio" name='correcta' value="op3"> 
                                    </div>
                                </div>
                                <input type="text" name="op3" class="form-control" placeholder="Opcion 3" autocomplete="off" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="radio" name='correcta' required value="op4"> 
                                    </div>
                                </div>
                                <input type="text" name="op4" class="form-control" placeholder="Opcion 4" autocomplete="off" required>
                            </div>
                            <?php
                            if($fin == $preActual){
                                echo "
                                <div class='form-group de-flex'>
                                    <button type='submit' class='btn btn-primary ml-auto' name='crear'>Finalizar</button>
                                </div>";
                            }else{
                                echo "
                                <div class='form-group de-flex'>
                                    <button type='submit' class='btn btn-primary ml-auto' name='crear'>Crear</button>
                                </div>";
                            }
                            ?>

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