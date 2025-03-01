<?php
require 'config.php';

$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['email']}</td>
            <td>{$row['event_type']}</td>
            <td>{$row['event_date']}</td>
            <td>
                <button class='btn btn-danger' onclick='deleteBooking({$row['id']})'>Delete</button>
            </td>
          </tr>";
}
$conn->close();
?>
