<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Adjust the path to your Composer autoload

function sendInvoiceEmail($toEmail, $toName, $subject, $bodyHtml) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';    // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'yornsoyun@gmail.com'; // Your SMTP username
        $mail->Password = 'gpvkevhhqksamxni';          // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Or PHPMailer::ENCRYPTION_SMTPS
        $mail->Port = 587; // SMTP port (often 587 or 465)

        // Recipients
        $mail->setFrom('yornsoyun@gmail.com', 'Anxiety Coffee');
        $mail->addAddress($toEmail, $toName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $bodyHtml;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Invoice email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        return false;
    }
}
