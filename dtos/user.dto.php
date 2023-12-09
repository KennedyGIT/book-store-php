<?php
class User {
    public $UserId;
    public $UserType;
    public $Username;
    public $Firstname;
    public $Lastname;
    public $HashedPassword;

    public function __construct($UserId, $UserType, $Username, $Firstname, $Lastname, $HashedPassword) {
        $this->UserId = $UserId;
        $this->UserType = $UserType;
        $this->Username = $Username;
        $this->Firstname = $Firstname;
        $this->Lastname = $Lastname;
        $this->HashedPassword = $HashedPassword;
    }
}
?>
