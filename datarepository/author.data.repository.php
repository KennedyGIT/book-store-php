<?php
require_once('./db_config/dbinit.php');
require_once('./dtos/author.dto.php');

class AuthorDataRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllAuthors() {
        $stmt = $this->conn->prepare("SELECT * FROM Authors");
        $stmt->execute();
        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $authorCollection = array();
        foreach ($authors as $authorData) {
            $author = new Author(
                $authorData['AuthorId'],
                $authorData['FirstName'],
                $authorData['LastName']
            );
            $authorCollection[] = $author;
        }

        return $authorCollection;
    }

    public function getAuthorById($authorId) {
        $stmt = $this->conn->prepare("SELECT * FROM Authors WHERE AuthorId = :authorId");
        $stmt->bindParam(':authorId', $authorId);
        $stmt->execute();
        $authorData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($authorData) {
            $author = new Author(
                $authorData['AuthorId'],
                $authorData['FirstName'],
                $authorData['LastName']
            );
            return $author;
        } else {
            return null;
        }
    }

    public function saveAuthor($author) {
        $stmt = $this->conn->prepare("INSERT INTO Authors (FirstName, LastName) VALUES (:firstName, :lastName)");
        $stmt->bindParam(':firstName', $author->FirstName);
        $stmt->bindParam(':lastName', $author->LastName);
        $stmt->execute();
    }

    public function updateAuthor($author) {
        $stmt = $this->conn->prepare("UPDATE Authors SET FirstName = :firstName, LastName = :lastName WHERE AuthorId = :authorId");
        $stmt->bindParam(':firstName', $author->FirstName);
        $stmt->bindParam(':lastName', $author->LastName);
        $stmt->bindParam(':authorId', $author->AuthorId);
        $stmt->execute();
    }
}
?>
