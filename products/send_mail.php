<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Adjusted for products folder

function sendEmail($toEmail, $toName, $subject, $bodyHTML) {
    $mail = new PHPMailer(true);

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yornsoyun@gmail.com';      // your Gmail
        $mail->Password   = 'gpvkevhhqksamxni';         // your Gmail app password
        $mail->SMTPSecure = 'tls'; // or 'ssl'
        $mail->Port       = 587;   // 465 for SSL

        // Sender and recipient
        $mail->setFrom('yornsoyun@gmail.com', 'Anxiety Coffee');
        $mail->addAddress($toEmail, $toName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $bodyHTML;
        $mail->AltBody = strip_tags($bodyHTML);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("PHPMailer error: " . $mail->ErrorInfo);
        return false;
    }
}
