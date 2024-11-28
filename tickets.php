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
    echo "You are not logged in. Please <a href='login.php'>login</a> to book a ticket.";
    exit();
}


// Variables to hold errors or confirmation messages
$error_message = '';
$success_message = '';

// Function to handle ticket booking logic
if (isset($_POST['book_ticket'])) {
    $ticket_type = $_POST['ticket_type'];
    $total_people = (int)$_POST['total_people'];
    $ticket_price = 0;

    // Initialize variables based on ticket type
    if ($ticket_type == 'normal') {
        $adults = (int)$_POST['adults'];
        $children = (int)$_POST['children'];
        $family = (int)$_POST['family'];

        // Calculate price (normal logic for adults, children, and family)
        $ticket_price = calculateNormalTicketPrice($adults, $children, $family);
    } elseif ($ticket_type == 'reserve') {
        if ($total_people < 10) {
            $error_message = "For reserve tickets, you must book for more than 10 people.";
        } else {
            // Calculate price for reserve (number of people * 10)
            $ticket_price = $total_people * 10;
        }
    } elseif ($ticket_type == 'family') {
        $adults = (int)$_POST['adults'];
        $children = (int)$_POST['children'];

        // Check family requirements
        if ($total_people < 7 || $total_people > 10) {
            $error_message = "Family tickets must be for 7 to 10 people.";
        } elseif ($children < 4) {
            $error_message = "Family tickets require at least 4 children.";
        } elseif ($total_people > 10) {
            $extra_people = $total_people - 10;
            $error_message = "Your group has more than 10 people. {$extra_people} adult(s) will need normal tickets.";
        } else {
            // Calculate family ticket price
            $ticket_price = calculateFamilyTicketPrice($adults, $children);
        }
    }

    // Final validation and database insertion
    if (empty($error_message)) {
        // Insert booking data into the database
        $sql = "INSERT INTO zoo_bookings (ticket_type, total_people, ticket_price) VALUES ('$ticket_type', '$total_people', '$ticket_price')";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Ticket successfully booked!";
        } else {
            $error_message = "Error booking the ticket: " . mysqli_error($conn);
        }
    }
}

// Function to calculate normal ticket price
function calculateNormalTicketPrice($adults, $children, $family) {
    return ($adults * 20) + ($children * 10) + ($family * 50); // Example logic
}

// Function to calculate family ticket price
function calculateFamilyTicketPrice($adults, $children) {
    return ($adults * 10) + ($children * 5); // Example logic
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Booking</title>
    <link rel="stylesheet" href="tickets.css">
</head>
<body>

<div class="container">
    <h1>Book Your Tickets</h1>

    <?php if (!empty($error_message)): ?>
        <div id="error_message"><?php echo $error_message; ?></div>
    <?php elseif (!empty($success_message)): ?>
        <div id="success_message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form id="bookingForm" method="post" action="">
        <!-- Ticket Type -->
        <label for="ticket_type">Select Ticket Type</label>
        <select id="ticket_type" name="ticket_type" required>
            <option value="">--Select Type--</option>
            <option value="normal">Normal</option>
            <option value="reserve">Reserve</option>
            <option value="family">Family</option>
        </select>

        <!-- Total People -->
        <label for="total_people">Total Number of People</label>
        <input type="number" id="total_people" name="total_people" required min="1" placeholder="Enter total people">

        <!-- Adults and Children fields (shown only for 'normal' or 'family' tickets) -->
        <div id="extra_fields" style="display: none;">
            <label for="adults">Number of Adults</label>
            <input type="number" id="adults" name="adults" min="0" placeholder="Number of Adults">
            
            <label for="children">Number of Children</label>
            <input type="number" id="children" name="children" min="0" placeholder="Number of Children">
        </div>

        <button type="submit" name="book_ticket">Book</button>
    </form>
</div>

<script>
document.getElementById('ticket_type').addEventListener('change', function() {
    let ticketType = this.value;
    let extraFields = document.getElementById('extra_fields');
    let totalPeople = document.getElementById('total_people');
    let errorMessage = '';

    // Show extra fields for normal and family tickets
    if (ticketType === 'normal' || ticketType === 'family') {
        extraFields.style.display = 'block';
    } else {
        extraFields.style.display = 'none';
    }
});

document.getElementById('bookingForm').addEventListener('submit', function(event) {
    let ticketType = document.getElementById('ticket_type').value;
    let totalPeople = parseInt(document.getElementById('total_people').value);
    let adults = parseInt(document.getElementById('adults').value);
    let children = parseInt(document.getElementById('children').value);
    let errorMessage = '';

    if (ticketType === 'family') {
        if (totalPeople < 7 || totalPeople > 10) {
            errorMessage = "Family tickets must be for 7 to 10 people.";
        } else if (children < 4) {
            errorMessage = "Family tickets require at least 4 children.";
        } else if (totalPeople > 10) {
            let extraAdults = totalPeople - 10;
            errorMessage = `You need extra normal tickets for ${extraAdults} adult(s).`;
        }
    }

    if (errorMessage !== '') {
        event.preventDefault(); // Prevent form submission
        document.getElementById('error_message').innerText = errorMessage;
    }
});
</script>

</body>
</html>
