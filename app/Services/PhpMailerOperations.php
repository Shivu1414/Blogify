<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PhpMailerOperations
{
    public static function sendOtp($email, $otp)
    {
        try {

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
            $mail->Port       = env('MAIL_PORT', 587);

            $mail->setFrom(
                env('MAIL_FROM_ADDRESS'),
                env('MAIL_FROM_NAME')
            );

            $mail->addAddress($email);

            $mail->isHTML(true);

            $mail->Subject = 'Password Reset OTP';

            $mail->Body = "
                <div style='font-family: Arial, sans-serif'>
                    <h2>Password Reset Request</h2>
                    <p>Your OTP for password reset is:</p>

                    <h1 style='color:#2563eb'>{$otp}</h1>

                    <p>This OTP is valid for 5 minutes.</p>

                    <p>If you did not request this, please ignore this email.</p>
                </div>
            ";

            $mail->send();

            return [
                'status' => true,
                'message' => 'OTP sent successfully'
            ];

        } catch (Exception $e) {

            return [
                'status' => false,
                'message' => $mail->ErrorInfo
            ];
        }
    }
}