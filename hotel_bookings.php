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

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "You are not logged in. Please <a href='login.php'>login</a> to book a hotel room.";
    exit();
}

// Room prices
$single_room_price = 50;  // Price for single room per night
$double_room_price = 90;  // Price for double room per night
$family_room_price = 150; // Price for family room per night (accommodates more people)


// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_type = $_POST['room_type'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_quantity = $_POST['room_quantity'];

     // Current date
     $today = date('Y-m-d');
    // Check that check-in is today or in the future
    if ($check_in < $today) {
        echo "Invalid check-in date. Please select a date starting from today.";
    } elseif ($check_out <= $check_in) {
        echo "Check-out date must be after the check-in date.";
    }

    // Calculate the number of nights
    $check_in_date = new DateTime($check_in);
    $check_out_date = new DateTime($check_out);
    $interval = $check_in_date->diff($check_out_date);
    $num_nights = $interval->days;

    // Calculate the total price based on room type
    switch ($room_type) {
        case 'single':
            $total_price = $num_nights * $single_room_price * $room_quantity;
            break;
        case 'double':
            $total_price = $num_nights * $double_room_price * $room_quantity;
            break;
        case 'family':
            $total_price = $num_nights * $family_room_price * $room_quantity;
            break;
        default:
            echo "Invalid room type selected.";
            exit();
    }

    // Apply 10% discount if booking more than one room
    if ($room_quantity > 1) {
        $total_price *= 0.9;  // 10% discount
    }

    // Check if user has loyalty points for discounts
    $user_id = $_SESSION['user_id'];
    $query = "SELECT loyalty_points FROM customers WHERE cID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($loyalty_points);
    $stmt->fetch();
    $stmt->close();

    // Loyalty points discount logic
    if ($loyalty_points >= 20 && $loyalty_points < 50) {
        echo "<p>You have enough loyalty points to apply a 10% discount!</p>";
        $total_price *= 0.9;  // Apply 10% discount for 20+ points
    } elseif ($loyalty_points >= 50) {
        echo "<p>You have enough loyalty points for a free room! Total price is now 0.</p>";
        $total_price = 0;  // Free room for 50+ points
    }

    // Store booking in database
    $stmt = $conn->prepare("INSERT INTO hotel_bookings (customer_id, room_type, check_in, check_out, num_nights, room_quantity, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiii", $user_id, $room_type, $check_in, $check_out, $num_nights, $room_quantity, $total_price);
    if ($stmt->execute()) {
        echo "<p>Booking successful! Total cost: £$total_price</p>";
        // Update loyalty points
        $new_points = $loyalty_points + 20; // Award 20 points per booking
        $update_query = "UPDATE customers SET loyalty_points = ? WHERE cID = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ii", $new_points, $user_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        echo "<p>Error: Could not complete booking.</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hotel Room - Riget Zoo Adventures</title>
    <link rel="stylesheet" href="hotel.css">
</head>
<body>

<h2>Book Your Hotel Room</h2>
<form method="POST" action="hotel_bookings.php">
    <label for="room_type">Room Type:</label>
    <select id="room_type" name="room_type" required>
        <option value="single">Single Room</option>
        <option value="double">Double Room</option>
        <option value="family">Family Room</option>
    </select><br>

    <label for="check_in">Check-in Date:</label>
    <input type="date" id="check_in" name="check_in" min="<?php echo date('Y-m-d'); ?>" required><br>

    <label for="check_out">Check-out Date:</label>
    <input type="date" id="check_out" name="check_out" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required><br>

    <label for="room_quantity">Number of Rooms:</label>
    <input type="number" id="room_quantity" name="room_quantity" min="1" required><br>

    <button type="submit">Book Hotel Room</button>
</form>

</body>
</html>
