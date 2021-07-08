<?php
require_once("./clases/securityad.php");
require_once("./includes/login.php");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Administración</title>
        <?php
        include_once("./includes/head.php");
        ?>
    </head>
    <body class="main">
        <?php
        include("./includes/header.php");
        include("./includes/menuad.php");
        ?>

        <main>
            <?php
            include_once("./includes/loginmodal.php");
            require_once("./includes/sweetalertas.php");
            ?>
        </main>

        <?php include("./includes/foot.php"); ?>
    </body>
</html>