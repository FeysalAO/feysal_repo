<?php
session_start();
session_unset();  // Unset session variables
session_destroy();  // Destroy the session
header("Location: main.php");  // Redirect to homepage
exit;
?>
