<?php
session_start();
    // Clear the cart by emptying the cart session
    $_SESSION['UserId'] = [];
    $_SESSION['UserType'] = [];
    $_SESSION['Username'] = [];
    $_SESSION['Firstname'] = [];
    $_SESSION['Lastname'] = [];

    header('Location: http://127.0.0.1:8080/bookstore_php/client/front-end/store.php');
    exit();
?>