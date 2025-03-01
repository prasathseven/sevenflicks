<?php
require 'config.php';

$id = $_POST['id'];
$sql = "DELETE FROM events WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$conn->close();
?>
