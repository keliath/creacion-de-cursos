<?php
#deberia autenticarse para otorgar permisos solo a los propietarios de la clase
#nueva pagina de administrar clases donde en esa clase salga la lista de clases y las opciones disponibles (editar,borrar, crear nueva)
#el crear clases podria ser un formulario modal en la misma pagina

if (!isset($_SESSION)) {
    session_start();
}

require_once("./clases/conexion.php");
require_once("./clases/valida.php");
include("./funciones/funciones.php");
require_once("./clases/securitypr.php");

$curCodigo = $_GET['apo'];
$idProfe = $_GET['idp'];
$curName = $_GET["nomc"];

$sql_listaClases = ("select * from clases where cur_codigo = '$curCodigo'");
$q_listaClases = mysqli_query($mysqli, $sql_listaClases);
$r_listaClases = mysqli_fetch_assoc($q_listaClases);

/* ==========================================
Editar clase
=========================================== */
if (isset($_POST['cambiarNombreClase'])) {

    $idClaseEditada = $_POST['idClase'];
    $nombreClase = $_POST['cambiarNombreClase'];
    $videoName = $_POST['cambiarVideoNombre'];
    $extVideo = $_POST['cambiarVideoExtension'];
    $oldVideoName = $_POST['cambiarVideoNombre'];
    $carpetaDestino = "./cursos/$idProfe/$curCodigo/$idClaseEditada/";

    $succ = 0;

    if (isset($_POST['inputVideoChange']) && $_POST['inputVideoChange'] != '') {
        if (file_exists($carpetaDestino . $videoName . "." . $extVideo)) {
            unlink($carpetaDestino . $videoName . "." . $extVideo); //borrar el antiguo video
        }

        $partesVideoTemp = $_POST['inputVideoChange'];
        $partesVideo = explode(".", $partesVideoTemp);
        $videoName = reset($partesVideo);
        $extVideo = end($partesVideo);
        $videoName = str_replace(" ", "_", $nombreClase);
    } else {
        $videoName = str_replace(" ", "_", $nombreClase);
        copy($carpetaDestino . $oldVideoName . "." . $extVideo, $carpetaDestino . $videoName . "." . $extVideo);
        unlink($carpetaDestino . $oldVideoName . "." . $extVideo);
    }

    $sql_editarClase = "UPDATE clases SET cla_nombre = '$nombreClase', cla_recurso = '$videoName', cla_ext = '$extVideo' WHERE id_clases = $idClaseEditada";
    $q_editarClase = mysqli_query($mysqli, $sql_editarClase) or die(mysqli_error($mysqli));

    if ($q_editarClase) {

        if (isset($_POST['inputVideoChange']) && $_POST['inputVideoChange'] != '') {

            $directorioTemp = glob("./temp/" . $idProfe . "/*");
            $carpetaTemporal = "./temp/" . $idProfe . "/";

            foreach ($directorioTemp as $value) {
                if (is_file($value))
                    if ($value == $carpetaTemporal . $partesVideoTemp) {
                        copy($value, $carpetaDestino . $videoName . "." . $extVideo);
                    }
            }

            include_once("ajax.deleteFile.php"); //borramos todos los archivos de la carpeta temporal
        }
        $succ = 2;
    }

    header("location:./gestclases.php?apo=$curCodigo&idp=$idProfe&nomc=$curName&succ=$succ");
}


