<?php
require_once('../db_config/dbinit.php');
require_once('../dtos/user.dto.php');

class UserDataRepository {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT * FROM Users");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userCollection = array();
        foreach ($users as $userData) {
            $user = new User(
                $userData['UserId'],
                $userData['UserType'],
                $userData['Username'],
                $userData['Firstname'],
                $userData['Lastname'],
                $userData['HashedPassword']
            );
            $userCollection[] = $user;
        }

        return $userCollection;
    }

    public function getUserById($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE UserId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $user = new User(
                $userData['UserId'],
                $userData['UserType'],
                $userData['Username'],
                $userData['Firstname'],
                $userData['Lastname'],
                $userData['HashedPassword']
            );
            return $user;
        } else {
            return null;
        }
    }

    public function saveUser($user) {
        $stmt = $this->conn->prepare("INSERT INTO Users (UserType, Username, Firstname, Lastname, HashedPassword) VALUES (:userType, :username, :firstname, :lastname, :hashedPassword)");
        $stmt->bindParam(':userType', $user->UserType);
        $stmt->bindParam(':username', $user->Username);
        $stmt->bindParam(':firstname', $user->Firstname);
        $stmt->bindParam(':lastname', $user->Lastname);
        $stmt->bindParam(':hashedPassword', $user->HashedPassword);
        $stmt->execute();
    }

    public function updateUser($user) {
        
        
        $stmt = $this->conn->prepare("UPDATE Users SET UserType = :userType, Username = :username, Firstname = :firstname, Lastname = :lastname, HashedPassword = :hashedPassword WHERE UserId = :userId");
        $stmt->bindParam(':userType', $user->UserType);
        $stmt->bindParam(':username', $user->Username);
        $stmt->bindParam(':firstname', $user->Firstname);
        $stmt->bindParam(':lastname', $user->Lastname);
        $stmt->bindParam(':hashedPassword', $user->HashedPassword);
        $stmt->bindParam(':userId', $user->UserId);
        $stmt->execute();
    }

    public function isUsernameExists($username) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM Users WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result['count'] > 0);
    }

    public function getUserByCredentials($username, $password) {
        
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($userData && password_verify($password, $userData['HashedPassword'])) {
            $user = new User(
                $userData['UserId'],
                $userData['UserType'],
                $userData['Username'],
                $userData['Firstname'],
                $userData['Lastname'],
                $userData['HashedPassword']
            );
            return $user;
        } else {
            return null;
        }
    }
    
}