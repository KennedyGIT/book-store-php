<?php
try {
    require_once('../businessrepository/book.business.repository.php'); // Include the BookBusinessRepository
    require_once('../dtos/book.dto.php'); // Include the Book entity class

    $bookRepository = new BookBusinessRepository();

    // Set headers to allow cross-origin requests (adjust as needed)
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Handling API endpoints
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (isset($requestData['action'])) {
            switch ($requestData['action']) {
                case 'add_book':
                    // Add a new book
                    // Example: {"action": "add_book", "book": {"BookId": 4, "BookTitle": "New Book", "Author": "Author Name", "Genre": "Fantasy", "AmountInStock": 10, "BookImagePath": "path/to/image"}}
                    if (isset($requestData['book'])) {
                        $newBook = new Book(
                            $requestData['book']['BookId'],
                            $requestData['book']['BookTitle'],
                            $requestData['book']['Author'],
                            $requestData['book']['Genre'],
                            $requestData['book']['AmountInStock'],
                            $requestData['book']['BookImagePath'],
                            $requestData['book']['Price']
                        );
                        $bookRepository->saveBook($newBook);
                        echo json_encode(['message' => 'Book added successfully']);
                    } else {
                        echo json_encode(['error' => 'Invalid book data']);
                    }
                    break;
                case 'update_book':
                    // Update a book by BookId
                    // Example: {"action": "update_book", "book": {"BookId": 4, "BookTitle": "Updated Book Title", "Author": "Updated Author", "Genre": "Sci-Fi", "AmountInStock": 15, "BookImagePath": "updated/path/to/image"}}
                    if (isset($requestData['book']) && isset($requestData['bookId'])) {
                        $bookId = $requestData['bookId'];
                        $bookData = $requestData['book'];

                        $bookRepository->updateBook($bookId, $bookData);
                        echo json_encode(['message' => 'Book updated successfully']);
                    } else {
                        echo json_encode(['error' => 'Invalid book data']);
                    }
                    break;
                case 'get_all_books':
                    // Get all books
                    $allBooks = $bookRepository->getAllBooks();
                    echo json_encode($allBooks);
                    break;
                case 'get_book_by_id':
                    // Get book by BookId
                    // Example: {"action": "get_book_by_id", "bookId": 3}
                    if (isset($requestData['bookId'])) {
                        $bookId = $requestData['bookId'];
                        $book = $bookRepository->getBookById($bookId);
                        echo json_encode($book);
                    } else {
                        echo json_encode(['error' => 'Invalid parameters for getting book by ID']);
                    }
                    break;
                default:
                    echo json_encode(['error' => 'Invalid API action']);
                    break;
            }
        } else {
            echo json_encode(['error' => 'No action specified']);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['error' =>  $e->getMessage()]);
}
?>