<?php
require_once('../db_config/dbinit.php');
require_once('../dtos/cart.dto.php');

class CartDataRepository {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getCartById($cartId) {
        $stmt = $this->conn->prepare("SELECT * FROM Cart WHERE CartId = :cartId");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->execute();
        $cartData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cartData) {
            $cart = new Cart(
                $cartData['CartId'],
                $cartData['UserId']
            );
            return $cart;
        } else {
            return null;
        }
    }

    public function createCart($cart) {
        $stmt = $this->conn->prepare("INSERT INTO Cart (UserId) VALUES (:userId)");
        $stmt->bindParam(':userId', $cart->UserId);
        $stmt->execute();
    }

    public function updateCart($cart) {
        $stmt = $this->conn->prepare("UPDATE Cart SET UserId = :userId WHERE CartId = :cartId");
        $stmt->bindParam(':userId', $cart->UserId);
        $stmt->bindParam(':cartId', $cart->CartId);
        $stmt->execute();
    }

    public function deleteCart($cartId) {
        $stmt = $this->conn->prepare("DELETE FROM Cart WHERE CartId = :cartId");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->execute();
    }
}

?>