<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/database.php';

function sendVerificationEmail($to, $code)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = EMAIL_USERNAME;
        $mail->Password   = EMAIL_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom(EMAIL_USERNAME, 'Dream Abode');
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Password Reset Verification Code';
        $mail->Body    = "Here is your verification code: <strong>$code</strong>";
        $mail->AltBody = "Here is your verification code: $code";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
