<?php
session_start();
$hostname = "localhost";
$username = "tlevel_feysal";
$password = "Feysal@199";
$dbname = "tlevel_feysal";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch loyalty points if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $userID = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT loyalty_points FROM customers WHERE cID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($loyalty_points);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Please log in to view your loyalty points.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Program</title>
    <link rel="stylesheet" href="loyalty.css">
</head>
<body>

<h2>Your Loyalty Points: <?php echo $loyalty_points; ?></h2>

<p>You can redeem 20 points for a 10% discount or 50 points for a free ticket or room!</p>

</body>
</html>
