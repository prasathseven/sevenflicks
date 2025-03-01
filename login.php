<?php
session_start();
include "db.php"; // Make sure this file has database connection ($conn)

// Get user input
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Prepare the query
$sql = "SELECT id, email, password, role FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Debugging logs (remove in production)
    error_log("Entered Email: " . $email);
    error_log("Stored Hashed Password: " . $user['password']);
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            echo json_encode(["status" => "success", "redirect" => "admin.html"]);
        } else {
            echo json_encode(["status" => "success", "redirect" => "home.html"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid password!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found!"]);
}

$stmt->close();
$conn->close();
?>
