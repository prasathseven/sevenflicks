<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "seven_flicks_db";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed!");
}

// Fetch latest bookings
$sql = "SELECT * FROM bookings ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>".$row["name"]."</strong> booked <strong>".$row["event"]."</strong> on ".$row["date"].".</p>";
    }
} else {
    echo "<p>No new bookings.</p>";
}

$conn->close();
?>
