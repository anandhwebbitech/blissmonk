<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['submit'])) {

    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $city  = trim($_POST['city']);

    // Validation
    if (empty($name) || empty($phone) || empty($email) || empty($city)) {
        echo "<script>alert('All fields are required.');history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid Email Address');history.back();</script>";
        exit;
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<script>alert('Phone number must be 10 digits');history.back();</script>";
        exit;
    }

    // ===============================
    // SETTINGS
    // ===============================

    $gmail = "kavinwebbitech@gmail.com";
    $appPassword = "knabwdnopxgupqea";

    $adminEmail = "info@blissmonktech.com";

    try {

        // ===============================
        // ADMIN EMAIL
        // ===============================

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = "smtp.gmail.com";
        $mail->SMTPAuth   = true;
        $mail->Username   = $gmail;
        $mail->Password   = $appPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($gmail, "Bliss Monk");
        $mail->addAddress($adminEmail);

        $mail->isHTML(true);
        $mail->Subject = "New Registration Received";

        $mail->Body = "
        <h2>New Registration</h2>

        <table border='1' cellpadding='8' cellspacing='0'>
            <tr>
                <th>Name</th>
                <td>{$name}</td>
            </tr>

            <tr>
                <th>Phone</th>
                <td>{$phone}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{$email}</td>
            </tr>

            <tr>
                <th>City</th>
                <td>{$city}</td>
            </tr>
        </table>
        ";

        $mail->send();


        // ===============================
        // USER EMAIL
        // ===============================

        $mail2 = new PHPMailer(true);

        $mail2->isSMTP();
        $mail2->Host       = "smtp.gmail.com";
        $mail2->SMTPAuth   = true;
        $mail2->Username   = $gmail;
        $mail2->Password   = $appPassword;
        $mail2->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail2->Port       = 587;

        $mail2->setFrom($gmail, "Bliss Monk");
        $mail2->addAddress($email, $name);

        $mail2->isHTML(true);
        $mail2->Subject = "Registration Successful";

        $mail2->Body = "
        <h2>Hello {$name},</h2>

        <p>Thank you for registering.</p>

        <p>We have received your details successfully.</p>

        <table border='1' cellpadding='8' cellspacing='0'>
            <tr>
                <th>Name</th>
                <td>{$name}</td>
            </tr>

            <tr>
                <th>Phone</th>
                <td>{$phone}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{$email}</td>
            </tr>

            <tr>
                <th>City</th>
                <td>{$city}</td>
            </tr>
        </table>

        <br>

        <p>Our team will contact you shortly.</p>

        <br>

        <strong>Thanks & Regards</strong><br>
        Bliss Monk
        ";

        $mail2->send();

        echo "<script>
                alert('Registration Successfully.');
                window.location='index.php';
              </script>";

    } catch (Exception $e) {

        echo "Mailer Error: " . $mail->ErrorInfo;

    }

} else {

    header("Location:index.php");
    exit;

}