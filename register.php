<?php
// Insert your database connection details below
$hostname = "localhost";
$username = "tlevel_feysal";
$password = "Feysal@199";
$dbname = "tlevel_feysal";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // Insert user data into the database
    $sql = "INSERT INTO customers (fname, lname, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! You can now <a href='login.php'>login</a>.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Riget Zoo Adventures</title>
    <link rel="stylesheet" href="form.scss">
</head>
<body>

<nav>
    <ul>
        <li><a href="main.php">Home</a></li>
        <li><a href="attractions.php">Attractions</a></li>
        <li><a href="hotel.php">Hotel</a></li>
        <li><a href="tickets.php">Book Tickets</a></li>
        <li style="float:right"><a href="login.php">Login</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</nav>

    <div class="form-container">
        <h2>Register for Riget Zoo Adventures</h2>
        <form action="register.php" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
