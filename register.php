<?php
include('db_connection.php');
include('nav.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO customers (fname, lname, username, password) VALUES ('$fname', '$lname', '$username', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "Registration successful!";
        header("Location: login.php");
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
    <title>Register - Riget Zoo Adventures</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="register.php">
        <label for="fname">FirstName:</label>
        <input type="text" id="fname" name="fname" placeholder="Enter your first name.." required><br><br>

        <label for="lname">SurName:</label>
        <input type="text" id="lname" name="lname" placeholder="Enter your last name.." required><br><br>
        
        <label for="email">Username:</label>
        <input type="email" id="username" name="username" placeholder="Username should be an email.." required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password.." required><br><br>
        
        <input type="submit" value="Register">
    </form>
</body>
</html>
