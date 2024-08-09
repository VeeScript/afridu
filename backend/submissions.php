<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    http_response_code(403);
    die(json_encode(['error' => 'Unauthorized']));
}

$dsn = "pgsql:host=localhost;port=5432;dbname=your_database_name;";
$pdo = new PDO($dsn, "your_user", "your_password", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 25;
$offset = ($page - 1) * $limit;

try {
    $stmt = $pdo->prepare("SELECT full_name, nationality, country, dob, email, organisation, position, events, visa, assistance FROM registrations LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are more rows
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM registrations");
    $stmt->execute();
    $totalRows = $stmt->fetchColumn();
    $hasMore = $page * $limit < $totalRows;

    echo json_encode(['submissions' => $submissions, 'hasMore' => $hasMore]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
