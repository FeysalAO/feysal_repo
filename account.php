<?php
session_start();
include('db_connection.php');
include('nav.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM customers WHERE cID='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $sql = "UPDATE customers SET password='$new_password' WHERE cID='$user_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Password updated successfully!";
    } else {
        echo "Error updating password: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management - Riget Zoo Adventures</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>
    <h2>Manage Your Account</h2>
    <p>Name: <?php echo $user['fname'] . ' ' . $user['lname']; ?></p>
    <p>Email: <?php echo $user['username']; ?></p>
    
    <h3>Change Password</h3>
    <form method="POST" action="account.php">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required><br><br>
        
        <input type="submit" value="Update Password">
    </form>
</body>
</html>
