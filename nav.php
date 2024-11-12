<link rel="stylesheet" href="main.css">
<nav>
    <ul>
        <li><a href="main.php">Main Page</a></li>
        <li><a href="zoo_booking.php">Zoo Booking</a></li>
        <li><a href="hotel_booking.php">Hotel Booking</a></li>
        <li><a href="rewards.php">Rewards</a></li>
        <li><a href="account.php">Account</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>  <!-- Check if user is logged in -->
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>

