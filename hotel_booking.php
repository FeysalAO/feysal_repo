<?php
session_start();
include('db_connection.php');
include('nav.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_type = $_POST['room_type'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO hotel_bookings (customer_id, check_in, check_out, room_type) VALUES ('$user_id', '$check_in', '$check_out', '$room_type')";
    if (mysqli_query($conn, $sql)) {
        echo "Hotel booking successful!";
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
    <title>Hotel Booking - Riget Zoo Adventures</title>
    <link rel="stylesheet" href="hotel_booking.css">
</head>
<body>
    <h2>Book Your Stay at the On-Site Hotel</h2>
    <form method="POST" action="hotel_booking.php">
        <label for="check_in">Check-In Date:</label>
        <input type="date" id="check_in" name="check_in" required><br><br>
        
        <label for="check_out">Check-Out Date:</label>
        <input type="date" id="check_out" name="check_out" required><br><br>
        
        <label for="room_type">Room Type:</label>
        <select id="room_type" name="room_type">
            <option value="Standard">Standard</option>
            <option value="Deluxe">Deluxe</option>
            <option value="Suite">Suite</option>
        </select><br><br>
        
        <input type="submit" value="Book Hotel Stay">
    </form>
</body>
</html>
