<?php
session_start();

// Clear the cart by emptying the cart session
$_SESSION['cart'] = [];

// Respond with a success message (you can send JSON response if needed)
http_response_code(200);
?>