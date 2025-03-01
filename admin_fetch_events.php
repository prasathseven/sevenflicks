<?php
session_start(); // Start the session
require 'config.php'; // Ensure this contains database connection

// Debugging: Check if session is set
if (!isset($_SESSION["admin_id"])) {
    die(json_encode(["status" => "error", "message" => "Unauthorized access! Please log in again."]));
}

// Fetch events
$sql = "SELECT id, event_name, event_date, status FROM events";
$result = $conn->query($sql);

if (!$result) {
    die(json_encode(["status" => "error", "message" => "Database error: " . $conn->error]));
}

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode(["status" => "success", "events" => $events]);
$conn->close();
?>
