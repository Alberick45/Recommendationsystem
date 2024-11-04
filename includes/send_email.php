<?php

require_once __DIR__. '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo($_ENV['SMTP_FROM']);
function sendRecommendationEmail($name,$skill,$phone,$recipient_email)
{

    $emailhtml = <<<HTML

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Creative Recommendation</title>
    </head>
    <body style="margin:0; padding:0; font-family: 'Ariel', sans-serif; line-height: 1.6;">
        <table role="presentation" style="width: 100%; brder-collapse: collapse;">
            <tr>
                <td style="padding;0;">
                    <table role="presentation" style="width: 100%; max-width: 600px; margin:0 auto; border-collapse: collapse;">
                        <!-- Header with gradient background -->

                        <tr>
                            <td style="background: Linear-gradient(135deg, #4F46E5, #7C3AED); padding: 40px 30px; text-align: center;">
                                <h1 style="color: #ffffff; margin: 0 ; font-size: 28px; font-weight:bold;">
                                    Creative Excellence
                                </h1>
                            </td>
                        </tr>

                        <!-- Main Content -->
                        <tr>
                            <td style="background-color: #ffffff; padding:40px 30px">
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">

                                    <tr>
                                        <td>
                                            <h2 style="color: #4F46E5; margin: 0 0 20px; font-size: 24px;">
                                                Hello $name,
                                            </h2>

                                            <p style = "margin:0 0 30px; font-size: 16px; color: #374151;">
                                                You have been recommended as an amazing 
                                                creative. This is <strong> Our company </strong> and we look forward to partnering with you on our
                                                upcoming projects.</p>

                                            <p style = "margin:0 0 px; font-size: 16px; color: #374151;">
                                                <em> Let's initiate culture</em>
                                            </p>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                        <table role="presentation" style="width: 100%;  margin-bottom:30px; border-collapse: collapse;">

                                        <tr>
                                        <td style="padding: 20px; background-color: #F3F4F6; border-radius:8px;">
                                            <h3 style="color: #4F46E5; margin: 0 0 15px; font-size: 18px;">
                                                Contact Information
                                            </h3>

                                            <p style = "margin:0 0 10px; font-size: 16px; color: #374151;">
                                                <strong> Phone:</strong> +233 20559 2716</p>

                                            <p style = "margin:0; font-size: 16px; color: #374151;">
                                                
                                                <strong> Email:</strong> recommendation@gmail.com
                                            </p>

                                        </td>
                                    </tr>

                                        </table>


                                        </td>
                                    </tr>


                                    <tr>
                                                        <td>
                                                            <p style = "margin:0; font-style: italic; font-size: 18px; color: #4F46E5; text-align:center;">
                                                                Big dreams manifest</p>

                                                            <p style = "margin:5px 0 0; font-weight: bold; font-size: 20px; color: #374151;  text-align:center;">
                                                                Our Company
                                                            </p>

                                                        </td>
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>

                                        <!-- Footer -->
                        <tr>
                            <td style="background-color: #F3F4F6; padding:30px; text-align: center;">
                                <p style = "margin:0; font-size: 14px; color: #687280;">&copy;
                                    2024 Albert. All rights reserved.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>   
            </tr>
        </table>
    </body>
    </html>
HTML;   

    $mail = new PHPMailer(true);

    $mail -> isSMTP();
    $mail -> isHTML(true);
    $mail ->SMTPAuth = true;

    //SMTP CONFIG
    $mail ->Host = $_ENV['SMTP_HOST'];
    $mail ->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];
    $mail ->Port = $_ENV['SMTP_PORT'];

    //SMTP USERNAME and PASSWORD
    $mail ->Username = $_ENV['SMTP_USERNAME'];
    $mail ->Password = $_ENV['SMTP_PASSWORD'];

    //Recipients
    $mail -> addAddress($recipient_email, $name);
    $mail -> setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);

    //Email Content
    $mail -> Subject = "$name, You've been Recommended as an Amazing Creative";
    $mail -> Body = $emailhtml;

    if($mail ->send()){
        echo "Email sent successfully";
    }
    else{
        echo "Unable to send email";
        echo "Error: ". $mail -> ErrorInfo;
    }
}