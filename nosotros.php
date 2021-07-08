<?php
if(!isset($_SESSION)){
    session_start();
}

include("./includes/login.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tienda</title>

        <?php
        include_once("./includes/head.php");
        ?>
    </head>
    <body>
        <?php
        include("./includes/header.php");
        include("./includes/menu.php");
        ?>
        <main>
            <div class="container" style="background-color: rgb(0, 0, 0, 0.4);">
                <div class="row">
                    <div class="col-12"><p>Somos una plataforma para la creacion de videocursos online</p></div>
                </div>

            </div>
            <?php
            include_once("./includes/loginmodal.php");
            require_once("./includes/sweetalertas.php");
            ?>
        </main>
        <?php include("./includes/foot.php"); ?>
    </body>
</html>