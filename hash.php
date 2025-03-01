<?php
include "db.php"; 

$admin_email = "admin@example.com";
$hashed_password = password_hash("Admin@123", PASSWORD_DEFAULT);
$role = "admin";

$sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $admin_email, $hashed_password, $role);
$stmt->execute();
$stmt->close();
$conn->close();

echo "Admin account created successfully!";
?>
