<?php
if (!isset($_SESSION)) {
    session_start();
}

include("./includes/login.php");
require_once("./clases/securitypr.php");

$lvl = $_SESSION["nivel"];
$user = $_SESSION["user"];

$sql_perfilProfesor = sprintf("select id_profes, a.usu_mail, pro_foto, pro_biografia, usu_nombre from profesor a inner join usuarios b on a.usu_mail = b.usu_mail where a.usu_mail = '$user'");
$q_perfilProfesor = mysqli_query($mysqli, $sql_perfilProfesor) or die(mysqli_errno($mysqli));
$r_perfilProfesor = mysqli_fetch_assoc($q_perfilProfesor);


if (isset($_POST["inputBiografia"])) {

    $biografia = trim($_POST["inputBiografia"]);
    $idProfe = $r_perfilProfesor["id_profes"];
    $sql_actualizarBio = "UPDATE profesor set pro_biografia = '$biografia' where id_profes = $idProfe";

    $q_actualizarBio = mysqli_query($mysqli, $sql_actualizarBio) or die(mysqli_error($mysqli));

    $bio = 0;
    if ($q_actualizarBio) {
        $bio = 1;
    }
    header("location:./profesor-perfil.php?bio=$bio");
}



if (isset($_POST["idUsuarioFoto"])) {

    $fotoActual = $_POST["fotoActual"];


    if (isset($_FILES["cambiarImagen"]["tmp_name"]) && !empty($_FILES["cambiarImagen"]["tmp_name"])) {

        $fotoEstado = 0;
        list($ancho, $atlo) = getimagesize($_FILES["cambiarImagen"]["tmp_name"]);

        $nuevoAncho = 500;
        $nuevoAlto = 500;

        /* ==========================
        CREAR DIRECTORIO DONDE IRA LA FOTO
        =========================== */

        $directorio = "images/usuarios/" . $_POST["idUsuarioFoto"];

        if ($fotoActual != "") {
            unlink($fotoActual);
        } else {

            if (!file_exists($directorio)) {

                mkdir($directorio, 0755);
            }
        }

        if ($_FILES["cambiarImagen"]["type"] == "image/jpg") {

            $aleatorio = mt_rand(100, 999);

            $fotoActual = $directorio . "/" . $aleatorio . "." . "jpg";

            $origen = imagecreatefromjpeg($_FILES["cambiarImagen"]["tmp_name"]);

            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $atlo);

            imagejpeg($destino, $fotoActual);

            $fotoEstado = 1;
        } elseif ($_FILES["cambiarImagen"]["type"] == "image/jpeg") {

            $aleatorio = mt_rand(100, 999);

            $fotoActual = $directorio . "/" . $aleatorio . "." . "jpeg";

            $origen = imagecreatefromjpeg($_FILES["cambiarImagen"]["tmp_name"]);

            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $atlo);

            imagejpeg($destino, $fotoActual);

            $fotoEstado = 1;
        } elseif ($_FILES["cambiarImagen"]["type"] == "image/png") {

            $aleatorio = mt_rand(100, 999);

            $fotoActual = $directorio . "/" . $aleatorio . "." . "png";

            $origen = imagecreatefrompng($_FILES["cambiarImagen"]["tmp_name"]);

            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

            imagealphablending($destino, false);

            imagesavealpha($destino, true);

            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $atlo);

            imagepng($destino, $fotoActual);

            $fotoEstado = 1;
        } else {

            echo ("<script>alerta('Error', 'No se permiten fotos que no sean jpg, jpeg y/o png', 'error')</script>");
            return;
        }

        //final condicion

        $id = $_POST["idUsuarioFoto"];
        $item = "usu_foto";
        $valor = $fotoActual;


        $sql_actualizarFoto = sprintf("UPDATE profesor SET pro_foto = '$valor' WHERE id_profes = $id");
        $q_actualizarFoto = mysqli_query($mysqli, $sql_actualizarFoto) or die(mysqli_error($mysqli));
        if ($q_actualizarFoto) {
        } else {
            $fotoEstado = 0;
        }

        header("location:./profesor-perfil.php?foto=$fotoEstado");
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
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3>Perfil</h3>
                    <hr>
                </div>
            </div>

            <div class="row">


                <div class="col-12 col-lg-4">

                    <div class="card card-info card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">

                                <?php

                                $rutaFoto = "images/usuarios/default/default.png";

                                if ($r_perfilProfesor["pro_foto"] != NULL) {
                                    $rutaFoto = $r_perfilProfesor["pro_foto"];
                                }

                                ?>
                                <img class="profile-user-img img-fluid img-circle" src="<?php echo $rutaFoto ?>" alt="" width="200">
                            </div>


                            <h3 class="profile-username text-center">
                                <?php echo $r_perfilProfesor["usu_nombre"]; ?>
                            </h3>

                            <p class="text-muted text-center">
                                <?php echo $r_perfilProfesor["usu_mail"]; ?>
                            </p>

                            <div class="text-center">

                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cambiarFoto">Cambiar Foto</button>
                                <!-- <button class="btn btn-purple btn-sm" data-toggle="modal" data-target="#cambiarPassword">Cambiar contraseña</button> -->

                            </div>
                        </div>
                        <!-- <div class="card-footer">

                            <button class="btn btn-default float-right">Eliminar Cuenta</button>

                        </div> -->
                    </div>

                </div>

                <div class="col-12 col-lg-8 mt-3 mt-lg-0">
                    <div class="card car-primary card-outline">

                        <form action="" method="post">
                            <div class="card-header">

                                <h5 class="m-0 text-uppercase text-secondary">
                                    <strong>Completar Campos del perfil</strong>
                                </h5>

                            </div>

                            <div class="card-body">


                                <div class="form-group">

                                    <label for="inputBiografia" class="control-label">Breve Autobiografía:</label>
                                    <hr>
                                    <textarea name="inputBiografia" class="form-control" id="" cols="30" rows="5">
<?php if ($r_perfilProfesor['pro_biografia'] != null) : ?><?php echo trim($r_perfilProfesor['pro_biografia']); ?><?php endif ?>
                                    </textarea>





                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2">
                                        <button type="submit" class="btn btn-dark suscribirse">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>



            </div>
        </div>


        <!-- ==============================
VENTANA MODAL CAMBIO DE FOTO
================================ -->

        <!-- The Modal -->
        <div class="modal" id="cambiarFoto">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar imagen</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                            <input type="hidden" name="idUsuarioFoto" value="<?php echo $r_perfilProfesor['id_profes'] ?>">

                            <div class="form-group">
                                <input type="file" class="form-control-file border" name="cambiarImagen" required>

                                <input type="hidden" name="fotoActual" value="<?php echo $r_perfilProfesor["pro_foto"] ?>">
                            </div>

                        </div>

                        <!-- Modal footer ----------- d-flex justify-content-between estas dos clases son para separar a extremos los contenidos -->
                        <div class="modal-footer ">

                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>


                    </form>

                </div>
            </div>
        </div>


    </main>



    <?php
    require_once("./includes/sweetalertas.php");
    ?>


</body>

</html>