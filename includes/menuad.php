<nav id='sidenav' class='sidenav'>
   <a href='javascript:void(0);' class='icon' id='icoa' onclick=''>
   <i class='fa fa-bars'></i>
    <a href='./admin.php'>Inicio</a>
    <a href='./registroprofe.php'>Registrar maestro</a>
    <a href='./clases/close.php'>Cerrar sesion</a>
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

