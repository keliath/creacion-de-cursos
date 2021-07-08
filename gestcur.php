<?php
if(!isset($_SESSION)){
    session_start();
}
if(isset($_GET["gest"])){
    include("./funciones/gestionarcur.php");
}
include_once("./includes/login.php");
require_once("./clases/securitypr.php");


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
            <?php
            if(!isset($_GET["gest"])){
                include("./funciones/vercreados.php");
            }else{
                include("./includes/gestionar.php");
            }
            
            ?>
        </main>

        <?php
        include_once("./includes/loginmodal.php");
        require_once("./includes/sweetalertas.php");
        ?>


    </body>
</html>
