<?php
function rename_win($oldfile,$newfile) {
    if (!rename($oldfile,$newfile)) {
        if (copy ($oldfile,$newfile)) {
            unlink($oldfile);
            return TRUE;
        }
        return FALSE;
    }
    return TRUE;
}

function generarCodigo($idProfe, $materia, $codigo){
    $cod = '';
    $materia = substr($materia, 0 ,3);
    $cod .= $idProfe.$materia.$codigo;
    return $cod;
}