<?php
if(!isset($_SESSION)){
    session_start();
}
require_once("./clases/conexion.php");
require_once("./clases/valida.php");

if(isset($_POST["guardar"])){
	$sql_update = sprintf("UPDATE usuarios SET usu_nivel = 'profesor' where usu_mail = %s",
                          valida::convertir($mysqli, $_POST["mail"], "text"));
    $q_update = mysqli_query($mysqli, $sql_update) or die(mysqli_error($mysqli));

    $sql_upgrade = sprintf("select usu_nivel from usuarios where usu_mail = %s",
                           valida::convertir($mysqli, $_POST["mail"], "text"));
    $q_upgrade = mysqli_query($mysqli, $sql_upgrade) or die(mysqli_error($mysqli));
    $r_upgrade = mysqli_fetch_assoc($q_upgrade);
    
    $sql_profe = sprintf("insert into profesor (usu_mail) values (%s)",
                           valida::convertir($mysqli, $_POST["mail"], "text"));
    $q_profe = mysqli_query($mysqli, $sql_profe) or die(mysqli_error($mysqli));
	
	if($q_profe){
		header("location:./admin.php?regp=1");
	}else{
		header("location:./admin.php?regp=0");
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
		<title>Registro docente</title>
    </head>
    <body class="main bodymaestro">
		
        <?php
        include("./includes/header.php");
        include("./includes/menuad.php");
        ?>	

        <main>
           <div class="container">
               <div class="row">
                   <div class="col-md-12">
                       <h3>Registro de docentes</h3>
                       <hr>
					   <form action="" method="post">
						   <input type="text" name="mail" placeholder="Correo electronico">
						   <input type="submit" name="guardar" value="Guardar">
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