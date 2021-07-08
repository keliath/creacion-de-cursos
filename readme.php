<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wao</title>
    <?php
        include_once("./includes/head.php");
    ?>
</head>
<body>
    <script>
        alerta("Ey!","Esta pagina fue hecha por Carlos Altamirano xd", "warning");
        function redirect(){
            window.location = "./";
        }
        setTimeout("redirect()", 3000);
    </script>
</body>
</html>