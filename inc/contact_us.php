<?php
// Load Composer's autoloader (if using Composer)
// require 'vendor/autoload.php';

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_form'])) {
    // Sanitize form inputs
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        echo '<p style="color: red;">جميع الحقول مطلوبة.</p>';
        exit;
    }

    if (!is_email($email)) {
        echo '<p style="color: red;">البريد الإلكتروني غير صالح.</p>';
        exit;
    }

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
        $mail->CharSet    = 'UTF-8'; // Set charset to UTF-8 for Arabic support

        // Recipients
        $mail->setFrom($email, 'Doctor Pluus'); // Sender email and name
        $mail->addAddress('info@doctorpluus.com'); // Recipient email

        // Email subject
        $main_title = 'رسالة جديدة من نموذج الاتصال';



        // Set email content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $main_title;
        $mail->Body    = $message;

        // Send the email
        $mail->send();
        echo '<p style="display: flex; align-items: center; background-color: #e0f7e0; color: #388e3c; padding: 10px; border-radius: 5px; font-size: 16px; font-weight: 600; width: 100%; max-width: 400px; margin: 20px auto;">
        <i class="fas fa-check-circle" style="margin-right: 10px; font-size: 20px;"></i>
        تم إرسال الرسالة بنجاح!
      </p>';

// الانتظار لمدة 5 ثوانٍ
sleep(5);

// التوجيه إلى الصفحة الرئيسية
wp_redirect(home_url());
exit;
    } catch (Exception $e) {

        wp_redirect(home_url('/post_creation_failed'));


    }
}