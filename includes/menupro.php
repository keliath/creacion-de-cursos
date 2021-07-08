<nav id='sidenav' class='sidenav'>
   <a href='javascript:void(0);' class='icon' id='icoa' onclick=''>
   <i class='fa fa-bars'></i>
    <a href='./profesor.php'>Inicio</a>
    <a href='./profesor-perfil.php'>Perfil</a>
    <a href='./newcur.php'>Crear Curso</a>
    <a href='./gestcur.php'>Gestionar Curso</a>
    <a href="./">Pagina Principal</a>
</nav>

<script>
    var icoa = document.getElementById('icoa');
    var men = document.getElementById('sidenav');
    icoa.onclick = function(){
        if(men.className === "sidenav"){
            men.className += ' sidenavresponsive';
            document.body.className += ' mainresponsive'
        }else{
            men.className = 'sidenav';
            document.body.className = 'main'
        }
    }
</script>

