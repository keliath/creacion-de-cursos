<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("./includes/login.php");



if (isset($_GET["cod"])) {
    $codigo = $_GET["cod"];
    $sql_curso = "select a.id_profes, usu_nombre, pro_biografia, pro_foto, cur_nombre, cur_descri, cur_costo, cur_img, cur_video from curso a inner join profesor b on a.id_profes = b.id_profes inner join usuarios c on b.usu_mail = c.usu_mail where cur_codigo = '$codigo'";
    $q_curso = mysqli_query($mysqli, $sql_curso) or die(mysqli_error($mysqli));
    $r_curso = mysqli_fetch_assoc($q_curso);

    $idProfe = $r_curso["id_profes"];
    $curName = $r_curso["cur_nombre"];
    $curDescri = $r_curso["cur_descri"];
    $profeBio = $r_curso["pro_biografia"];
    $profeFoto = $r_curso["pro_foto"];

    //Numero de matriculas del curso
    $sql_nMatriculas = "SELECT COUNT(cur_codigo) as 'matriculas' FROM matricula where cur_codigo = '$codigo'";
    $q_nMatriculas = mysqli_query($mysqli, $sql_nMatriculas) or die(mysqli_error($mysqli));
    $r_nMatriculas = mysqli_fetch_assoc($q_nMatriculas);
    $nMatriculas = $r_nMatriculas['matriculas'];

    if ($profeFoto != Null) {
        $profeFoto = "<img src='$profeFoto' class='img-fluid rounded' width='200px'>";
    } else {
        $profeFoto = "<img src='images/usuarios/default/default.png' class='img-fluid rounded-circle' width='30px'>";
    }


    $espago = 0;
    $curCosto = $r_curso["cur_costo"];
    if ($curCosto > 0) {
        $curCosto = "$" . $r_curso["cur_costo"];
    } else {
        $curCosto = "Gratis";
    }
    $img = $codigo . "." . $r_curso["cur_img"];
    $video = $codigo . "." . $r_curso["cur_video"];
}




if (isset($_POST["matricular"])) {
    $espago = $r_curso["cur_costo"];
    $comcur[] = array("product_name" => "$curName", "product_quantity" => "1", "product_price" => "$espago");
    $_SESSION["cart"] = $comcur;
    $fecha = date("Y-m-d");
    $pago = "pago" . $user;
    $pago = md5($pago);

    if ($espago > 0) {
        header("location:./payprocess.php?pag=$pago?cur=$codigo");
        exit;
    }

    $sql_matricular = sprintf(
        "insert into matricula (cur_codigo, usu_mail, mat_fecha) values (%s, %s, %s)",
        valida::convertir($mysqli, $codigo, "text"),
        valida::convertir($mysqli, $_SESSION["user"], "text"),
        valida::convertir($mysqli, $fecha, "date")
    );
    $q_matricular = mysqli_query($mysqli, $sql_matricular);

    if ($q_matricular) {
        header("location:./?mat=1");
    } else {
        header("location:./?mat=2");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script>
        function abrir() {
            loginModal.style.display = 'block';
        }
    </script>
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
        <main>
            <div class="container" >
                <div class="row">
                    <?php
                    if (!isset($_GET["cod"])) {
                        include_once("./funciones/vercursos.php");
                    } else {
                        $btnMatriculaValida = "<input type='submit' name='matricular' id='matricular' class='btn btn-success' value='Matricularse'>";
                        $btnMatriculaInvalida = "<input type='button' onclick= 'abrir()' name='matricular' id='matricular' class='btn btn-success' value='Matricularse'>";

                        //cambio de la imagen del curso por un video------<img src='./cursos/$idProfe/$codigo/$img' alt='imagen del curso $curName' style='margin-top:20px;max-width:300px;max-height:300px'>
                        echo "
                        <div class='container'>
    <div class='row'>
        <h2>Curso: $curName</h2>
    </div>
    <div class='row mb-3'>
        <div class='col-sm-6'>
            <div class='form-group pt-3'>
                <video width='100%' height='240' controls>
                                                <source src='./cursos/$idProfe/$codigo/$video' type='video/mp4'>
                                                Tu navegador no soporta este tipo de video.
                                            </video>
            </div>
        </div>

        <div class='col-sm-6'>
            <div class='row'>
                <div class='col-sm-12'>
                    <div class='container'>
                        <form action='' method='post' class='form-inline my-4'>
                            <div class='form-group'>";
                        if (isset($_SESSION["user"])) {
                            echo "$btnMatriculaValida";
                        } else {
                            echo "$btnMatriculaInvalida";
                        }
                        echo "
                            </div>
                            <div>
                                <b><label class='pl-5' for=''>Precio: <span class=''>$curCosto</span></label></b>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class='col-sm-12'>
                <h4><b>Descripcion del curso</b></h4>
                <p>$curDescri</p>
            </div>
            <div class='col-sm-12'>
                <h6><b>Usuarios Matriculados: $nMatriculas</b></h6>
            </div>
        </div>
    </div>
    <hr>
    <div class='row'>
        <div class='container mb-2'>
            <h3>Tutor/ra</h3>
        </div>
        
    </div>
    <div class='row'>

        <div class='col-6'>
            <div class='container'>
                <p class='h5'>
                    $profeBio
                </p>
            </div>
        </div>

        <div class='col-6'>
            <div class='container text-center pb-3'>
                $profeFoto
            </div>
        </div>

    </div>
</div>
</div>
                            ";
                    }
                    ?>
                </div>

            </div>
        </main>
    </main>
    <?php
    include_once("./includes/loginmodal.php");
    require_once("./includes/sweetalertas.php");
    include("./includes/foot.php");
    ?>


</body>

</html>
