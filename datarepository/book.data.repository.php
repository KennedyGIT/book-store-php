<?php
require_once('./db_config/dbinit.php');
require_once('./dtos/book.dto.php');

class BookDataRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllBooks() {
        $stmt = $this->conn->prepare("SELECT * FROM Books");
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $bookCollection = array();
        foreach ($books as $bookData) {
            $book = new Book(
                $bookData['BookId'],
                $bookData['BookTitle'],
                $bookData['AuthorId'],
                $bookData['Genre'],
                $bookData['AmountInStock'],
                $bookData['BookImagePath']
            );
            $bookCollection[] = $book;
        }

        return $bookCollection;
    }

    public function getBookById($bookId) {
        $stmt = $this->conn->prepare("SELECT * FROM Books WHERE BookId = :bookId");
        $stmt->bindParam(':bookId', $bookId);
        $stmt->execute();
        $bookData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($bookData) {
            $book = new Book(
                $bookData['BookId'],
                $bookData['BookTitle'],
                $bookData['AuthorId'],
                $bookData['Genre'],
                $bookData['AmountInStock'],
                $bookData['BookImagePath']
            );
            return $book;
        } else {
            return null;
        }
    }

    public function saveBook($book) {
        $stmt = $this->conn->prepare("INSERT INTO Books (BookTitle, AuthorId, Genre, AmountInStock, BookImagePath) VALUES (:bookTitle, :authorId, :genre, :amountInStock, :bookImagePath)");
        $stmt->bindParam(':bookTitle', $book->BookTitle);
        $stmt->bindParam(':authorId', $book->AuthorId);
        $stmt->bindParam(':genre', $book->Genre);
        $stmt->bindParam(':amountInStock', $book->AmountInStock);
        $stmt->bindParam(':bookImagePath', $book->BookImagePath);
        $stmt->execute();
    }

    public function updateBook($book) {
        $stmt = $this->conn->prepare("UPDATE Books SET BookTitle = :bookTitle, AuthorId = :authorId, Genre = :genre, AmountInStock = :amountInStock, BookImagePath = :bookImagePath WHERE BookId = :bookId");
        $stmt->bindParam(':bookTitle', $book->BookTitle);
        $stmt->bindParam(':authorId', $book->AuthorId);
        $stmt->bindParam(':genre', $book->Genre);
        $stmt->bindParam(':amountInStock', $book->AmountInStock);
        $stmt->bindParam(':bookImagePath', $book->BookImagePath);
        $stmt->bindParam(':bookId', $book->BookId);
        $stmt->execute();
    }
}
?>
