<?php
session_start();
session_destroy(); // Destroy all active sessions
header("Location: index.php"); // Redirect to login page
exit();
?>
