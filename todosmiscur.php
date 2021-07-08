<?php
if(!isset($_SESSION)){
    session_start();
}

include_once("./includes/login.php");

$user = $_SESSION["user"];
$sql_miscursos = sprintf("select * from curso a inner join matricula b on a.cur_codigo = b.cur_codigo where b.usu_mail = '$user'");
$q_miscursos = mysqli_query($mysqli, $sql_miscursos);

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
            <?php
            //script para mostrar los productos
            //$user = $_SESSION["user"];

            $sql_mostrar = sprintf("SELECT a.cur_codigo, cur_nombre, b.id_profes, cur_img FROM curso a inner join profesor b on a.id_profes = b.id_profes inner join matricula c on a.cur_codigo = c.cur_codigo where c.usu_mail = '$user' ORDER BY cur_fecha DESC");

            $q_mostrar = mysqli_query($mysqli, $sql_mostrar) or die("error: ".mysqli_error($mysqli));
            $r_mostrar = mysqli_fetch_assoc($q_mostrar);

            echo "<div class='container fondo' style='background-color: rgb(255, 255, 255, 0.4);'>
            <div class = 'container'>
        <div class='row'>";
            if($q_mostrar){ 
                if($t_mostrar = mysqli_num_rows($q_mostrar) != 0){
                    do{
                        $titulo = $r_mostrar["cur_nombre"];
                        $codigo = $r_mostrar["cur_codigo"];
                        $idProfe = $r_mostrar["id_profes"];
                        $img = str_replace(" ", "_", $codigo. "." .$r_mostrar["cur_img"]); 
                        $add = "href = 'miscursos.php?cod=$codigo&idp=$idProfe&nomc=$titulo'";
                            echo (sprintf("<div class = 'col-lg-3 col-md-4 col-sm-6 thumb'>
                                            <b class=''>%s</b>
                                            <a $add class = 'thumbnail'><img src='./cursos/%s/%s/%s' class='img-thumbnail img-fluid' alt='Logo del curso'></a>
                                            </div>
                                            ",
                                          $titulo,
                                          $idProfe,
                                          $codigo,
                                          $img));
                    }
                    while($r_mostrar = mysqli_fetch_assoc($q_mostrar));
                }else{
                    echo "No hay cursos disponibles";
                }
            }
            echo "</div>
    </div>";
            ?>
            </main>
                <?php
                include_once("./includes/loginmodal.php");
            require_once("./includes/sweetalertas.php");
            include("./includes/foot.php"); 
            ?>


            </body>
        </html>






