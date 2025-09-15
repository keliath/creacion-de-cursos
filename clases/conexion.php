<?php
// Database connection using environment variables. Configure via docker-compose .env
// Expected env vars: DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT (optional)

$host = getenv('DB_HOST') ?: 'db';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$db   = getenv('DB_NAME') ?: 'app';
$port = getenv('DB_PORT') ?: 3306;

// Ensure timezone is set (can also set PHP_TZ env)
$tz = getenv('PHP_TZ');
if ($tz) {
    @date_default_timezone_set($tz);
}

$mysqli = mysqli_connect($host, $user, $pass, $db, (int)$port);

if (!$mysqli) {
    // Optionally log or handle the error without exposing details to users
    // error_log('DB connection failed: ' . mysqli_connect_error());
}
