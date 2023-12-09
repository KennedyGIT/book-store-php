<?php
try{
    require_once('../businessrepository/user.business.repository.php'); // Include the UserBusinessRepository
    require_once('../dtos/user.dto.php'); // Include the User entity class

    $userRepository = new UserBusinessRepository();

    // Set headers to allow cross-origin requests (adjust as needed)
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Handling API endpoints
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (isset($requestData['action'])) {
            switch ($requestData['action']) {
                case 'add_user':
                    // Add a new user
                    // Example: {"action": "add_user", "user": {"UserId": 4, "UserType": "Regular", "Username": "new_user", "Firstname": "New", "Lastname": "User", "HashedPassword": "new_user_password"}}
                    $username = isset($requestData['user']['Username']) ? strtolower($requestData['user']['Username']) : null;
                    if (isset($requestData['user'])) {
                        $newUser = new User(
                            $requestData['user']['UserId'],
                            $requestData['user']['UserType'],
                            $username,
                            $requestData['user']['Firstname'],
                            $requestData['user']['Lastname'],
                            "password"
                        );
                        $userRepository->saveUser($newUser);
                        echo json_encode(['message' => 'User added successfully']);
                    } else {
                        echo json_encode(['error' => 'Invalid user data']);
                    }
                    break;
                case 'update_user_password':
                    // Update user password by UserId
                    // Example: {"action": "update_user_password", "userId": 1, "newPassword": "new_password"}
                    if (isset($requestData['userId']) && isset($requestData['newPassword'])) {
                        $userId = $requestData['userId'];
                        $newPassword = $requestData['newPassword'];
                        $userRepository->updateUserPassword($userId, $newPassword);
                        echo json_encode(['message' => 'User password updated successfully']);
                    } else {
                        echo json_encode(['error' => 'Invalid parameters for updating password']);
                    }
                    break;
                case 'update_user_type':
                    // Update user type by UserId
                    // Example: {"action": "update_user_type", "userId": 2, "userType": "Admin"}
                    if (isset($requestData['userId']) && isset($requestData['userType'])) {
                        $userId = $requestData['userId'];
                        $userType = $requestData['userType'];
                        $userRepository->updateUserType($userId, $userType);
                        echo json_encode(['message' => 'User type updated successfully']);
                    } else {
                        echo json_encode(['error' => 'Invalid parameters for updating user type']);
                    }
                    break;
                case 'get_all_users':
                    // Get all users
                    $allUsers = $userRepository->getAllUsers();
                    echo json_encode($allUsers);
                    break;
                case 'validate_user_credentials':
                    // Validate user credentials
                    // Example: {"action": "validate_user_credentials", "username": "username_here", "password": "password_here"}
                    if (isset($requestData['username']) && isset($requestData['password'])) {
                        $username = isset($requestData['username']) ? strtolower($requestData['username']) : null;
                        $password = $requestData['password'];
                
                        $user = $userRepository->UserCredentialsValid($username, $password);
                
                        if ($user !== null) {
                            echo json_encode(['message' => 'Valid credentials', 'user' => $user]);
                        } else {
                            echo json_encode(['error' => 'Invalid credentials']);
                        }
                    } else {
                        echo json_encode(['error' => 'Invalid parameters for validating credentials']);
                    }
                    break;
                case 'get_user_by_id':
                    // Get user by UserId
                    // Example: {"action": "get_user_by_id", "userId": 3}
                    if (isset($requestData['userId'])) {
                        $userId = $requestData['userId'];
                        $user = $userRepository->getUser($userId);
                        echo json_encode($user);
                    } else {
                        echo json_encode(['error' => 'Invalid parameters for getting user by ID']);
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

}
catch(Exception $e){
    echo json_encode(['error' =>  $e->getMessage()]);
}
?>
