<?php
$servername = "127.0.0.1:3306"; // Replace with your server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $conn->exec("CREATE DATABASE IF NOT EXISTS BookDB");

    // Select the created database
    $conn->exec("USE BookDB");

    

    // Create the Users table if it doesn't exist
    $conn->exec("CREATE TABLE IF NOT EXISTS Users (
        UserId INT AUTO_INCREMENT PRIMARY KEY,
        UserType VARCHAR(20),
        Username VARCHAR(50),
        Firstname VARCHAR(50),
        Lastname VARCHAR(50),
        HashedPassword VARCHAR(255)
    )");

    // Check if the admin user exists
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM Users WHERE UserType = 'Admin'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] == 0) {
        // Insert sample data for Admin user
        $conn->exec("INSERT INTO Users (UserType, Username, Firstname, Lastname, HashedPassword)
            VALUES ('Admin', 'admin_user', 'Admin', 'Smith', '$2y$10$64k3dpe9Uba0krPns0dcZOc2bboBaO5kI6axvsj/kRjTNqN6n4tZe')");
    }


    $conn->exec("CREATE TABLE IF NOT EXISTS Cart (
        CartId INT AUTO_INCREMENT PRIMARY KEY,
        UserId INT
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS Cart_Items (
        CartItemId INT AUTO_INCREMENT PRIMARY KEY,
        CartId INT,
        BookId INT,
        quantity INT
    )");

    // Create the Books table if it doesn't exist
    $conn->exec("CREATE TABLE IF NOT EXISTS Books (
        BookId INT AUTO_INCREMENT PRIMARY KEY,
        BookTitle VARCHAR(100),
        Author VARCHAR(50),
        Genre VARCHAR(50),
        AmountInStock INT,
        Price Decimal,
        BookImagePath VARCHAR(255)
    )");

     


} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
