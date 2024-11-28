<?php
session_start();  // Start a session

// Database connection details
$hostname = "localhost";
$username = "tlevel_feysal";
$password = "Feysal@199";
$dbname = "tlevel_feysal";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Input validation (basic)
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Query to fetch the user data
        $stmt = $conn->prepare("SELECT cID, fname, password FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify the hashed password
            if ($password == $row['password']) {
                // Store session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['first_name'] = $row['fname'];
                $_SESSION['user_id'] = $row['cID'];
                $_SESSION['user_type'] = $row['user_type'];

                // Redirect user to the homepage after login
                header("Location: main.php");
                exit();
            } else {
                echo "Incorrect password!";
            }
        } else {
            echo "No account found with that email.";
        }
        $stmt->close();
    } else {
        echo "Please fill in all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Riget Zoo Adventures</title>
    <link rel="stylesheet" href="form.scss">
</head>
<body>
    <div class="form-container">
        <h2>Login to your account</h2>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>
</html>
