<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM registrations");
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($registrations);
?>
