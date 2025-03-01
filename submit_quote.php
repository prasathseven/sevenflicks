<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
    exit;
}

// Validate required fields
if (!isset($_POST['name'], $_POST['email'], $_POST['details'])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
    exit;
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$details = trim($_POST['details']);

if (empty($name) || empty($email) || empty($details)) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

// Load PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;
    $mail->Username = '7sevenflicks@gmail.com'; 
    $mail->Password = 'ykes vort gnjk iqqv';  // Use App Password if 2FA is enabled
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Email Content
    $mail->setFrom($email, $name);
    $mail->addAddress('admin@sevenflicks.com', 'Admin');
    $mail->Subject = 'New Quote Request from ' . $name;
    $mail->Body = "Name: $name\nEmail: $email\nDetails: $details";

    $mail->send();

    echo json_encode(["status" => "success", "message" => "Your quote request has been sent!"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Mailer Error: " . $mail->ErrorInfo]);
}
?>
