<?php
require_once('../db_config/dbinit.php');
require_once('../dtos/cart_item.dto.php');


class CartItemDataRepository {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getCartItemsByCartId($cartId) {
        $stmt = $this->conn->prepare("SELECT * FROM Cart_Items WHERE CartId = :cartId");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->execute();
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cartItemsCollection = array();
        foreach ($cartItems as $cartItemData) {
            $cartItem = new CartItem(
                $cartItemData['CartItemId'],
                $cartItemData['CartId'],
                $cartItemData['BookId'],
                $cartItemData['quantity']
            );
            $cartItemsCollection[] = $cartItem;
        }

        return $cartItemsCollection;
    }

    public function addCartItem($cartItem) {
        $stmt = $this->conn->prepare("INSERT INTO Cart_Items (CartId, BookId, quantity) VALUES (:cartId, :bookId, :quantity)");
        $stmt->bindParam(':cartId', $cartItem->CartId);
        $stmt->bindParam(':bookId', $cartItem->BookId);
        $stmt->bindParam(':quantity', $cartItem->Quantity);
        $stmt->execute();
    }

    public function updateCartItem($cartItem) {
        $stmt = $this->conn->prepare("UPDATE Cart_Items SET quantity = :quantity WHERE CartItemId = :cartItemId");
        $stmt->bindParam(':quantity', $cartItem->Quantity);
        $stmt->bindParam(':cartItemId', $cartItem->CartItemId);
        $stmt->execute();
    }

    public function deleteCartItem($cartItemId) {
        $stmt = $this->conn->prepare("DELETE FROM Cart_Items WHERE CartItemId = :cartItemId");
        $stmt->bindParam(':cartItemId', $cartItemId);
        $stmt->execute();
    }
}


?>