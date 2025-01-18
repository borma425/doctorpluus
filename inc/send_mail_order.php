<?php
// Load Composer's autoloader

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host       = 'mail.doctorpluus.com'; // Your SMTP server
    $mail->SMTPAuth   = true; // Enable SMTP authentication
    $mail->Username   = 'info@doctorpluus.com'; // SMTP username
    $mail->Password   = 'doctorpluus.com@smtpdata'; // SMTP password
    $mail->SMTPSecure = 'ssl'; // Enable SSL encryption
    $mail->Port       = 465; // TCP port to connect to
    $mail->CharSet = 'UTF-8';
    // Recipients
    $mail->setFrom('order@doctorpluus.com', 'doctorpluus');
    $mail->addAddress('info@doctorpluus.com'); // Add a recipient
$main_title = ' حجز مع د/ ' .  $doctor_name ;
    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = $main_title ;
    $mail->Body    = '
        <html>
        <head>
            <title>'.$main_title.'</title>
        </head>
        <body>
&nbsp;
'.$html_content.'
        </body>
        </html>
    ';

    // Send the email
    $mail->send();

} catch (Exception $e) {
    wp_redirect(home_url('/post_creation_failed'));

}