<?php
if (!isset($_SESSION)) {
    session_start();
}

include("./includes/login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FPPTU</title>
    <?php
    include_once("./includes/head.php");
    ?>
</head>

<body class="body">
    <?php
    include("./includes/header.php");
    include("./includes/menu.php");
    ?>
    <main class="mt-0">

        <div id='heroCarousel' class="jumbotron jumbotron-fluid carousel slide back-hero" data-ride="carousel" style="position: relative;">

            <!-- Indicators -->
            <ul class="carousel-indicators">
                <li data-target="#heroCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#heroCarousel" data-slide-to="1"></li>
            </ul>

            <!-- The slideshow -->
            <div class="carousel-inner back-hero-content">
                <div class="carousel-item active">
                    <img src="images/banner-min.jpg" alt="Los Angeles" >
                </div>
                <div class="carousel-item">
                    <img src="images/banner-2-min.jpg" alt="Chicago">
                </div>
                
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#heroCarousel" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#heroCarousel" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>

            <!-- ==========================================
            CONTENIDO HERO 
            ============================================ -->

            <div class="container mt-lg-5">

                <div class="row">
                    <div class="col-12 col-lg-7">
                        <h3 class="display-5 text-white font-weight-bold">FORMACION PROFESIONAL DE PROCESOS DE TITULACION EN UNIANDES</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-7">
                        <p class="lead text-white ">Aprende con los mejores profesionales los procesos de titulación.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <a href="./cursos.php" class="btn border border-white px-4 text-white">Ver Cursos</a>
                        <a href='javascript:void(0)' id='nuser2' class="btn btn-primary px-3">Crea una cuenta gratis</a>
                    </div>
                </div>

            </div>
        </div>

        <!-- ==========================================
        CURSOS
        ============================================ -->

        <div class="container fondo">
            <div class="row">
                <h3>Ultimos Cursos</h3>
                <hr>
                <?php
                include_once("./funciones/vercursos.php");
                ?>
            </div>

        </div>

        <!-- ==========================================
        seccion asi son los cursos
        ============================================ -->

        <div class="container-fluid bg-white py-5 my-5">
            <div class="container">

                <div class="row mb-3 justify-content-center">
                    <h4 class="text-center">Así son los cursos de FPPTU</h4>
                    <hr>
                </div>

                <div class="row">

                    <div class="col-12 col-lg-6 px-5 my-3">
                        <i class="fas fa-smile iconos-publicidad"></i>
                        <div class="pl-5">
                            <h5 class="font-weight-bold">Aprende a tu ritmo </h5>
                            <p class='text-muted'>Disfruta de los cursos desde casa sin horarios ni entregas. tu marcas tu propia agenda.</p>
                        </div>

                    </div>

                    <div class="col-12 col-lg-6 px-5 my-3">
                        <i class="fas fa-laptop iconos-publicidad"></i>
                        <div class="pl-5">
                            <h5 class="font-weight-bold">En primera fila</h5>
                            <p class='text-muted'>Vídeos de máxima calidad para que no pierdas detalle. Y como el acceso es ilimitado, puedes verlos una y otra vez.</p>
                        </div>

                    </div>
                </div>

                <div class="row">

                    <div class="col-12 col-lg-6 px-5 my-3">
                        <i class="fas fa-thumbs-up iconos-publicidad"></i>
                        <div class="pl-5">
                            <h5 class="font-weight-bold">De la mano del profesor</h5>
                            <p class='text-muted'>Aprende técnicas y métodos de gran valor explicados por un docente.</p>
                        </div>

                    </div>

                   <div class="col-12 col-lg-6 px-5 my-3">
                        <i class="fas fa-graduation-cap iconos-publicidad"></i>
                        <div class="pl-5">
                            <h5 class="font-weight-bold">Certificado</h5>
                            <p class='text-muted'>Acredita tu asistencia al curso con un certificado firmado por el profesor.</p>
                        </div>

                    </div>
                </div>

                <div class="row">

                    <div class="col-12 col-lg-6 px-5 my-3">
                        <i class="fas fa-id-badge iconos-publicidad"></i>
                        <div class="pl-5">
                            <h5 class="font-weight-bold">Profesores expertos</h5>
                            <p class='text-muted'>Cada profesor imparte  lo que mejor sabe hacer, asegurando transmitir la excelencia en cada lección.</p>
                        </div>

                    </div>

                   <div class="col-12 col-lg-6 px-5 my-3">
                        <i class="fas fa-user-check iconos-publicidad"></i>
                        <div class="pl-5">
                            <h5 class="font-weight-bold">Cursos producidos profesionalmente</h5>
                            <p class='text-muted'>Seleccionamos a los mejores y un equipo profesional produce el curso con ellos. El resultado: sentirás que trabajas mano a mano con los mejores.</p>
                        </div>

                    </div>
                </div>

         

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