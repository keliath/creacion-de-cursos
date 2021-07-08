<?php  //script para mostrar los productos
require_once("./clases/conexion.php");

$user = $_SESSION["user"];
$sql_profe = sprintf("select id_profes from usuarios a inner join profesor b on a.usu_mail = b.usu_mail where a.usu_mail = %s",
                     valida::convertir($mysqli, $user, "text"));
$q_profe = mysqli_query($mysqli, $sql_profe);
$r_profe = mysqli_fetch_assoc($q_profe);
$idProfe = $r_profe["id_profes"];

$sql_mostrar = sprintf("SELECT * FROM curso a inner join profesor b on a.id_profes = b.id_profes where b.id_profes = %s ORDER BY cur_fecha DESC",
                       valida::convertir($mysqli, $idProfe, "text"));
$q_mostrar = mysqli_query($mysqli, $sql_mostrar) or die("error: ".mysqli_error($mysqli));
$r_mostrar = mysqli_fetch_assoc($q_mostrar);

echo "<div class = 'container'>
        <div class='row'>";
if($q_mostrar){ 
    if($t_mostrar = mysqli_num_rows($q_mostrar) != 0){
        do{
            $titulo = $r_mostrar["cur_nombre"];
            $codigo = $r_mostrar["cur_codigo"];
            $img = str_replace(" ", "_", $codigo. "." .$r_mostrar["cur_img"]); 
            echo (sprintf("
            <div class = 'col-lg-3 col-md-4 col-sm-6 thumb'>
            <b class=''>%s</b>
            <a href = 'gestcur.php?gest=%s' class = 'thumbnail'><img src='./cursos/%s/%s/%s' class='img-thumbnail img-fluid' alt='Logo del curso'></a>
            </div>
            ",
                          $titulo,
                          $codigo,
                          $idProfe,
                          $codigo,
                          $img));
        }
        while($r_mostrar = mysqli_fetch_assoc($q_mostrar));
    }else{
        echo "Cree cursos para visualizarlos aqui";
    }
}
echo "</div>
    </div>";