<?php
require '../backend/config.php'; // Include your configuration file

// Check if user is logged in
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: ./login.php'); // Redirect to login if not authenticated
    exit;
}

// Fetch submissions with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 25;
$offset = ($page - 1) * $limit;

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Get submissions for current page
    $stmt = $pdo->prepare("SELECT id, fullname, nationality, countryofresidence, dob, email, organisation, position, events, visainvitation, assistance FROM registrations LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are more rows
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM registrations");
    $stmt->execute();
    $totalRows = $stmt->fetchColumn();
    $hasMore = $page * $limit < $totalRows;
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../CSS/dashboard.css">
</head>
<body>
<div class="container"> 
<fixed>
        <h1>Admin Dashboard</h1>
        <div id="submissions">
            <h2>Submissions</h2>
        </fixed>
            <table>
                <thead>
                    <tr>
                         <th>S/N</th>
                        <th>Full Name</th>
                        <th>Nationality</th>
                        <th>Country of Residence</th>
                        <th>Date of Birth</th>
                        <th>Email</th>
                        <th>Organisation</th>
                        <th>Position</th>
                        <th>Events</th>
                        <th>Visa Invitation</th>
                        <th>Assistance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($submission['id']); ?></td>
                        <td><?php echo htmlspecialchars($submission['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($submission['nationality']); ?></td>
                        <td><?php echo htmlspecialchars($submission['countryofresidence']); ?></td>
                        <td><?php echo htmlspecialchars($submission['dob']); ?></td>
                        <td><?php echo htmlspecialchars($submission['email']); ?></td>
                        <td><?php echo htmlspecialchars($submission['organisation']); ?></td>
                        <td><?php echo htmlspecialchars($submission['position']); ?></td>
                        <td><?php echo htmlspecialchars($submission['events']); ?></td>
                        <td><?php echo htmlspecialchars($submission['visainvitation']); ?></td>
                        <td><?php echo htmlspecialchars($submission['assistance']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <fixed>
            <div class="pagination">
                <button <?php if ($page <= 1) echo 'disabled'; ?> onclick="changePage(-1)">Previous</button>
                <span id="pageNumber">Page <?php echo htmlspecialchars($page); ?></span>
                <button <?php if (!$hasMore) echo 'disabled'; ?> onclick="changePage(1)">Next</button>
            </div>
            </fixed>
        </div>
        </div>  
    <script>
        function changePage(delta) {
            const newPage = <?php echo $page; ?> + delta;
            window.location.href = `index.php?page=${newPage}&limit=<?php echo $limit; ?>`;
        }
    </script>
</body>
</html>
