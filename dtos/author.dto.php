<?php
class Author {
    public $AuthorId;
    public $FirstName;
    public $LastName;

    public function __construct($AuthorId, $FirstName, $LastName) {
        $this->AuthorId = $AuthorId;
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
    }
}
?>
