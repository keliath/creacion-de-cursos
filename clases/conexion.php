<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pagina_robert";

$userO = "u170679010_fpptu";
$passO = "#q7L33RcVqR";
$dbO = "u170679010_fpptu";

$hol = 1;

date_default_timezone_get();
if($hol == 1){
    $mysqli = mysqli_connect($host, $userO, $passO, $dbO);
}else{
    $mysqli = mysqli_connect($host, $user, $pass, $db);
}


if(!$mysqli){
}