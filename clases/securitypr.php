<?php
require_once('./clases/security.php');
//echo $_SESSION["nivel"];exit;
if($_SESSION["nivel"]!='profesor'){
    header("location:./?sec");
    exit;
}