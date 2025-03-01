<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seven_flicks_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<div class='alert alert-danger text-center'>Database connection failed!</div>");
}

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo "<div class='alert alert-warning text-center'>Unauthorized access! Please log in.</div>";
    exit();
}

// Get booking details
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$event = $_POST['event'];
$date = $_POST['date'];
$service = $_POST['service'];
$style = $_POST['style'];
$user_id = $_SESSION["user_id"];

// Insert into database
$sql = "INSERT INTO bookings (user_id, name, phone, email, event_type, event_date, service_type, style) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssss", $user_id, $name, $phone, $email, $event, $date, $service, $style);

if ($stmt->execute()) {
    // Send Email to Admin
    $admin_email = "7sevenflicks@gmail.com";
    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '7sevenflicks@gmail.com';
        $mail->Password = 'ykes vort gnjk iqqv';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Details
        $mail->setFrom('7sevenflicks@gmail.com', 'Seven Flicks Photography');
        $mail->addAddress($admin_email);
        $mail->Subject = "New Booking Notification";
        $mail->Body = "New event booked:\n\n" .
                      "Name: $name\nPhone: $phone\nEmail: $email\nEvent: $event\n" .
                      "Date: $date\nService: $service\nStyle: $style\n\n" .
                      "Check the admin panel for details.";
        $mail->send();

        echo "<div class='container d-flex justify-content-center align-items-center vh-100'>
                <div class='alert alert-success text-center w-50'>
                    <h4>Booking Successful!</h4>
                    <p>Your booking has been confirmed. The admin has been notified.</p>
                    <a href='home.html' class='btn btn-primary'>Go to Home</a>
                </div>
              </div>";
    } catch (Exception $e) {
        echo "<div class='container d-flex justify-content-center align-items-center vh-100'>
                <div class='alert alert-warning text-center w-50'>
                    <h4>Booking Successful!</h4>
                    <p>Your booking was successful, but email notification failed.</p>
                    <p>Error: " . $mail->ErrorInfo . "</p>
                    <a href='home.html' class='btn btn-primary'>Go to Home</a>
                </div>
              </div>";
    }
} else {
    echo "<div class='container d-flex justify-content-center align-items-center vh-100'>
            <div class='alert alert-danger text-center w-50'>
                <h4>Booking Failed!</h4>
                <p>Something went wrong. Please try again.</p>
                <a href='book-session.html' class='btn btn-danger'>Try Again</a>
            </div>
          </div>";
}

$stmt->close();
$conn->close();
?>
