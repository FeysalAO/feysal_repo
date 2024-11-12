<?php
session_start();
include('db_connection.php');
include('nav.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT loyalty_points FROM customers WHERE cID='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty & Rewards - Riget Zoo Adventures</title>
    <link rel="stylesheet" href="rewards.css">
</head>
<body>
    <h2>Loyalty & Rewards</h2>
    <p>You have <strong><?php echo $user['loyalty_points']; ?></strong> loyalty points.</p>
    <p>Earn more points by booking zoo tickets and staying at the hotel!</p>
</body>
</html>
