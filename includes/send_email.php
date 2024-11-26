<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo($_ENV['SMTP_FROM']); // Debugging purposes; remove in production.

function sendRecommendationEmail($name, $skill, $phone, $recipient_email)
{
    // Build the HTML email
    $emailhtml = <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Creative Recommendation</title>
    </head>
    <body style="margin:0; padding:0; font-family: 'Arial', sans-serif; line-height: 1.6;">
        <table role="presentation" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td>
                    <table role="presentation" style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse;">
                        <tr>
                            <td style="background: linear-gradient(135deg, #4F46E5, #7C3AED); padding: 40px 30px; text-align: center;">
                                <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;">
                                    Creative Excellence
                                </h1>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #ffffff; padding: 40px 30px;">
                                <h2 style="color: #4F46E5; font-size: 24px;">Hello $name,</h2>
                                <p style="font-size: 16px; color: #374151;">
                                    You have been recommended as an amazing creative. This is <strong>Our Company</strong>, and we look forward to partnering with you on our upcoming projects.
                                </p>
                                <p style="font-size: 16px; color: #374151;">
                                    <em>Let's initiate culture.</em>
                                </p>
                                <table style="width: 100%; margin-bottom: 30px; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 20px; background-color: #F3F4F6; border-radius: 8px;">
                                            <h3 style="color: #4F46E5; font-size: 18px;">Contact Information</h3>
                                            <p style="font-size: 16px; color: #374151;"><strong>Phone:</strong> $phone</p>
                                            <p style="font-size: 16px; color: #374151;"><strong>Email:</strong> $recipient_email</p>
                                        </td>
                                    </tr>
                                </table>
                                <p style="font-size: 18px; color: #4F46E5; text-align: center; font-style: italic;">
                                    Big dreams manifest.
                                </p>
                                <p style="font-size: 20px; color: #374151; text-align: center; font-weight: bold;">
                                    Our Company
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #F3F4F6; padding: 30px; text-align: center;">
                                <p style="font-size: 14px; color: #687280;">&copy; 2024 Albert. All rights reserved.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
HTML;

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->SMTPAuth = true;

        // SMTP Configuration
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];
        $mail->Port = $_ENV['SMTP_PORT'];

        // SMTP Username and Password
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];

        // Recipients
        $mail->addAddress($recipient_email, $name);
        $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);

        // Email Content
        $mail->Subject = "$name, You've been Recommended as an Amazing Creative";
        $mail->Body = $emailhtml;

        if ($mail->send()) {
            echo "Email sent successfully";
        }
    } catch (Exception $e) {
        echo "Unable to send email: " . $mail->ErrorInfo;
    }
}
