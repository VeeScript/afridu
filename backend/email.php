<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

require '../vendor/autoload.php';
require 'config.php';

function sendEmail($to, $qrCode) {
    global $smtpHost, $smtpUser, $smtpPass, $smtpPort;

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = 'tls';
        $mail->Port = $smtpPort;

        // Recipients
        $mail->setFrom('kennygheey@gmail.com', 'International Gathering');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Registration Confirmation';
        $mail->Body    = "
            <html>
            <body>
                <h1>Registration Successful</h1>
                <p>Your registration for the International Gathering in Honor of the Africans in Diaspora 6th Region is successful. Here is your QR code:</p>
                <img src='cid:qrCodeImage' alt='QR Code'>
                <h2>{$qrCode}</h2>
            </body>
            </html>
        ";

        // Attach QR Code image
        $mail->addStringEmbeddedImage(generateQRCodeImage($qrCode), 'qrCodeImage', 'qrCode.png');

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function generateQRCodeImage($qrCode) {
    $qrCodeObj = new QrCode($qrCode);
    $writer = new PngWriter();
    $result = $writer->write($qrCodeObj);
    return $result->getString();
}
?>
