<?php
if (isset($_GET["sec"])) {
    echo "<script> alerta('Error en login', 'Usuario no autorizado', 'error'); </script>";
}
if (isset($_GET["verif"])) {
    echo "<script> alerta('Error en login', 'Usuario no verificado', 'error'); </script>";
}
if (isset($_GET["err"])) {
    echo "<script> alerta('Error en login', 'Usuario no registrado o no verificado', 'error'); </script>";
}

if (isset($_GET["lvl"])) {
    if ($_GET["lvl"] === "estudiante") {
        echo "<script> alerta('Bienvenido', 'Exelente, Ahora ya puedes crear tus propios cursos', 'info'); </script>";
    }
}
if (isset($_GET["pok"])) {
    echo "<script> alerta('Exito', 'Exelente, se ha terminado de crear la evaluación', 'info'); </script>";
}
if (isset($_GET["redu"])) {
    echo "<script> alerta('Error', 'Usuario ya registrado', 'warning'); </script>";
}
if (isset($_GET["comok"])) {
    echo "<script> alerta('Exito', 'Su pago se ha realizado', 'success'); </script>";
}
if (isset($_GET["nota"])) {
    $puntaje = $_GET["nota"];
    $sobre = $_GET["n"];
    $msg = "Ha terminado la evaluación, su nota es de: ";
    $total = "$puntaje/10";
    $btntext = '';
    if ($puntaje >= round($sobre * 70 / 100)) {
        $btntext = 'Genial!';
    } else {
        $btntext = 'Rayos';
    }
    echo "<script> swalerta('Fin', '$msg','$total', 'info', '$btntext'); </script>";
}

if (isset($_GET["reg"])) {
    switch ($_GET["reg"]) {
        case 0:
            echo "<script> alerta('Error en registro', 'No se pudo registrar correctamente', 'error'); </script>";
            break;
        case 1:
            echo "<script> alerta('Registro exitoso', 'Revise su correo para confirmar su registro', 'success'); </script>";
            break;
        case 2:
            echo "<script> alerta('Error en registro', 'No se pudo enviar email de activación', 'error'); </script>";
            $sql_fail = sprintf(
                "DELETE FROM usuarios where usu_mail = %s",
                valida::convertir($mysqli, $mail, "text")
            );
            $q_fail = mysqli_query($mysqlo, $sql_fail);
            break;
        case 3:
            echo "<script> alerta('Registro exitoso', 'Revise su correo para confirmar su registro', 'success'); </script>";
            break;
    }
}


if (isset($_GET["cur"])) {
    switch ($_GET["cur"]) {
        case 0:
            echo ("<script>alerta('Error', 'El curso no se pudo crear', 'error')</script>");
            break;
        case 1:
            echo ("<script>alerta('Exito', 'El curso fue creado exitosamente', 'success')</script>");
            break;
    }
}

if (isset($_GET["ges"])) {
    switch ($_GET["ges"]) {
        case 0:
            echo ("<script>alerta('Aviso', 'El curso fue editado pero no se subieron documentos de apoyo o hubo un error al cargarlos', 'warning')</script>");
            break;
        case 1:
            echo ("<script>alerta('Exito', 'Los materiales del curso se subieron correctamente', 'success')</script>");
            break;
    }
}

if (isset($_GET["mat"])) {
    switch ($_GET["mat"]) {
        case 0:
            echo ("<script>alerta('Error', 'Ha ocurrido un error al momento de matricularse', 'error')</script>");
            break;
        case 1:
            echo ("<script>alerta('Exito', 'Se ha matriculado exitosamente', 'success')</script>");
            break;
    }
}

if (isset($_GET["succ"])) {
    switch ($_GET["succ"]) {
        case 0:
            echo ("<script>alerta('Error', 'Ha ocurrido un error al momento de crear la clase', 'error')</script>");
            break;
        case 1:
            echo ("<script>alerta('Exito', 'Se ha Creado la clase exitosamente', 'success')</script>");
            break;
        case 2:
            echo ("<script>alerta('Exito', 'Se ha Modificado la clase exitosamente', 'success')</script>");
            break;
    }
}

if (isset($_GET["foto"])) {
    switch ($_GET["foto"]) {
        case 0:
            echo ("<script>alerta('Error', 'Ha ocurrido un error al momento de guardar la foto', 'error')</script>");
            break;
        case 1:
            echo ("<script>alerta('Exito', 'Se ha guardado la foto exitosamente', 'success')</script>");
            break;
    }
}

if (isset($_GET["bio"])) {
    switch ($_GET["bio"]) {
        case 0:
            echo ("<script>alerta('Error', 'Ha ocurrido un error al momento de guardar la biografia', 'error')</script>");
            break;
        case 1:
            echo ("<script>alerta('Exito', 'Se ha actualizado la biografia', 'success')</script>");
            break;
    }
}
