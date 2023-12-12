<?php
class Cart {
    public $CartId;
    public $UserId;

    public function __construct($CartId, $UserId) {
        $this->CartId = $CartId;
        $this->UserId = $UserId;
    }
}
?>