/* ==========================================
Crear Clase
=========================================== */
if (isset($_POST['createVideoClass'])) {

    $date = date("Y-m-d H:i:s");

    $videoNameOld = $_POST["inputVideo"];
    $partesVideo = explode(".", $videoNameOld);
    $videoName = reset($partesVideo);
    $extVideo = end($partesVideo);

    $className = $_POST['className'];
    $videoName = str_replace(" ", "_", $className);
    $succ = 0;

    $sql_createVideoClass = sprintf(
        "INSERT INTO clases (cur_codigo, cla_nombre, cla_recurso, cla_ext, cla_fecha) values (%s, %s, %s, %s, %s)",
        valida::convertir($mysqli, $curCodigo, "text"),
        valida::convertir($mysqli, $className, "text"),
        valida::convertir($mysqli, $videoName, "text"), //cambio
        valida::convertir($mysqli, $extVideo, "text"),
        valida::convertir($mysqli, $date, "text")
    );
    $q_createVideoClass = mysqli_query($mysqli, $sql_createVideoClass) or die(mysqli_error($mysqli));

    if ($q_createVideoClass) {
        if (!file_exists("./cursos/$idProfe")) {
            mkdir("./cursos/$idProfe");
        }
        if (!file_exists("./cursos/$idProfe/$curCodigo")) {
            mkdir("./cursos/$idProfe/$curCodigo");
        }

        $lastId = mysqli_insert_id($mysqli);
        if (!file_exists("./cursos/$idProfe/$curCodigo/$lastId")) {
            mkdir("./cursos/$idProfe/$curCodigo/$lastId");
        }

        $carpetaDestino = "./cursos/$idProfe/$curCodigo/$lastId/";
        $archivo = glob("./temp/" . $idProfe . "/*");
        $carpetaTemporal = "./temp/" . $idProfe . "/";

        foreach ($archivo as $value) {
            if (is_file($value))
                if ($value == $carpetaTemporal . $videoNameOld) {
                    copy($value, $carpetaDestino . $videoName . "." . $extVideo);
                }
        }

        include_once("ajax.deleteFile.php"); //borramos todos los archivos de la carpeta temporal

        $succ = 1;
    }

    header("location:./gestclases.php?apo=$curCodigo&idp=$idProfe&nomc=$curName&succ=$succ");
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
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <form action="">
                        <div class="form-group">
                            <div class="container">
                                <h2>Vídeo Clases del Curso "<?php echo $curName ?>"</h2>
                                <?php
                                if (mysqli_num_rows($q_listaClases) > 0) {
                                ?>

                                    <table class="tabla">
                                        <thead>
                                            <tr>
                                                <th>Clase</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            do {
                                                $idClase = $r_listaClases['id_clases'];
                                                $nombresLista = $r_listaClases['cla_nombre'];
                                                $nombreVideo = str_replace(" ", "_", $nombresLista);
                                                $extensionVideo = $r_listaClases['cla_ext'];
                                                $recurso = $r_listaClases['cla_recurso'];

                                                $dirVideo = $recurso . "." . $extensionVideo;
                                                $nombreListaProcesado = str_replace(" ", "_", $nombresLista);
                                            ?>
                                                <tr>
                                                    <td> <?php echo $nombresLista ?> </td>
                                                    <td>
                                                        <a href='<?php echo "./cursos/$idProfe/$curCodigo/$idClase/$dirVideo" ?>' target="_blank" style='margin-right:15px'>
                                                            Ver
                                                        </a>
                                                        <a href='#' data-toggle="modal" data-target="#editarClase" style='margin-right:15px' onclick="asignarId(<?php echo $idClase; ?>,'<?php echo $nombreListaProcesado; ?>','<?php echo $recurso; ?>','<?php echo $extensionVideo; ?>')">
                                                            Editar
                                                        </a>
                                                        <a onclick="borrarClase('<?php echo $curCodigo ?>', <?php echo $idProfe ?>,'<?php echo $curName ?>', <?php echo $idClase ?>)" href="#">
                                                            Borrar
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php

                                            } while ($r_listaClases = mysqli_fetch_assoc($q_listaClases));
                                            ?>
                                        </tbody>
                                    </table>
                            </div>

                        <?php

                                } else {
                                    echo "No hay Clases disponibles";
                                }
                                echo "<br>
                                <a href='gestcur.php?gest=$curCodigo' class='btn btn-primary' style='text-decoration:none'>Volver</a>
                                <a  href='javascript:void(0)' id='createNewClass' class='btn btn-primary' style='text-decoration:none'>Crear Clase</a>";
                        ?>
                        </div>
                        <div class="form-group" id="display">
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- ==========================================
        MODAL CREAR CLASE
        ============================================ -->

        <div id="id01" class="login modal">
            <form class="login modal-content animate" action="" method="post" enctype="multipart/form-data">
                <div class="login container">
                    <br>
                    <h3>Recursos de la clase</h3>
                    <hr>

                    <label for="className"><b>Nombre de la Clase:</b></label>
                    <input type="text" placeholder="ingrese el nombre de la clase" name="className" required>

                    <label for="fileVideo">Vídeo:</label>
                    <br>
                    <!-- UPLOAD FORM -->
                    <div id="container" class="border rounded mb-3">
                        <input type="text" id="inputVideo" name="inputVideo" hidden>
                        <button id="pickfiles" class="btn btn-secondary">Subir video</button>

                        <!-- UPLOAD FILE LIST -->
                        <div id="filelist">Your browser doesn't support HTML5 upload.</div>
                    </div>

                    <div class="alert alert-warning">
                        Debe subir un video o esperar a que se termine de subir el actual
                    </div>

                    <div class="container">
                        <div class="row">
                            <input type="submit" name="createVideoClass" id="createVideoClass" class="btn btn-success col-md-6" value="Crear">
                            <button type="button" id="cancel" class="btn btn-danger col-md-6">Cancelar</button>
                        </div>
                    </div>
                    <br>
                </div>
            </form>
        </div>


        <!-- ==============================
        VENTANA MODAL CAMBIO DE Clase
        ================================ -->

        <!-- The Modal -->
        <div class="modal" id="editarClase">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Editar Clase</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                            <input type="hidden" name="idClase" id="idClase" value="">

                            <div class="form-group">
                                <label for="cambiarVideo">Cambiar Nombre de la Clase</label>
                                <input type="text" class="form-control-file border" name="cambiarNombreClase" id="cambiarNombreClase" required>
                            </div>

                            <div class="form-group">
                                <label for="fileVideo">Cambiar Video <strong style="font-size: 0.75em;">(no subir nada si quiere consevar el video antiguo)</strong></label>
                                <br>
                                <!-- UPLOAD FORM -->
                                <div id="container" class="border rounded mb-3">
                                    <input type="text" id="inputVideoChange" name="inputVideoChange" >
                                    <button id="pickfilesChange" class="btn btn-secondary">Subir video</button>

                                    <!-- UPLOAD FILE LIST -->
                                    <div id="filelistChange">Your browser doesn't support HTML5 upload.</div>
                                </div>

                                <div class="alert alert-warning">
                                    Debe subir un video o esperar a que se termine de subir el actual
                                </div>

                                <input type="text" class="form-control-file border" name="cambiarVideoNombre" id="cambiarVideoNombre" hidden required>
                                <input type="text" class="form-control-file border" name="cambiarVideoExtension" id="cambiarVideoExtension" hidden required>


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


    <script>
        // Get the modal
        var createClassModal = document.getElementById('id01');
        var createNewClass = document.getElementById('createNewClass');
        var cancel = document.getElementById('cancel');

        var idProfe = "<?php echo $idProfe ?>";
        var curCodigo = "<?php echo $curCodigo ?>";


        function borrarClase(curCodigo, idProfe, curName, idClase) {
            Swal.fire({
                title: 'Esta seguro de borrar la clase?',
                text: "No podra revertirlo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Borrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = `delcla.php?apo=${curCodigo}&idp=${idProfe}&nomc=${curName}&id=${idClase}`;
                }
            })
        }


        //asignar id de clase al modal de edicion de la clase

        function asignarId(id, nombre, video, ext) {
            $("#idClase").val(id);
            nombre = nombre.replace(/_/g, " ");
            $("#cambiarNombreClase").val(nombre);
            $("#cambiarVideoNombre").val(video);
            $("#cambiarVideoExtension").val(ext);
        }


        //cuando el usuario da click en la palabra 'iniciar sesion' del encabezado el modal se abre
        createNewClass.onclick = function() {
            createClassModal.style.display = 'block';
        }

        //boton cancelar del modal que lo cerrara
        cancel.onclick = function() {
            createClassModal.style.display = 'none';
        }

        //cuando el usuario da click fuera del modal este se cierra
        window.onclick = function(event) {
            if (event.target == createClassModal) {
                createClassModal.style.display = 'none';
            }
        }


        window.addEventListener("load", function() {
            var uploader = new plupload.Uploader({
                runtimes: 'html5,html4',
                browse_button: 'pickfiles',
                url: 'ajax.subir-videos.php',
                chunk_size: '10mb',
                multi_selection: false,
                filters: {
                    //max_file_size: '150mb',
                    mime_types: [{
                        title: "Video files",
                        extensions: "mp4"
                    }]
                },
                multipart_params: {
                    "idProfe": idProfe
                },
                init: {

                    PostInit: function() {
                        document.getElementById('filelist').innerHTML = '';
                        console.log('sda');
                        $.ajax({
                            url: 'ajax.deleteFile.php',
                            type: 'post',
                            data: {
                                'idProfe': idProfe
                            },
                            success: function(response) {
                                // do something
                            },
                            error: function() {
                                // do something
                            }
                        });
                    },
                    FilesAdded: function(up, files) {

                        var fileCount = up.files.length,
                            i = 0,
                            ids = $.map(up.files, function(item) {
                                return item.id;
                            });

                        if (fileCount > 1) {
                            for (i = 0; i < (fileCount - 1); i++) {
                                $("#filelist").empty();
                                var fileName = uploader.getFile(ids[i]);
                                uploader.removeFile(uploader.getFile(ids[i]));
                                $.ajax({
                                    url: 'ajax.deleteFile.php',
                                    type: 'post',
                                    data: {
                                        'idProfe': idProfe,
                                        'file': fileName.name
                                    },
                                    success: function(response) {
                                        // do something
                                    },
                                    error: function() {
                                        // do something
                                    }
                                });
                            }
                        }

                        plupload.each(files, function(file) {
                            document.getElementById('filelist').innerHTML +=
                                `<div id="${file.id}">${file.name} (${plupload.formatSize(file.size)}) <strong></strong></div>`;


                        });

                        uploader.start();


                    },
                    FileUploaded: function(up, file, result) {
                        $('#inputVideo').val(file.name);
                    },
                    UploadProgress: function(up, file) {
                        $('#inputVideo').val("");
                        document.querySelector(`#${file.id} strong`).innerHTML =
                            `<span>${file.percent}%</span>`;
                    },
                    Error: function(up, err) {
                        console.log(err);
                    }
                }
            });
            uploader.init();


            var uploader2 = new plupload.Uploader({
                runtimes: 'html5,html4',
                browse_button: 'pickfilesChange',
                url: 'ajax.subir-videos.php',
                chunk_size: '10mb',
                multi_selection: false,
                filters: {
                    //max_file_size: '150mb',
                    mime_types: [{
                        title: "Video files",
                        extensions: "mp4"
                    }]
                },
                multipart_params: {
                    "idProfe": idProfe
                },
                init: {

                    PostInit: function() {
                        document.getElementById('filelistChange').innerHTML = '';

                    },
                    FilesAdded: function(up, files) {

                        var fileCount = up.files.length,
                            i = 0,
                            ids = $.map(up.files, function(item) {
                                return item.id;
                            });

                        if (fileCount > 1) {
                            for (i = 0; i < (fileCount - 1); i++) {
                                $("#filelistChange").empty();
                                var fileName = uploader2.getFile(ids[i]);
                                uploader2.removeFile(uploader2.getFile(ids[i]));
                                $.ajax({
                                    url: 'ajax.deleteFile.php',
                                    type: 'post',
                                    data: {
                                        'idProfe': idProfe,
                                        'file': fileName.name
                                    },
                                    success: function(response) {
                                        // do something
                                    },
                                    error: function() {
                                        // do something
                                    }
                                });
                            }
                        }

                        plupload.each(files, function(file) {
                            document.getElementById('filelistChange').innerHTML +=
                                `<div id="${file.id}">${file.name} (${plupload.formatSize(file.size)}) <strong></strong></div>`;


                        });

                        uploader2.start();


                    },
                    FileUploaded: function(up, file, result) {
                        $('#inputVideoChange').val(file.name);
                    },
                    UploadProgress: function(up, file) {
                        $('#inputVideoChange').val("");
                        document.querySelector(`#${file.id} strong`).innerHTML =
                            `<span>${file.percent}%</span>`;
                    },
                    Error: function(up, err) {
                        console.log(err);
                    }
                }
            });
            uploader2.init();


            // Handle the case when form was submitted before uploading has finished
            $('#id01').submit(function(e) {
                // Files in queue upload them first
                if ($('#inputVideo').val() == '') {
                    $(".alert").show();
                    return false;
                }
            });


        });
    </script>
</body>

</html>