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
        $mail->Body    = "<div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4; color: #333;'>
                                <div style='max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                                    <h2 style='color: #2c3e50;'>Dream Abode - Password Reset</h2>
                                    <p style='font-size: 16px;'>Hi there,</p>
                                    <p style='font-size: 16px;'>We received a request to reset your password. Use the verification code below to complete the process:</p>
                                    <div style='text-align: center; margin: 30px 0;'>
                                        <span style='display: inline-block; background-color: #2c3e50; color: #ffffff; font-size: 24px; padding: 12px 20px; border-radius: 5px; letter-spacing: 2px;'>$code</span>
                                    </div>
                                    <p style='font-size: 14px; color: #777;'>If you didn’t request this, you can safely ignore this email.</p>
                                    <p style='font-size: 14px;'>Thanks,<br>The Dream Abode Team</p>
                                </div>
                            </div>
                          ";

        $mail->AltBody = "Hi there,\n\nWe received a request to reset your password. Your verification code is: $code\n\nIf you didn’t request this, you can ignore this email.\n\nThanks,\nDream Abode Team";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
