 <?php
session_start();
if (isset($_SESSION['loggedin'])) {
    echo "Welcome, " . $_SESSION['first_name'] . "!";
}
?>

<?php
$hostname = "localhost";
$username = "tlevel_feysal";
$password = "Feysal@199";
$dbname = "tlevel_feysal";

// Establishing the connection
$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling the check availability functionality
$available_rooms = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check_availability'])) {
    $room_type = $_POST['room_type'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Current date
    $today = date('Y-m-d');
    // Check that check-in is today or in the future
    if ($check_in < $today) {
        echo "Invalid check-in date. Please select a date starting from today.";
    } elseif ($check_out <= $check_in) {
        echo "Check-out date must be after the check-in date.";
    }

    // Query to check availability
    $query = "SELECT COUNT(*) AS available_rooms FROM hotel_bookings WHERE room_type = ? AND ((check_in <= ? AND check_out >= ?) OR (check_in >= ? AND check_out <= ?))";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $room_type, $check_in, $check_in, $check_out, $check_out);
    $stmt->execute();
    $stmt->bind_result($available_rooms_count);
    $stmt->fetch();
    $stmt->close();

    $total_rooms_available = 10;  // Assuming 10 rooms available for each room type
    $available_rooms = $total_rooms_available - $available_rooms_count;

    if ($available_rooms > 0) {
        $message = "Rooms are available! You can proceed with booking.";
    } else {
        $message = "No rooms available for the selected dates. Please choose different dates.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking | Riget Zoo Adventures</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Custom CSS -->
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <ul>
        <li><a href="main.php">Home</a></li>
        <li><a href="attractions.php">Attractions</a></li>
        <li><a href="tickets.php">Book Tickets</a></li>
        <!-- Add Login and Register links -->
        <?php
        if (!isset($_SESSION['loggedin'])) {
            echo '<li style="float:right"><a href="login.php">Login</a></li>';
            echo '<li><a href="register.php">Register</a></li>';
        } else {
            echo '<li style="float:right"><a href="logout.php">Logout (' . $_SESSION['first_name'] . ')</a></li>';
            echo '<li><a href="loyalty.php">Loyalty Program</a></li>';
        }
        ?>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</nav>

<!-- Hotel Information -->
<section class="hotel-info">
    <div class="hero-image">
        <h1>Stay at Riget Zoo Adventures Hotel</h1>
        <p>Relax and enjoy a comfortable stay at our on-site hotel. Our spacious rooms offer modern amenities and a perfect view of the zoo's safari-style wildlife attractions.</p>
        <p>Whether you're here for a family vacation, an educational trip, or a romantic getaway, we have something for everyone!</p>
    </div>
</section>

<!-- Room Availability Form -->
<section class="room-availability">
    <h2>Check Availability</h2>
    <form action="hotel.php" method="POST">
        <label for="check_in">Check-In Date:</label>
        <input type="date" id="check-in" name="check_in" min="<?php echo date('Y-m-d'); ?>"  required>

        <label for="check_out">Check-Out Date:</label>
        <input type="date" id="check-out" name="check_out" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>

        <label for="rooms">Room Type:</label>
        <select id="rooms" name="room_type" required>
            <option value="single">Single Room</option>
            <option value="double">Double Room</option>
            <option value="family">Family Room</option>
        </select>

        <button type="submit" name = "check_availability" class="btn btn-primary">Check Availability</button>
    </form>
    <!-- Message after availability check -->
<?php if ($available_rooms !== null): ?>
    <div class="message">
        <p><?php echo $message; ?></p>
        <?php if ($available_rooms > 0): ?>
            <p>We have <?php echo $available_rooms; ?> rooms available for your selected dates.</p>
            <br>
                <a class="btn btn-primary" href="hotel_bookings.php">Proceed with Booking</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
</section>

<!-- CTA Section -->
<section class="cta">
    <h2>Book Your Stay Now!</h2>
    <p>Our rooms fill up fast, especially during peak season. Don't miss out—reserve your spot today!</p>
    <br>
    <a href="hotel_bookings.php" class="btn btn-primary">Book Your Room</a>
</section>

<!-- Footer -->
<footer>
    <div>
        <p>&copy; 2024 Riget Zoo Adventures. All Rights Reserved.</p>
    </div>
    <div>
        <ul>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Follow us on Social Media</a></li>
        </ul>
    </div>
</footer>

</body>
</html>


