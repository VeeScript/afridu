<?php
require 'config.php';
require 'email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $fullName = $_POST['fullName'];
        $nationality = $_POST['nationality'];
        $countryOfResidence = $_POST['countryOfResidence'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $organisation = $_POST['organisation'];
        $position = $_POST['position'];
        $events = $_POST['events'];
        $visaInvitation = $_POST['visaInvitation'];
        $assistance = $_POST['assistance'];

        // Handle file upload
        $idPhoto = $_FILES['idPhoto']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES['idPhoto']['name']);
        move_uploaded_file($_FILES['idPhoto']['tmp_name'], $target_file);

        // Generate QR code (6 alphanumeric characters)
        $qrCode = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);

        // Insert data into database
        $stmt = $pdo->prepare("
            INSERT INTO registrations (
                fullName, nationality, countryOfResidence, dob, email, idPhoto, organisation, position, events, visaInvitation, assistance, qrCode
            ) VALUES (
                :fullName, :nationality, :countryOfResidence, :dob, :email, :idPhoto, :organisation, :position, :events, :visaInvitation, :assistance, :qrCode
            )
        ");
        $stmt->execute([
            ':fullName' => $fullName,
            ':nationality' => $nationality,
            ':countryOfResidence' => $countryOfResidence,
            ':dob' => $dob,
            ':email' => $email,
            ':idPhoto' => $idPhoto,
            ':organisation' => $organisation,
            ':position' => $position,
            ':events' => $events,
            ':visaInvitation' => $visaInvitation,
            ':assistance' => $assistance,
            ':qrCode' => $qrCode
        ]);

        // Send email with QR code
        sendEmail($email, $qrCode);

        echo '<script>alert("Registration successful... A confirmation email has been sent to you, kindly check for more details");
        window.location.href = "../index.html";</script>';
        } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
