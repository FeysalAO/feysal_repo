<?php
// Database configuration
$servername = "localhost"; // or the name of your server (e.g., 127.0.0.1)
$username = "tlevel_feysal";        // your MySQL username
$password = "Feysal@199";            // your MySQL password (leave empty if no password)
$dbname = "tlevel_feysal"; // the name of your database

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

