<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to homepage or login page
header("Location: home.html");
exit();
?>
