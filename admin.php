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
        include("./includes/menuad.php");
        ?>

        <main>
            <?php
            require_once("./includes/sweetalertas.php");
            ?>
        </main>

        <?php
        include_once("./includes/sweetalertas.php");
        ?>
    </body>
</html>