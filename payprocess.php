<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("./clases/security.php");
require_once("./clases/valida.php");
require_once("./clases/conexion.php");

// Identify user and course code safely
$user = $_SESSION['user'] ?? 'guest';
$codi = $_GET['cur'] ?? ($_SESSION['cur'] ?? '');
if ($codi !== '') {
    $_SESSION['cur'] = $codi;
}

// Generate invoice/factura code deterministically for this user/session
$fa = "factura" . $user;
$codFac = md5($fa);

// PayPal configuration (adjust as needed)
$paypal_business = getenv('PAYPAL_BUSINESS') ?: 'test@example.com';
$paypal_currency = "USD";
$paypal_location = "EC";

// Build return/cancel URLs based on current host
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$paypal_returnurl = $scheme . "://" . $host . "/paydone.php?faco=" . urlencode($codFac) . "&cod=" . urlencode($codi);
$paypal_cancelurl = $scheme . "://" . $host . "/index.php";

// Select PayPal endpoint or fake flow
$mode = strtolower(getenv('PAYPAL_MODE') ?: 'sandbox');
if ($mode === 'fake') {
    $fake = $scheme . "://" . $host . "/paydone_fake.php?faco=" . urlencode($codFac) . "&cod=" . urlencode($codi);
    header("Location: $fake");
    exit;
}

$base = ($mode === 'live')
  ? 'https://www.paypal.com/cgi-bin/webscr'
  : 'https://www.sandbox.paypal.com/cgi-bin/webscr';

$ppurl = $base . "?cmd=_cart";
$ppurl .= "&business=" . urlencode($paypal_business);
$ppurl .= "&no_note=1";
$ppurl .= "&currency_code=" . urlencode($paypal_currency);
$ppurl .= "&charset=utf-8&rm=1&upload=1";
$ppurl .= "&return=" . urlencode($paypal_returnurl);
$ppurl .= "&cancel_return=" . urlencode($paypal_cancelurl);
$ppurl .= "&page_style=&paymentaction=sale&bn=katanapro_cart&invoice=KP-" . $codFac;

// Add cart items if present; otherwise, fallback to single item from DB by course code
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $i = 1;
    foreach ($_SESSION['cart'] as $c) {
        $q = $c["product_quantity"] ?? 1;
        $name = $c["product_name"] ?? ('Producto ' . $i);
        $price = $c["product_price"] ?? 0;
        $ppurl .= "&item_name_{$i}=" . urlencode($name)
               .  "&quantity_{$i}={$q}&amount_{$i}=" . $price . "&item_number_{$i}=";
        $i++;
    }
} elseif ($codi !== '') {
    // Query DB for course info
    $sql = sprintf("SELECT cur_nombre, cur_costo FROM curso WHERE cur_codigo = %s LIMIT 1",
        valida::convertir($mysqli, $codi, 'text')
    );
    if ($res = mysqli_query($mysqli, $sql)) {
        if ($row = mysqli_fetch_assoc($res)) {
            $name = $row['cur_nombre'] ?: ('Curso ' . $codi);
            $amount = is_numeric($row['cur_costo']) ? (float)$row['cur_costo'] : 0.0;
            if ($amount <= 0) {
                // Free course: redirect to fake done or index
                $done = $scheme . "://" . $host . "/paydone_fake.php?faco=" . urlencode($codFac) . "&cod=" . urlencode($codi);
                header("Location: $done");
                exit;
            }
            $ppurl .= "&item_name_1=" . urlencode($name) . "&quantity_1=1&amount_1=" . $amount . "&item_number_1=";
        }
    }
}

$ppurl .= "&tax_cart=0.00";

// Redirect to PayPal
header("Location: $ppurl");
exit;
?>
