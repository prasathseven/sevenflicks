<?php
session_start();
include "db.php"; // Ensure this file contains the database connection ($conn)

// Get user input
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$confirm_password = trim($_POST['confirm-password']);

// Validate passwords match
if ($password !== $confirm_password) {
    echo json_encode(["status" => "error", "message" => "Passwords do not match!"]);
    exit();
}

// Check if email already exists
$check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check_email->bind_param("s", $email);
$check_email->execute();
$check_email->store_result();

if ($check_email->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email already registered!"]);
    exit();
}

$check_email->close();

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Account created! Redirecting...", "redirect" => "login.html"]);
} else {
    echo json_encode(["status" => "error", "message" => "Signup failed! Try again."]);
}

$stmt->close();
$conn->close();
?>
