<?php
require_once('./clases/security.php');
//echo $_SESSION["nivel"];exit;
if($_SESSION["nivel"]!='admin'){
    header("location:./?sec");
    exit;
}