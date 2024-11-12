<?php
session_start();
include('db_connection.php');
include('nav.php');

$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $first_name . ' ' . $last_name; ?>!</h1>
    <a href="logout.php">Logout</a>


    <section>
        <h2>Explore the Safari-Style Wildlife Zoo</h2>
        <p>Discover amazing wildlife, book your adventure, and enjoy our educational tours!</p>
    </section>
    <footer>
        <p>&copy; 2024 Riget Zoo Adventures. All rights reserved.</p>
    </footer>
</body>
</html>
