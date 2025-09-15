<script>
    function abrir() {
        loginModal.style.display = 'block';
    }
</script>
<?php
//script para mostrar los productos
//$user = $_SESSION["user"];

$sql_mostrar = sprintf("SELECT cur_codigo, cur_nombre, b.id_profes, cur_img, cur_costo, cur_descri FROM curso a inner join profesor b on a.id_profes = b.id_profes ORDER BY cur_fecha DESC");

if (isset($_GET["id"])) {
    $categoria = $_GET['id'];
    $sql_mostrar = sprintf("SELECT * FROM curso a inner join profesor b on a.id_profes = b.id_profes inner join categorias c on a.id_catego = c.id_catego where c.id_catego = $categoria ORDER BY cur_fecha DESC");
} 

if (isset($_GET['q']) && $_GET['q'] != '') {
    $query = $_GET['q'];
    $sql_mostrar = "SELECT * FROM curso a inner join profesor b on a.id_profes = b.id_profes where cur_nombre like '%$query%'";
}

$q_mostrar = mysqli_query($mysqli, $sql_mostrar) or die("error: " . mysqli_error($mysqli));
$r_mostrar = mysqli_fetch_assoc($q_mostrar);

echo "<div class = 'container'>
        <div class='row'>";
if ($q_mostrar) {
    if ($t_mostrar = mysqli_num_rows($q_mostrar) != 0) {
        do {
            $titulo = $r_mostrar["cur_nombre"];
            $codigo = $r_mostrar["cur_codigo"];
            $idProfe = $r_mostrar["id_profes"];
            $precio = $r_mostrar['cur_costo'];

            if ($precio == 0) {
                $precio = "GRATIS";
            }else {
                $precio  = "$".$precio;
            }

            // Build short description safely (first 14 words)
            $curDescripcionRaw = trim((string)$r_mostrar["cur_descri"]);
            if ($curDescripcionRaw === '') {
                $curDescripcion = '';
            } else {
                $words = preg_split('/\s+/', $curDescripcionRaw);
                $take = array_slice($words, 0, 14);
                $curDescripcion = implode(' ', $take);
                if (count($words) > 14) {
                    $curDescripcion .= '...';
                }
            }




            $img = str_replace(" ", "_", $codigo . "." . $r_mostrar["cur_img"]);
            $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';

            //Numero de matriculas del curso
            $sql_nMatriculas = "SELECT COUNT(cur_codigo) as 'matriculas' FROM matricula where cur_codigo = '$codigo'";
            $q_nMatriculas = mysqli_query($mysqli, $sql_nMatriculas) or die(mysqli_error($mysqli));
            $r_nMatriculas = mysqli_fetch_assoc($q_nMatriculas);
            $nMatriculas = $r_nMatriculas['matriculas'];



            // if(isset($_SESSION['user'])){
            $sql_yamat = "select id_matric from matricula a inner join curso b on a.cur_codigo = b.cur_codigo where a.cur_codigo = '$codigo'";
            $q_yamat = mysqli_query($mysqli, $sql_yamat);

            $sql_authMatricula = "select * from matricula where usu_mail = '$user' and cur_codigo = '$codigo'";
            $q_authMatricula = mysqli_query($mysqli, $sql_authMatricula);
            $r_authMatricula = mysqli_fetch_assoc($q_authMatricula);
            $t_authMatricula = mysqli_num_rows($q_authMatricula);


            if (mysqli_num_rows($q_yamat) > 0 && $t_authMatricula > 0) {
                $add = "href = 'miscursos.php?cod=$codigo&idp=$idProfe&nomc=$titulo'";
            } else {
                $add = "href = 'cursos.php?cod=$codigo'";
            }


            //}else{
            //    $add="onclick= 'abrir()'";
            // }

            echo (sprintf(
                "
            <div class = 'col-lg-3 col-md-4 col-sm-6 thumb mx-2 px-0 bg-white mb-5 d-flex flex-column' >
            
                <a $add class = 'thumbnail' style='position:relative'>
                    <img src='./cursos/%s/%s/%s' class='img-fluid' alt='Logo del curso'>
                </a>
                <div class='container '>
                    <h4 class=''>%s</h4>
                    <p class='text-justify mb-3'>%s</p>
                    <span class='n-matriculas'><i class='fas fa-user'></i> %s</span>
                    <br class='mt-auto'>
                    
                </div>
                <a $add  class='btn btn-info my-3 w-50 mt-auto mx-3'>$precio</a>
                
            </div>
            ",
                $idProfe,
                $codigo,
                $img,
                $titulo,
                $curDescripcion,
                $nMatriculas
            ));
        } while ($r_mostrar = mysqli_fetch_assoc($q_mostrar));
    } else {
        echo "No hay cursos disponibles";
    }
}
echo "</div>
    </div>";
