<?php
if(!isset($_SESSION)){
    session_start();
}

include("./includes/login.php");
require_once("./clases/securitypr.php");

$user = $_SESSION["user"];
$codigo = $_GET["gest"];

$sql_profe = sprintf("select id_profes from usuarios a inner join profesor b on a.usu_mail = b.usu_mail where a.usu_mail = %s",
                     valida::convertir($mysqli, $user, "text"));
$q_profe = mysqli_query($mysqli, $sql_profe);
$r_profe = mysqli_fetch_assoc($q_profe);
$idProfe = $r_profe["id_profes"];

$sql_catego = ("select * from categorias");
$q_catego = mysqli_query($mysqli, $sql_catego);
$r_catego = mysqli_fetch_assoc($q_catego);

$sql_mostrar = sprintf("SELECT cur_codigo, cur_nombre, cur_descri, a.id_catego, cur_img, cur_gratis, cur_costo, cur_video FROM curso a inner join profesor b on a.id_profes = b.id_profes inner join categorias c on a.id_catego = c.id_catego where a.cur_codigo = %s",
                       valida::convertir($mysqli, $_GET["gest"], "text"));
$q_mostrar = mysqli_query($mysqli, $sql_mostrar) or die("error: ".mysqli_error($mysqli));
$r_mostrar = mysqli_fetch_assoc($q_mostrar);

 //Numero de matriculas del curso
 $sql_nMatriculas = "SELECT COUNT(cur_codigo) as 'matriculas' FROM matricula where cur_codigo = '$codigo'";
 $q_nMatriculas = mysqli_query($mysqli, $sql_nMatriculas) or die(mysqli_error($mysqli));
 $r_nMatriculas = mysqli_fetch_assoc($q_nMatriculas);
 $nMatriculas = $r_nMatriculas['matriculas'];
 
$curCodigo = $r_mostrar["cur_codigo"];
$curName = $r_mostrar["cur_nombre"];
$curOldName = $r_mostrar["cur_nombre"];
$curCatego = $r_mostrar["id_catego"];
$curDescri = $r_mostrar["cur_descri"];
$curImg = $r_mostrar["cur_img"];
$curVideo = $r_mostrar['cur_video'];
$gratis = $r_mostrar["cur_gratis"];
$costo = $r_mostrar["cur_costo"];
$ges = 0;

$tmpName = "";
$ext = "";
$tmpNameVideo = "";
$extVideo = "";

