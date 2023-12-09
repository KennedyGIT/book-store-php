<?php
class Book {
    public $BookId;
    public $BookTitle;
    public $AuthorId;
    public $Genre;
    public $AmountInStock;
    public $BookImagePath;

    public function __construct($BookId, $BookTitle, $AuthorId, $Genre, $AmountInStock, $BookImagePath) {
        $this->BookId = $BookId;
        $this->BookTitle = $BookTitle;
        $this->AuthorId = $AuthorId;
        $this->Genre = $Genre;
        $this->AmountInStock = $AmountInStock;
        $this->BookImagePath = $BookImagePath;
    }
}
?>
