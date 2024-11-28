<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    echo "Welcome, " . $_SESSION['first_name'] . "!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractions | Riget Zoo Adventures</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Custom CSS -->
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <ul>
        <li><a href="main.php">Home</a></li>
        <li><a href="hotel.php">Hotel</a></li>
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

<!-- Attractions Overview -->
<section class="attractions-overview">
    <h1>Explore Our Attractions</h1>
    <p>Riget Zoo Adventures offers a variety of exciting safari-style experiences. From the majestic elephants to the thrilling lion's den, there's something for everyone. Check out our attractions below and start your adventure today!</p>
</section>

<!-- Attractions Listings -->
<section class="attractions-list">
    <div class="attraction">
        <img src="images/elephants.jpeg" alt="Elephant Safari">
        <h3>Elephant Safari</h3>
        <p>Experience an up-close encounter with our majestic elephants.</p>
        <br>
        <a href="tickets.php?attraction=elephant_safari" class="btn btn-primary">Book Tickets</a>
    </div>

    <div class="attraction">
        <img src="images/lion.jpeg" alt="Lion's Den">
        <h3>Lion's Den</h3>
        <p>Get a thrilling view of the kings of the jungle in their natural habitat.</p>
        <br>
        <a href="tickets.php?attraction=lions_den" class="btn btn-primary">Book Tickets</a>
    </div>

    <div class="attraction">
        <img src="images/giraffes.jpeg" alt="Giraffe Heights">
        <h3>Giraffe Heights</h3>
        <p>Stand tall and feed the gentle giraffes while enjoying a spectacular view.</p>
        <br>
        <a href="tickets.php?attraction=giraffe_heights" class="btn btn-primary">Book Tickets</a>
    </div>

    <div class="attraction">
        <img src="images/educational.jpeg" alt="Educational Visit">
        <h3>Educational Visit</h3>
        <p>Learn about wildlife conservation through our educational programs.</p>
        <br>
        <a href="tickets.php?attraction=education" class="btn btn-primary">Book Tickets</a>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <h2>Ready to Explore?</h2>
    <p>Book your tickets now and make unforgettable memories with your loved ones!</p>
    <br>
    <a href="tickets.php" class="btn btn-primary">Book Your Tickets</a>
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
