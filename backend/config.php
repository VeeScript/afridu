<?php
$host = 'postgresql://root:DRgkomzpSFEjRtA2vZ37MlDnJ9uIzpex@dpg-cqqlsbaj1k6c73dk1n7g-a/afridu';
$db = 'afridu'; // e.g., mydatabase
$user = 'root'; // e.g., doadmin
$pass = 'DRgkomzpSFEjRtA2vZ37MlDnJ9uIzpex'; // the password you set for the user
$port = '5432'; // e.g., 25060 (default PostgreSQL port is 5432, but DigitalOcean uses a different port)

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// SMTP configuration for PHPMailer
$smtpHost = 'smtp.gmail.com'; // Your SMTP host
$smtpUser = 'kennygheey@gmail.com'; // Your SMTP username
$smtpPass = 'cqdd wfev rgel mnue'; // Your SMTP password
$smtpPort = 587; // Or 465 for SSL
?>
