<?php
class CartItem {
    public $CartItemId;
    public $CartId;
    public $BookId;
    public $quantity;

    public function __construct($CartItemId, $CartId, $BookId, $quantity) {
        $this->CartItemId = $CartItemId;
        $this->CartId = $CartId;
        $this->BookId = $BookId;
        $this->quantity = $quantity;
    }
}
?>
