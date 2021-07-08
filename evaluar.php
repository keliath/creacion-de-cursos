<?php
if(!isset($_SESSION)){
    session_start();
}

include_once("./includes/login.php");

$curCodigo = $_GET["cod"];
$idProfe = $_GET["idp"];
$curName = $_GET["nomc"];
$idEva = $_GET["eva"];
$nPregun = '';
$acc = 1;
$user = $_SESSION["user"];

$sql_eval = "SELECT eva_pregun FROM evaluacion where id_evalua = '$idEva' order by id_evalua DESC LIMIT 1";
$q_eval = mysqli_query($mysqli, $sql_eval);
$r_eval = mysqli_fetch_assoc($q_eval);
$nPregun = $r_eval["eva_pregun"];

$sql_pregunta = "select * from pregunta where id_evalua = '$idEva'";
$q_pregunta = mysqli_query($mysqli, $sql_pregunta);
$r_pregunta = mysqli_fetch_assoc($q_pregunta);

if(isset($_GET["id"])){
    $idEvalua = $_GET["id"];
    $nPregun = $_GET["n"];
}
$fin = $nPregun -1;


if(isset($_POST["guardar"])){


    for($i = 1; $i <= $nPregun; $i++){
        for($x = 1; $x <= 4; $x++){
            if($_POST["correcta$i"] == "op".$x){
                $sql_opciones = sprintf("insert into opescogida (id_pregun,usu_mail, ope_opcion) values (%s, %s, %s)",
                                        valida::convertir($mysqli, $idPregun, "int"),
                                        valida::convertir($mysqli, $_POST["op".$x], "text"));
                $q_opciones = mysqli_query($mysqli, $sql_opciones);
                echo "<script>alert('vale')</script>";
            }
        }
    }

    /*
    if($fin == $preActual){
        header("location:./profesor.php?pok");
    }else{
        header("location:./newpre.php?apo=$idCurso&idp=$idProfe&nomc=$curName&id=$idEvalua&n=$nPregun");
    }*/
}