if(isset($_POST["guardar"])){

    if(file_exists($_FILES["file"]["tmp_name"])  || is_uploaded_file($_FILES['file']['tmp_name'])){
        $tempName = str_replace(" ", "_", $curCodigo . "." .$curImg);
        if(file_exists("./cursos/$idProfe/$curCodigo/$tempName")){
            unlink("./cursos/$idProfe/$curCodigo/$tempName");
        }
        $tmpName = $_FILES["file"]["tmp_name"];
        $partes = $_FILES["file"]["name"];
        $partes = explode(".", $partes);
        $ext = end($partes);
        $curImg = $ext;
    }else{
        $curImg = $r_mostrar["cur_img"];
    }

    if(file_exists($_FILES["fileVideo"]["tmp_name"])  || is_uploaded_file($_FILES['fileVideo']['tmp_name'])){
        $tempName = str_replace(" ", "_", $curCodigo . "." .$curVideo);
        if(file_exists("./cursos/$idProfe/$curCodigo/$tempName")){
            unlink("./cursos/$idProfe/$curCodigo/$tempName");
        }
        $tmpNameVideo = $_FILES["fileVideo"]["tmp_name"];
        $partes = $_FILES["fileVideo"]["name"];
        $partes = explode(".", $partes);
        $extVideo = end($partes);
        $curVideo = $extVideo;
    }else{
        $curVideo = $r_mostrar["cur_img"];
    }

    if($_POST["name"] != ''){
        $curName = $_POST["name"];

        //$oldName = "./cursos/$curCodigo/$curOldName";
        //$newName = "./cursos/$curCodigo/$curName";

        //include("./funciones/funciones.php");
        //rename_win($oldName,$newName);
    }
    if($_POST["categoria"] != ''){
        $curCatego = $_POST["categoria"];
    }
    if($_POST["descri"] != ''){
        $curDescri = $_POST["descri"];
    }
    if(isset($_POST["gratis"])){
        $gratis = $_POST["gratis"];
    }
    if($_POST["costo"] != '' and $gratis != 0){
        $costo = $_POST["costo"];
    }

    $sql_curup = sprintf("UPDATE curso set cur_nombre = %s, cur_descri = %s, cur_img = %s, cur_video = %s, id_catego = %s, cur_gratis = %s, cur_costo = %s where cur_codigo = %s",
                         valida::convertir($mysqli, $curName, "text"),
                         valida::convertir($mysqli, $curDescri, "text"),
                         valida::convertir($mysqli, $curImg, "text"),
                         valida::convertir($mysqli, $curVideo, "text"),
                         valida::convertir($mysqli, $curCatego, "int"),
                         valida::convertir($mysqli, $gratis, "int"),
                         valida::convertir($mysqli, $costo, "double"),
                         valida::convertir($mysqli, $curCodigo, "text"));
    $q_curup = mysqli_query($mysqli, $sql_curup) or die ("Error en:  ". mysqli_error($mysqli));

    $apoyo = sprintf("");
    
    if(file_exists($_FILES["file"]["tmp_name"])  || is_uploaded_file($_FILES['file']['tmp_name'])){

        if(!file_exists("./cursos/$idProfe/$curCodigo")){
            mkdir("./cursos/$idProfe/$curCodigo");
        }
        $carpetaDestino = "./cursos/$idProfe/$curCodigo/";
        $temp = str_replace(" ", "_", $curCodigo);
        $nombreImg = $temp . "." .$ext;
        $destino = $carpetaDestino . $nombreImg;
        move_uploaded_file($tmpName, $destino);
        $cur = 1;
    }

    if(file_exists($_FILES["fileVideo"]["tmp_name"])  || is_uploaded_file($_FILES['fileVideo']['tmp_name'])){

        if(!file_exists("./cursos/$idProfe/$curCodigo")){
            mkdir("./cursos/$idProfe/$curCodigo");
        }
        $carpetaDestino = "./cursos/$idProfe/$curCodigo/";
        $temp = str_replace(" ", "_", $curCodigo);
        $nombreVid = $temp . "." .$extVideo;
        $destino = $carpetaDestino . $nombreVid;
        move_uploaded_file($tmpNameVideo, $destino);
        $cur = 1;
    }

    if(file_exists($_FILES['docs']['tmp_name'][0])){
        foreach($_FILES["docs"]['tmp_name'] as $key => $tmp_name)
        {
            //Validamos que el archivo exista
            if($_FILES["docs"]["name"][$key]) {
                $filename = $_FILES["docs"]["name"][$key]; //Obtenemos el nombre original del archivo
                $source = $_FILES["docs"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                $partes = explode(".",$filename);
                $ext = end($partes);
                $directorio = "./cursos/$idProfe/$curCodigo/aapoyo"; 
                $docName = '';
                
                for($x = 0;$x < count($partes)-1; $x++){
                    $docName .= $partes[$x];
                }
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                }

                $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo

                $sql_apoyo = sprintf("insert into apoyo (cur_codigo, apo_docume, apo_ext) values (%s, %s, %s)",
                                     valida::convertir($mysqli, $curCodigo, "text"),
                                     valida::convertir($mysqli, $docName, "text"),
                                     valida::convertir($mysqli, $ext, "text"));
                $q_apoyo = mysqli_query($mysqli, $sql_apoyo) or die(mysqli_error($mysqli));

                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                if(move_uploaded_file($source, $target_path)) {	
                    $ges =1;
                }	
            }
        }
    }
    
    header("location:./profesor.php?ges=$ges");
}
?>

