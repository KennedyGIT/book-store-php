<?php
$servername = "127.0.0.1:3306"; // Replace with your server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $conn->exec("CREATE DATABASE IF NOT EXISTS BookDB");
    echo "Database created successfully<br>";

    // Select the created database
    $conn->exec("USE BookDB");

    // Create the Users table
    $conn->exec("CREATE TABLE IF NOT EXISTS Users (
        UserId INT AUTO_INCREMENT PRIMARY KEY,
        UserType VARCHAR(20),
        Username VARCHAR(50),
        Firstname VARCHAR(50),
        Lastname VARCHAR(50),
        HashedPassword VARCHAR(255)
    )");

    // Insert sample data for Users
    $conn->exec("INSERT INTO Users (UserType, Username, Firstname, Lastname, HashedPassword)
        VALUES 
            ('Admin', 'admin_user', 'Admin', 'Smith', 'hashed_admin_password'),
            ('Regular', 'john_doe', 'John', 'Doe', 'hashed_regular_password'),
            ('Regular', 'jane_smith', 'Jane', 'Smith', 'hashed_regular_password')");

    // Create the Authors table
    $conn->exec("CREATE TABLE IF NOT EXISTS Authors (
        AuthorId INT AUTO_INCREMENT PRIMARY KEY,
        FirstName VARCHAR(50),
        LastName VARCHAR(50)
    )");

    // Insert sample data for Authors
    $conn->exec("INSERT INTO Authors (FirstName, LastName)
        VALUES 
            ('George', 'Martin'),
            ('Isaac', 'Asimov'),
            ('Agatha', 'Christie')");

    // Create the Books table
    $conn->exec("CREATE TABLE IF NOT EXISTS Books (
        BookId INT AUTO_INCREMENT PRIMARY KEY,
        BookTitle VARCHAR(100),
        AuthorId INT,
        Genre VARCHAR(50),
        AmountInStock INT,
        BookImagePath VARCHAR(255),
        FOREIGN KEY (AuthorId) REFERENCES Authors(AuthorId)
    )");

    // Insert sample data for Books
    $conn->exec("INSERT INTO Books (BookTitle, AuthorId, Genre, AmountInStock, BookImagePath)
        VALUES 
            ('Book 1 Title', 1, 'Fantasy', 10, '/images/book1.jpg'),
            ('Book 2 Title', 2, 'Science Fiction', 15, '/images/book2.jpg'),
            ('Book 3 Title', 3, 'Mystery', 8, '/images/book3.jpg')");

    echo "Tables created successfully and sample data inserted";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
