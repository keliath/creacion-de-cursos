<?php

$archivo;

if (isset($_POST['idProfe'])) {
    $archivo = glob("./temp/".$_POST['idProfe']."/*");
}else{
    $archivo = glob("./temp/".$_POST['idProfe']."/*");
}


foreach ($archivo as $archivo) {
    if(is_file($archivo))
    unlink($archivo); //elimino el fichero
}