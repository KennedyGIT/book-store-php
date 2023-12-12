<?php
    session_start();

    if (isset($_POST['logout'])) {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header('Location: http://127.0.0.1:8080/bookstore_php/client/back-end/login.php');
        exit();
    }

    function getBookById($bookId) {
        $apiUrl = 'http://127.0.0.1:8080/bookstore_php/api/book.api.php';
        $getBookData = array(
            'action' => 'get_book_by_id',
            'bookId' => $bookId
        );
    
        // Perform the API call to fetch book data by ID
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($getBookData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
        $bookData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        if ($httpCode === 200) {
            return json_decode($bookData, true);
        } else {
            return null;
        }
    }

    function updateBook($bookId, $book) {
        $apiUrl = 'http://127.0.0.1:8080/bookstore_php/api/book.api.php';
        $updateBookData = array(
            'action' => 'update_book',
            'bookId' => $bookId,
            'book' => $book
        );

        print_r($updateBookData);

        // Perform the API call to update user type
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updateBookData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $updateResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return json_decode($updateResponse, true);
        } else {
            return null;
        }
    }
    $error = "";

    if (isset($_GET['bookId'])) {
        $bookId = $_GET['bookId'];
        $bookData = getBookById($bookId);
    };

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process the submitted form data
        $updatedBookData = array(
                'BookId' => $_POST['bookId'],
                'BookTitle' => $_POST['bookTitle'], 
                'Author' => $_POST['author'], 
                'Genre' => $_POST['genre'], 
                'AmountInStock' => $_POST['quantity'], 
                'BookImagePath' => "images/" . $_POST['bookImage'],
                'Price' => $_POST['price']
        );

        echo $_POST['bookId'];
        print_r($updatedBookData);
    
        // Update book using the API
        $updateResult = updateBook($_POST['bookId'], $updatedBookData);
    
        if ($updateResult && isset($updateResult['message'])) {
            $updateSuccess = true;
        } else {
            $error = "Unable to update book data";
           
        }
    }
?>