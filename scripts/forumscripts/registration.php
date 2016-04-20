<?php

include_once("scripts/sessions/management.php");

class registration {


    var $link;

    var $username;
    var $email;
    var $password;

    function __construct() {
        $this->link = new mysqli("localhost", "root", "cheese12345", "forum");
    }

    function doregistration(){
        if($this->username != "" && $this->email != "" && $this->password != ""){
            $username = htmlentities($this->link->real_escape_string($this->username));
            $email = htmlentities($this->link->real_escape_string($this->email));
            $password = htmlentities($this->link->real_escape_string($this->password));

            $token = $this->random_string();

            $query = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')";

            $result = $this->link->query($query) or die($this->link->error);

            $query = "SELECT id FROM users WHERE username='$username'";

            $result = $this->link->query($query) or die($this->link->error);

            $id = $result->fetch_array()[0];

            $query = "INSERT INTO registration_keys (userid, token) VALUES ('$id','$token')";

            $result = $this->link->query($query) or die($this->link->error);

            $session = new session();
            $session->register($username);

            return True;
        }

        return False;
    }

    function username($username){
        $username = htmlentities($this->link->real_escape_string($username));
        $query = "SELECT * FROM users WHERE username ='$username'";

        $result = $this->link->query($query) or die($this->link->error);

        if($result->num_rows == 0){
            $this->username = $username;
            return True;
        }

        return False;
    }

    function email($email){
        $email = htmlentities($this->link->real_escape_string($email));
        $query = "SELECT * FROM users WHERE email ='$email'";

        $result = $this->link->query($query) or die($this->link->error);

        if($result->num_rows == 0){
            $this->email = $email;
            return True;
        }

        return False;
    }

    function password($password, $password2){

        if($password != $password2){
            return false;
        }

        $this->password = htmlentities($this->link->real_escape_string($password));

        return True;
    }

    function random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
?>
