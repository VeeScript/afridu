<?php
require 'config.php';

try {
    $fullName = 'John Doe';
    $nationality = 'Nigerian';
    $countryOfResidence = 'Nigeria';
    $dob = '1990-01-01';
    $email = 'john.doe@example.com';
    $idPhoto = 'photo.jpg';
    $organisation = 'Company XYZ';
    $position = 'Manager';
    $events = 'Event 1, Event 2';
    $visaInvitation = 'Yes';
    $assistance = 'None';
    $qrCode = 'ABC123';

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

    echo "Test insertion successful. Your QR Code: " . $qrCode;
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