if(isset($_POST["fin"])){
    
    $sql_preactual = "select id_pregun from pregunta where id_evalua = '$idEva'";
    $q_preactual = mysqli_query($mysqli, $sql_preactual);
    $r_preactual = mysqli_fetch_assoc($q_preactual);
    $i = 1;
    do{
        $idPregun = $r_preactual["id_pregun"];
        for($x = 1; $x <= 4; $x++){
            
            if($_POST["correcta$i"] == "op".$x){
                $con = "op" . $x . $i;
                $escogida = $_POST["$con"];
                $sql_opciones = sprintf("insert into opescogida (id_pregun, usu_mail, ope_opcion) values (%s, %s, %s)",
                                        valida::convertir($mysqli, $idPregun, "int"),
                                        valida::convertir($mysqli, $user, "text"),
                                       valida::convertir($mysqli, $escogida, "text"));
                $q_opciones = mysqli_query($mysqli, $sql_opciones);
            }
        }
        
        //$sql_nota = "select * from respuesta a inner join pregunta b on a.id_pregun = b.id_pregun inner join opescogida  c on b.id_pregun = c.id_pregun where b.id_evalua = "  //con where pregunta serviria aqui caso contrario fuera del while haciendo otro while
        
        $i++;
    }while($r_preactual = mysqli_fetch_assoc($q_preactual));
    
    $sql_nota = "select b.id_pregun, id_evalua,usu_mail, pre_pregun, res_respuesta, ifnull(ope_opcion, ' ') ope_opcion  from respuesta a inner join pregunta b on a.id_pregun = b.id_pregun left join opescogida c on b.id_pregun = c.id_pregun where b.id_evalua = '$idEva'";
    $q_nota = mysqli_query($mysqli, $sql_nota);
    $r_nota = mysqli_fetch_assoc($q_nota);
    
    $nota = 0;
    do{
        $respuesta = $r_nota["res_respuesta"];
        $respesco = $r_nota["ope_opcion"];
        
            
        if($respuesta == $respesco){
            $nota++;
        }
    }while($r_nota = mysqli_fetch_assoc($q_nota));
    
    $nota = ($nota * 10 / $nPregun);
    $nota = round($nota, 1);
    $date = date("Y-m-d H:i:s");
    $sql_repo = sprintf(
        "Insert into nota (id_evalua, usu_mail, eva_fecha, not_nota) values (%s,%s,%s,%s)",
        valida::convertir($mysqli, $idEva, "int"),
        valida::convertir($mysqli, $user, "text"),
        valida::convertir($mysqli, $date, "date"),
        valida::convertir($mysqli, $nota, "text")
    );
    $q_repo = mysqli_query($mysqli, $sql_repo) or die(mysqli_error($mysqli));
    
    header("location:./miscursos.php?cod=$curCodigo&idp=$idProfe&nomc=$curName&nota=$nota&n=$nPregun");
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>SAO</title>
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
            <div class='container' style='margin-top:30px;background-color: rgb(255, 255, 255, 0.9)'>
                <div class='row'>
                    <div class='col-sm-12'>
                        <ul class='nav nav-pills' id='formtab'>
                            <?php
                            $acc = 1;
                            for($x = 1; $x <= $nPregun; $x++){
                                echo "<li class='nav-item'>
                                <a class='nav-link' data-toggle='pill' href='#p$acc'>Pregunta $acc</a>
                                </li>";
                                $acc ++;
                            }
                            ?>

                        </ul>

                        <form action='' method='post'>
                            <div class='tab-content'>
                                <?php
                                $acc2 = 1;
                                $array = array();
                                $pregun = array();
                                do{
                                    $pregunta = $r_pregunta['pre_pregun'];
                                    $idPregun = $r_pregunta['id_pregun'];

                                    $sql_op = "select opc_opcion from opciones where id_pregun = '$idPregun'";
                                    $q_op = mysqli_query($mysqli, $sql_op) or die(mysqli_error($mysqli));

                                    $sql_res = "select res_respuesta from respuesta where id_pregun = '$idPregun'";
                                    $q_res = mysqli_query($mysqli, $sql_res);
                                    $r_res = mysqli_fetch_assoc($q_res);

                                    while($r_op = mysqli_fetch_assoc($q_op)) {
                                        $array[] = $r_op["opc_opcion"];
                                    }
                                    $array[] = $r_res["res_respuesta"];
                                    shuffle($array);
                                    echo"
                                <div class='tab-pane' id='p$acc2'>
                                    <div class='form-group'>
                                        <label for='pregunta'>Pregunta: $acc2</label>
                                        <textarea class='form-control' name='pregunta' id='pregunta' cols='30' rows='5' required readonly >$pregunta</textarea>
                                    </div>
                                    <div class='input-group mb-3'>
                                        <div class='input-group-prepend'>
                                            <div class='input-group-text'>
                                                <input type='radio' name='correcta$acc2' value='op1'> 
                                            </div>
                                        </div>
                                        <input type='text' name='op1$acc2' class='form-control' placeholder='Opcion 1' autocomplete='off' required readonly value='$array[0]'>
                                    </div>
                                    <div class='input-group mb-3'>
                                        <div class='input-group-prepend'>
                                            <div class='input-group-text'>
                                                <input type='radio' name='correcta$acc2' value='op2'> 
                                            </div>
                                        </div>
                                        <input type='text' name='op2$acc2' class='form-control' placeholder='Opcion 1' autocomplete='off' required readonly value='$array[1]'>
                                    </div>
                                    <div class='input-group mb-3'>
                                        <div class='input-group-prepend'>
                                            <div class='input-group-text'>
                                                <input type='radio' name='correcta$acc2' value='op3'> 
                                            </div>
                                        </div>
                                        <input type='text' name='op3$acc2' class='form-control' placeholder='Opcion 1' autocomplete='off' required readonly value='$array[2]'>
                                    </div>
                                    <div class='input-group mb-3'>
                                        <div class='input-group-prepend'>
                                            <div class='input-group-text'>
                                                <input type='radio' name='correcta$acc2' value='op4' required> 
                                            </div>
                                        </div>
                                        <input type='text' name='op4$acc2' class='form-control' placeholder='Opcion 1' autocomplete='off' required readonly value='$array[3]'>
                                    </div>";
                                    if($acc2 == $nPregun){
                                        echo "<button type='submit' name ='fin' class='btn btn-success'>Finalizar</button>";
                                    }
                                    echo "</div>
                                    ";
                                    $acc2++;
                                    $array = array();
                                }while($r_pregunta = mysqli_fetch_assoc($q_pregunta));
                                ?>

                                <div class='tab-pane' id='p'>

                                </div>    
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php
        include_once("./includes/loginmodal.php");
        require_once("./includes/sweetalertas.php");
        include("./includes/foot.php"); 
        ?>

        <script>
            $('#formtab a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            })
        </script>
    </body>
</html>










