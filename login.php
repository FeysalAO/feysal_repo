<?php
session_start();
include('db_connection.php');
include('nav.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT fname, lname, cID, password, username FROM customers WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['cID'];
        $_SESSION['first_name'] = $user['fname'];
        $_SESSION['last_name'] = $user['lname'];
        header('Location: main.php');  // Redirect to main page
        exit();
    } else {
        echo "Invalid login credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label for="Username">Username:</label>
        <input type="email" id="username" name="username" placeholder="Username should be an email.." required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password.." required><br>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>
