<?php
class Book {
    public $BookId;
    public $BookTitle;
    public $Author;
    public $Genre;
    public $AmountInStock;
    public $BookImagePath;
    public $Price;

    public function __construct($BookId, $BookTitle, $Author, $Genre, $AmountInStock, $BookImagePath, $Price) {
        $this->BookId = $BookId;
        $this->BookTitle = $BookTitle;
        $this->Author = $Author;
        $this->Genre = $Genre;
        $this->AmountInStock = $AmountInStock;
        $this->BookImagePath = $BookImagePath;
        $this->Price = $Price;
    }
}
?>
