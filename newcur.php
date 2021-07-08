<?php
if(!isset($_SESSION)){
    session_start();
}

include("./includes/login.php");
include("./funciones/funciones.php");
require_once("./clases/securitypr.php");

$sql_catego = ("select * from categorias");
$q_catego = mysqli_query($mysqli, $sql_catego);
$r_catego = mysqli_fetch_assoc($q_catego);

if(isset($_POST["crear"])){
    $tmpName = $_FILES["file"]["tmp_name"];
    $partes = $_FILES["file"]["name"];
    $partes = explode(".", $partes);
    $ext = end($partes);

    $tmpNameVideo = $_FILES["fileVideo"]["tmp_name"];
    $partesVideo = $_FILES["fileVideo"]["name"];
    $partesVideo = explode(".", $partesVideo);
    $extVideo = end($partesVideo);

    $codigoU = uniqid();
    $date = date("Y-m-d");
    $user = $_SESSION["user"];
    $name = $_POST["name"];
    $catego = $_POST["categoria"];
    $descri = $_POST["descri"];
    $gratis = 0;
    $costo = 0;
    isset($_POST["gratis"])?$gratis = $_POST["gratis"]: $gratis = 0;
    ($_POST["costo"] != '' and $gratis != 0)?$costo = $_POST["costo"]: $costo = 0;
    $cur = 0;

    $sql_profe = sprintf("select id_profes from usuarios a inner join profesor b on a.usu_mail = b.usu_mail where a.usu_mail = %s",
                         valida::convertir($mysqli, $user, "text"));
    $q_profe = mysqli_query($mysqli, $sql_profe);
    $r_profe = mysqli_fetch_assoc($q_profe);
    $idProfe = $r_profe["id_profes"];
    $curCodigo = generarCodigo($idProfe, $name, $codigoU);

    $sql_curso = sprintf("insert into curso (cur_codigo, id_profes, cur_nombre, cur_descri, id_catego, cur_img, cur_video, cur_gratis, cur_costo, cur_fecha) values (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                         valida::convertir($mysqli, $curCodigo, "text"),
                         valida::convertir($mysqli, $idProfe, "int"),
                         valida::convertir($mysqli, $name, "text"),
                         valida::convertir($mysqli, $descri, "text"),
                         valida::convertir($mysqli, $catego, "int"),
                         valida::convertir($mysqli, $ext, "text"),
                         valida::convertir($mysqli, $extVideo, "text"),
                         valida::convertir($mysqli, $gratis, "int"),
                         valida::convertir($mysqli, $costo, "double"),
                         valida::convertir($mysqli, $date, "date"));
    $q_curso = mysqli_query($mysqli, $sql_curso)or die(mysqli_error($mysqli)." error en crear");

   
    if($q_curso){
        if(!file_exists("./cursos/$idProfe")){
            mkdir("./cursos/$idProfe");
        }
        if(!file_exists("./cursos/$idProfe/$curCodigo")){
            mkdir("./cursos/$idProfe/$curCodigo");
        }
        
        $carpetaDestino = "./cursos/$idProfe/$curCodigo/";
        $temp = str_replace(" ", "_", $curCodigo);
        $nombreImg = $temp . "." .$ext;
        $nombreVideo = $temp . "." .$extVideo;
        $destino = $carpetaDestino . $nombreImg;
        $destinoVideo = $carpetaDestino . $nombreVideo;
        move_uploaded_file($tmpName, $destino);
        move_uploaded_file($tmpNameVideo, $destinoVideo);
        $cur = 1;
    }

    header("location:./profesor.php?cur=$cur");
}
?>
<!DOCTYPE html>
<html lang="es">
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

            <div class="container" style="margin-top:30px">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <h5>Menú de creación del curso</h5>
                                <hr class="d-sm-none">
                            </div>
                            <div class="form-group">
                                <label for="name">Nombre del curso</label>
                                <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="categoria">Categoria del curso</label>
                                <select name="categoria" id="" class="form-control" required>
                                    <option value="">Selecciona una Categoria</option>
                                    <?php
                                    do{
                                        $id = $r_catego["id_catego"];
                                        $nombre = $r_catego["cat_catego"];
                                        echo "<option value = '$id'>$nombre</option>";
                                    }
                                    while($r_catego = mysqli_fetch_assoc($q_catego));
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="file">Imagen del curso:</label>
                                <input type="file" name="file" class="form-control-file" accept="image/x-png, image/jpeg, image/gif " required>
                            </div>
                            <div class="form-group">
                                <label for="fileVideo">Vídeo introductorio del curso:</label>
                                <input type="file" name="fileVideo" class="form-control-file" accept="video/* " required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="gratis" class="custom-control-input" id="gratis" value="1" onclick="mostrar(this)">
                                    <label class="custom-control-label" for="gratis">Curso de pago?</label>
                                </div>
                            </div>
                            <div class="form-group campos-opcional"  id="opcional">
                                <label for="costo">Costo del Curso:</label>
                                <input type="number" name="costo" class="form-control" placeholder="Costo del curso (0 = gratis xs)">
                            </div>
                            <div class="form-group">
                                <label for="descri">Descripccion del Curso:</label>
                                <textarea name="descri" cols="30" rows="8" class="form-control" placeholder="breve descripcion del curso" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" name="crear">Crear</button>
                        </form>
                    </div>
                </div>
            </div>

        </main>

        <?php
        include_once("./includes/loginmodal.php");
        require_once("./includes/sweetalertas.php");
        ?>

        <script>
            var pago = document.getElementById('switch1');
            var opcional = document.getElementById('opcional');
            function mostrar(obj){
                if(obj.checked == true){
                    opcional.style.display = 'block';
                }else{
                    opcional.style.display = 'none';
                }
            }

        </script>
    </body>
</html>