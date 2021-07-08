<?php
require_once("./clases/conexion.php");
require_once("./clases/valida.php");

//condiciones de alert para el registro


//
if(isset($_POST['login'])){
    $sql_login = sprintf("select * from usuarios where usu_mail =  %s and usu_pass = %s and usu_activo = 1",
                         valida::convertir($mysqli, $_POST["mail"],"text"),
                         valida::convertir($mysqli,md5($_POST["psw"]),"text"));
    $q_login = mysqli_query($mysqli, $sql_login) or die(mysqli_error($mysqli));
    $r_login = mysqli_fetch_assoc($q_login);
    $t_login = mysqli_num_rows($q_login);
    
    

    if($t_login == 0){
        header("location:./?err");
    }else{
        $_SESSION["user"] = $r_login["usu_mail"]; 
        $_SESSION["nivel"] = $r_login["usu_nivel"];

        $sql_status = sprintf("UPDATE usuarios SET usu_status = 1 where usu_mail = %s",
                              valida::convertir($mysqli, $_POST["mail"], "text"));
        $q_status = mysqli_query($mysqli, $sql_status) or die ("error: ".mysqli_error($mysqli));

        header("location:./select.php");
    }
}

if(isset($_POST['registro'])){
    $codigo = md5(uniqid());
    $nombre = $_POST["regname"];
    $mail = $_POST["regmail"];
    $pass = $_POST["regpsw"];
    $reg = "";

    $sql_registro = sprintf("INSERT INTO usuarios (usu_mail, usu_pass, usu_nombre, usu_nivel, usu_vercod, usu_activo, usu_status, usu_change) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                            valida::convertir($mysqli, $mail, "text"),
                            valida::convertir($mysqli, md5($pass), "text"),
                            valida::convertir($mysqli, $nombre, "text"),
                            valida::convertir($mysqli, "estudiante", "text"),
                            valida::convertir($mysqli, $codigo, "text"),
                            valida::convertir($mysqli, 0, "int"),
                            valida::convertir($mysqli, 0, "int"),
                            valida::convertir($mysqli, 0, "int"));
    if($q_registro = mysqli_query($mysqli, $sql_registro)){
        
    }else{
        header("location:./?redu");
        exit;
    }

    if($q_registro){
        $reg = 1;
    }else{
        $reg = 0;
    }

    // Mandar mail por smtp del host
    $mailBody = "Registro en el Sistema de Aprendizaje Online\n\n";
    $mailBody .= "Para completar tu registro debes activar tu cuenta\n";
    $mailBody .= "ingresando al siguiente enlace\n";
    $mailBody .= "link: http://formacion-pu.online/activar.php?cod=$codigo";

    $mailAsunto = "Activación de tu cuenta en SAO";

    $headers =  'MIME-Version: 1.0' . "\r\n"; 
    $headers .= 'From: FPPTU <fpptu@formacion-pu.online.com>' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

    if(mail($mail,$mailAsunto,$mailBody)){ 
        $reg = 3; 
    }else{ 
        $reg = 2; 
    } 


    header("location:./index.php?reg=$reg");
}

if(isset($_POST["lost"])){

}

