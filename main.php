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
    <title>Riget Zoo Adventures</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Custom CSS -->
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <ul>
        <li><a href="main.php">Home</a></li>
        <li><a href="attractions.php">Attractions</a></li>
        <li><a href="hotel.php">Hotel</a></li>
        <li><a href="tickets.php">Book Tickets</a></li>
        <!-- Add Login and Register links -->
        <?php
        if (!isset($_SESSION['loggedin'])) {
            echo '<li style="float:right"><a href="login.php">Login</a></li>';
            echo '<li><a href="register.php">Register</a></li>';
        } else {
            echo '<li style="float:right"><a href="logout.php">Logout (' . $_SESSION['first_name'] . ')</a></li>';
            echo '<li><a href="loyalty.php">Loyalty Points</a></li>';
        }
        ?>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Explore the Wild at Riget Zoo Adventures</h1>
        <p>Experience a safari like never before!</p>
        <br>
        <a href="tickets.php" class="btn btn-primary">Book Your Tickets</a>
    </div>
</section>

<!-- Featured Attractions -->
<section class="featured-attractions">
    <h2>Featured Attractions</h2>
    <div class="attractions-grid">
        <div class="attraction">
            <img src="images/elephants.jpeg" alt="Elephant Safari">
            <h3>Elephant Safari</h3>
            <p>Get up close with majestic elephants.</p>
            <a href="attractions.php">Learn More</a>
        </div>
        <div class="attraction">
            <img src="images/lion.jpeg" alt="Lion's Den">
            <h3>Lion's Den</h3>
            <p>Witness the kings of the jungle in action.</p>
            <a href="attractions.php">Learn More</a>
        </div>
        <div class="attraction">
            <img src="images/giraffes.jpeg" alt="Giraffe Heights">
            <h3>Giraffe Heights</h3>
            <p>Feed the gentle giants and enjoy the view.</p>
            <a href="attractions.php">Learn More</a>
        </div>
    </div>
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
