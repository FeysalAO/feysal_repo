<?php
session_start();
include('db_connection.php');
include('nav.php');

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $sql = "INSERT INTO products (name, price) VALUES ('$product_name', '$product_price')";
    if (mysqli_query($conn, $sql)) {
        echo "Product added successfully!";
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
    <title>Admin - Riget Zoo Adventures</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h2>Admin Panel</h2>
    <h3>Add New Product</h3>
    <form method="POST" action="admin.php">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>
        
        <label for="product_price">Product Price:</label>
        <input type="number" id="product_price" name="product_price" required min="0" step="0.01"><br><br>
        
        <input type="submit" name="add_product" value="Add Product">
    </form>
</body>
</html>
