<?php
if(!isset($_SESSION)){
    session_start();
}

include_once("./includes/login.php");

$curCodigo = $_GET["apo"];
$idProfe = $_GET["idp"];
$curName = $_GET["nomc"];

$sql_material = sprintf("select * from apoyo a inner join curso b on a.cur_codigo = b.cur_codigo where a.cur_codigo = '$curCodigo'");
$q_material = mysqli_query($mysqli, $sql_material)or die (mysqli_error($mysqli));

$t_material = mysqli_num_rows($q_material);
$r_material = mysqli_fetch_assoc($q_material);

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
                    <div class="col-sm-12">
                        <form action="">
                            <div class="form-group">
                                <?php
                                if(mysqli_num_rows($q_material) > 0){
                                ?>
                                <table class="tabla">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                    do{
                                        $nom = $r_material['apo_docume'];
                                        $id = $r_material['id_apoyo'];
                                        $ext = $r_material['apo_ext'];
                                        $doc = $nom . "." .$ext;
                                        echo 
                                            "<tr>
                                                <td>$nom</td>
                                                <td>
                                                    <a href='./cursos/$idProfe/$curCodigo/aapoyo/$doc' target='_blank' style='margin-right:15px'>
                                                        Ver
                                                    </a>
                                                    <a href='deldoc.php?apo=$curCodigo&idp=$idProfe&nomc=$curName&id=$id&doc=$doc'>
                                                        Borrar
                                                    </a>
                                                </td>
                                                
                                            </tr>";
                                    }while($r_material = mysqli_fetch_assoc($q_material));
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                    echo "<a href='gestcur.php?gest=$curCodigo' class='btn btn-primary' style='text-decoration:none'>Volver</a>";

                                }else{
                                    echo "No hay documentos disponibles";
                                }
                                ?>
                            </div>
                            <div class="form-group" id="display">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>

        <?php
        include_once("./includes/loginmodal.php");
        require_once("./includes/sweetalertas.php");
        ?>

    </body>
</html>
