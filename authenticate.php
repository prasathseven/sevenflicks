<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seven_flicks_db";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed!"]));
}

// Read JSON data from frontend
$data = json_decode(file_get_contents("php://input"), true);
$user = $data['username'];
$pass = $data['password'];

// Fetch user from database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Check if admin
    if ($row["role"] === "admin" && $pass === $row["password"]) {
        $_SESSION["isAdmin"] = true;
        $_SESSION["username"] = $row["username"];
        
        echo json_encode([
            "status" => "success",
            "role" => "admin",
            "message" => "Admin login successful!"
        ]);
    }
    // Check if normal user
    else if ($row["role"] === "user" && $pass === $row["password"]) {
        $_SESSION["isUser"] = true;
        $_SESSION["username"] = $row["username"];

        echo json_encode([
            "status" => "success",
            "role" => "user",
            "message" => "User login successful!"
        ]);
    } 
    else {
        echo json_encode(["status" => "error", "message" => "Invalid password!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found!"]);
}

$stmt->close();
$conn->close();
?>

// book

<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "seven_flicks_db";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed!"]));
}

// Read JSON data from frontend
$data = json_decode(file_get_contents("php://input"), true);
$user = $data['username'];
$pass = $data['password'];

// Fetch user from database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($pass === $row["password"]) {  
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];

        echo json_encode([
            "status" => "success",
            "role" => $row["role"],
            "message" => "Login successful!",
            "user_id" => $row["id"]
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid password!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found!"]);
}

$stmt->close();
$conn->close();
?>


<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "seven_flicks_db";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed!"]));
}

// Get data from form submission
$user = $_POST['username'];
$pass = $_POST['password'];

// Fetch user from database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Check password (No hashing used)
    if ($pass === $row["password"]) {
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"]; // Store role (admin/user)

        // Set localStorage using JavaScript in PHP
        echo "<script>
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('username', '{$row['username']}');
                window.location.href = 'book-session.php';
            </script>";
    } else {
        echo "<script>alert('Invalid password!'); window.location.href = 'login.html';</script>";
    }
} else {
    echo "<script>alert('User not found!'); window.location.href = 'login.html';</script>";
}

$stmt->close();
$conn->close();
?>
