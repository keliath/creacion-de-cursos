<?php
if(!isset($_SESSION)){
    session_start();
}

require_once("./clases/security.php");
require_once("./clases/valida.php");
require_once("./clases/conexion.php");

    

    $fa = "factura" . $user;
    $codFac = md5($fa);
    $codi = $_SESSION["cur"];

	$paypal_business = "kevinnar10@homail.com";
	$paypal_currency = "USD";
	$paypal_cursymbol = "&usd";
	$paypal_location = "EC";
	$paypal_returnurl = "http://sao.proyectsistemas.com/paydone.php?faco=$codFac&?cur=$codi";
	$paypal_returntxt = "Pago Realizado Exitosamente!";
	$paypal_cancelurl = "http://sao.proyectsistemas.com/index.php";

	
	$ppurl = "https://www.paypal.com/cgi-bin/webscr?cmd=_cart";
	$ppurl .= "&business=".$paypal_business;
	$ppurl .= "&no_note=1";
	$ppurl .= "&currency_code=".$paypal_currency;
	$ppurl .= "&charset=utf-8&rm=1&upload=1";
	$ppurl .= "&business=".$paypal_business;
	$ppurl .= "&return=".urlencode($paypal_returnurl);
	$ppurl .= "&cancel_return=".urlencode($paypal_cancelurl);
	$ppurl .= "&page_style=&paymentaction=sale&bn=katanapro_cart&invoice=KP-$b[1]";
//	echo $ppurl;
	$i=1;
	foreach ($_SESSION["cart"] as $c) {
		$q = $c["product_quantity"];
		$ppurl.="&item_name_$i=".urlencode($c["product_name"])."&quantity_$i=$q&amount_$i=".$c["product_price"]."&item_number_$i=";
		$i++;

	}

	$ppurl.= "&tax_cart=0.00";

//	echo urldecode("http%3A%2F%2Flocalhost%2Fwp%2Fcheckout%2Forder-received%2F76%3Fkey%3Dwc_order_567671a554da3%26%23038%3Butm_nooverride%3D1");
//	$ppurl .= "&business=".$paypal_business;
//unset($_SESSION["cart"]);
header("Location: $ppurl");
//	Core::redir($ppurl);


?>