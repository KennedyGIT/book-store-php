<?php
require_once('../datarepository/user.data.repository.php'); // Include the UserDataRepository
require_once('../dtos/user.dto.php'); // Include the User entity class

class UserBusinessRepository {
    private $userDataRepo;

    public function __construct() {
        $this->userDataRepo = new UserDataRepository();
    }

    // Save a new user with a hashed password
    public function saveUser($user) {
        
        if($this->userDataRepo->isUsernameExists($user -> Username)){
            throw new Exception('username already exists');
        };
        $hashedPassword = password_hash($user->HashedPassword, PASSWORD_DEFAULT);
        $user->HashedPassword = $hashedPassword;
        $this->userDataRepo->saveUser($user);
        
    }

    // Update user password
    public function updateUserPassword($userId, $newPassword) {

        $existingUser = $this->userDataRepo->getUserById($userId);
        if ($existingUser !== null) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $existingUser->HashedPassword = $hashedPassword;
            $this->userDataRepo->updateUser($existingUser);
        }
        else{
            echo "User with ID {$userId} does not exist.";
        }
    }

    public function updateUserType($userId, $userType) {

        $existingUser = $this->userDataRepo->getUserById($userId);
        if ($existingUser !== null) {
            $existingUser->UserType = $userType;
            $this->userDataRepo->updateUser($existingUser);
        }
        else{
            echo "User with ID {$userId} does not exist.";
        }
    }

    // Check if username exists
    public function isUsernameExists($username) {
        return $this->userDataRepo->isUsernameExists($username);
    }

    // Check if username and password combination is valid
    public function UserCredentialsValid($username, $password) {
        return $this->userDataRepo->getUserByCredentials($username, $password);
    }

    public function getAllUsers() {
        $allUsers = $this->userDataRepo->getAllUsers();

        $usersWithoutPasswords = array();
        foreach ($allUsers as $user) {
            $userWithoutPassword = new User(
                $user->UserId,
                $user->UserType,
                $user->Username,
                $user->Firstname,
                $user->Lastname,
                '' // Empty string for the password/hashed password
            );
            $usersWithoutPasswords[] = $userWithoutPassword;
        }

        return $usersWithoutPasswords;
    }

    public function getUser($UserId) {
        $existingUser = $this->userDataRepo->getUserById($UserId);

        if($existingUser == null)
        {
            echo "User with ID {$UserId} does not exist.";         
        }  
            
        return $existingUser;
    }

}
?>
