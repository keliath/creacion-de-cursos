<?php
if(!isset($_SESSION)){
    session_start();
}

include("./includes/login.php");
require_once("./clases/securitypr.php");

$lvl = $_SESSION["nivel"];
$user = $_SESSION["user"];
if($_SESSION["nivel"] != "profesor"){
    $sql_update = sprintf("UPDATE usuarios SET usu_nivel = 'profesor' where usu_mail = %s",
                          valida::convertir($mysqli, $user, "text"));
    $q_update = mysqli_query($mysqli, $sql_update) or die(mysqli_error($mysqli));

    $sql_upgrade = sprintf("select usu_nivel from usuarios where usu_mail = %s",
                           valida::convertir($mysqli, $user, "text"));
    $q_upgrade = mysqli_query($mysqli, $sql_upgrade) or die(mysqli_error($mysqli));
    $r_upgrade = mysqli_fetch_assoc($q_upgrade);
    
    $sql_profe = sprintf("insert into profesor (usu_mail) values (%s)",
                           valida::convertir($mysqli, $user, "text"));
    $q_profe = mysqli_query($mysqli, $sql_profe) or die(mysqli_error($mysqli));
    
    $_SESSION["nivel"] = $r_upgrade["usu_nivel"];
}else{
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
           <div class="container">
               <div class="row">
                   <div class="col-md-12">
                       <h3>Ultimos cursos creados</h3>
                       <hr>
                   </div>
               </div>
           </div>
            <?php
            include("./funciones/vercreados.php");
            ?>
        </main>
        <?php
        include_once("./includes/loginmodal.php");
        require_once("./includes/sweetalertas.php");
        ?>


    </body>
</html>