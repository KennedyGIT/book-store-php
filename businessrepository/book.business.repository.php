<?php
require_once('../datarepository/book.data.repository.php'); // Include the BookDataRepository
require_once('../dtos/book.dto.php'); // Include the Book entity classs

class BookBusinessRepository {
    private $bookDataRepo;

    public function __construct() {
        global $conn;
        $this->bookDataRepo = new BookDataRepository();
    }

    // Save a new book
    public function saveBook($book) {
        $this->bookDataRepo->saveBook($book);
    }

    // Update book details
    public function updateBook($BookId, $book) {
        $existingBook = $this->bookDataRepo->getBookById($BookId);

        if ($existingBook !== null) {
            $this->bookDataRepo->updateBook($book);
        } else {
            throw new Exception("Book with ID {$book->BookId} does not exist."); 
        }
    }

    // Get all books
    public function getAllBooks() {
        return $this->bookDataRepo->getAllBooks();
    }

    // Get book by ID
    public function getBookById($bookId) {
        return $this->bookDataRepo->getBookById($bookId);
    }
}


?>