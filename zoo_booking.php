<?php
session_start();
include('db_connection.php');
include('nav.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_date = $_POST['booking_date'];
    $num_tickets = $_POST['num_tickets'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO zoo_bookings (customer_id, booking_date, num_tickets) VALUES ('$user_id', '$booking_date', '$num_tickets')";
    if (mysqli_query($conn, $sql)) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Booking - Riget Zoo Adventures</title>
    <link rel="stylesheet" href="zoo_booking.css">
</head>
<body>
    <h2>Book Your Zoo Adventure</h2>
    <form method="POST" action="zoo_booking.php">
        <label for="booking_date">Choose a Date:</label>
        <input type="date" id="booking_date" name="booking_date" required><br><br>
        
        <label for="num_tickets">Number of Tickets:</label>
        <input type="number" id="num_tickets" name="num_tickets" required min="1"><br><br>
        
        <input type="submit" value="Book Tickets">
    </form>
</body>
</html>
