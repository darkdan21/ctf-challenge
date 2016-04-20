<?php
class login{
    var $username;
    var $password;
    var $link;

    function __construct($username){
        $this->link = new mysqli("localhost", "root", "cheese12345", "forum");
        $this->username = htmlentities($this->link->real_escape_string($username));
    }

    function nonce(){
        $nonce = rand(1,999);

        $query = "DELETE FROM loginnonces WHERE username = '$this->username'";

        $query2= "INSERT INTO loginnonces (username, nonce) VALUES ('$this->username','$nonce')";

        $result = $this->link->query($query) or die($this->link->error);
        $result = $this->link->query($query2) or die($this->link->error);
    }

    function get_nonce(){
        $query = "SELECT nonce FROM loginnonces WHERE username='$this->username'";
        $result = $this->link->query($query) or die($this->link->error);

        return $result->fetch_array()[0];

    }

    function login($password){
        $this->password = htmlentities($this->link->real_escape_string($password));


        $query = "SELECT password FROM users WHERE username = '$this->username'";



        $result = $this->link->query($query) or die($this->link->error);

        $correctpassword = $result->fetch_array()[0];

        echo $correctpassword;

    }

    function myhash($correctpassword){

    }

}

$login = new login("dan_j@live.co.uk");
$login->login("hiya");


?>
