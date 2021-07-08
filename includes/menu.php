
<?php //script para mostrar un solo menu en todas las paginas

$sql_cat = sprintf("select * from categorias");
$q_cat = mysqli_query($mysqli, $sql_cat);
$r_cat = mysqli_fetch_assoc($q_cat);

$sql_cursos = sprintf("Select id_matric, cur_nombre from matricula a inner join curso b on a.cur_codigo = b.cur_codigo");
$q_cursos = mysqli_query($mysqli, $sql_cursos);
$t_cursos = mysqli_num_rows($q_cursos);
$r_cursos = mysqli_fetch_assoc($q_cursos);
if ($t_cursos != 0) {
    $r_cursos = mysqli_fetch_assoc($q_cursos);
}


if (isset($_SESSION['nivel'])) {
    $lvl = $_SESSION["nivel"];
    if ($_SESSION['nivel'] == 'profesor') { //condicion que verificara la variable 'nivel' para mostrar ciertas opciones si es admin o no
        echo "<nav class='navbar navbar-expand-lg navbar-dark navbar-custom sticky-top'>
    <a href='./'><img src='./images/logo.png' alt='logo academico' class='imgi'></a>
    <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>
    <div id='navbarNavDropdown' class='navbar-collapse collapse'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>
                    Cursos
                </a>
                <div class='dropdown-menu'>
                <a class='dropdown-item' href='./cursos.php'>Ver todos</a>";
        do {
            $id = $r_cat["id_catego"];
            $nombre = $r_cat["cat_catego"];
            echo "<a class='dropdown-item' href='./cursos.php?id=$id'>$nombre</a>";
        } while ($r_cat = mysqli_fetch_assoc($q_cat));

        echo " </div>
            </li>
            <form class='form-inline' action='cursos.php' style='margin:0px 10px;' method='get'>
                <input class='form-control mr-md-2' type='text' placeholder='Buscar' name='q'>
                <button class='btn btn-success' type='submit'><i class=fas fa-search></i> Buscar</button>
            </form>
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>
                    Mis cursos
                </a>
                <div class='dropdown-menu'>
                    <a class='dropdown-item' href='./todosmiscur.php'>Ver todos</a>";
        /*if ($t_cursos > 0) {
            do {
                $id = $r_cursos["id_matric"];
                $nombre = $r_cursos["cur_nombre"];
                echo "<a class='dropdown-item' href='./todosmiscur.php?id=$id'>$nombre</a>";
            } while ($r_cursos = mysqli_fetch_assoc($q_cursos));
        } else {
            echo "<a class='dropdown-item dropdown-item-nohover' href='#' >No hay cursos disponibles</a>";
        }*/
        echo " </div>
            </li>
         </ul>
        <ul class='navbar-nav'>
            <li class='nav-item'>
                <a class='nav-link' href='./profesor.php?lvl=";
        echo "$lvl";
        echo "'>Ser Maestro</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='./clases/close.php'>Cerrar Sesion</a>
            </li>
        </ul>
    </div>
</nav>";
    } else {
        echo "<nav class='navbar navbar-expand-lg navbar-dark navbar-custom sticky-top'>
    <a href='./'><img src='./images/logo.png' alt='logo academico' class='imgi'></a>
    <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>
    <div id='navbarNavDropdown' class='navbar-collapse collapse'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>
                Cursos
                </a>
                <div class='dropdown-menu'>
                <a class='dropdown-item' href='./cursos.php'>Ver todos</a>";
        do {
            $id = $r_cat["id_catego"];
            $nombre = $r_cat["cat_catego"];
            echo "<a class='dropdown-item' href='./cursos.php?id=$id'>$nombre</a>";
        } while ($r_cat = mysqli_fetch_assoc($q_cat));

        echo " </div>
            </li>
            <form class='form-inline' action='cursos.php' style='margin:0px 10px;' method='get'>
                <input class='form-control mr-md-2' type='text' placeholder='Buscar' name='q'>
                <button class='btn btn-success' type='submit'>Buscar</button>
            </form>
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>
                    Mis cursos
                </a>
                <div class='dropdown-menu'>
                    <a class='dropdown-item' href='./todosmiscur.php'>Ver todos</a>";
        /*if ($t_cursos > 0) {
            do {
                $id = $r_cursos["id_matric"];
                $nombre = $r_cursos["cur_nombre"];
                echo "<a class='dropdown-item' href='./todosmiscur.php?id=$id'>$nombre</a>";
            } while ($r_cursos = mysqli_fetch_assoc($q_cursos));
        } else {
            echo "<a class='dropdown-item dropdown-item-nohover' href='#' >No hay cursos disponibles</a>";
        }*/

        echo " </div>
            </li>
         </ul>
        <ul class='navbar-nav'>
            <li class='nav-item'>
                <a class='nav-link' href='./clases/close.php'>Cerrar Sesion</a>
            </li>
        </ul>
    </div>
</nav>";
    }
} else {
    echo "<nav class='navbar navbar-expand-md navbar-dark navbar-custom sticky-top' style='z-index: 100;'>
    <a class='navbar-brand' href='./'><img src='./images/logo.png' alt='logo academico' class='imgi'></a>
    <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>
    <div id='navbarNavDropdown' class='navbar-collapse collapse'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>
                Cursos 
                </a>
                
                <div class='dropdown-menu'>
                <a class='dropdown-item' href='./cursos.php'>Ver todos</a>";
    do {
        $id = $r_cat["id_catego"];
        $nombre = $r_cat["cat_catego"];
        echo "<a class='dropdown-item' href='./cursos.php?id=$id'>$nombre</a>";
    } while ($r_cat = mysqli_fetch_assoc($q_cat));

    echo " </div>
            </li>
            <form class='form-inline' action='cursos.php' style='margin-left:10px;' method='get'>
                <input class='form-control mr-md-2' type='text' placeholder='Buscar' name='q'>
                <button class='btn btn-success' type='submit'>Buscar</button>
            </form>
         </ul>
        <ul class='navbar-nav'>
            <li class='nav-item'>
                <a class='nav-link' href='javascript:void(0)' id='login'>Iniciar Sesion</a>
            </li>
        </ul>
    </div>
</nav>";
}
?>


