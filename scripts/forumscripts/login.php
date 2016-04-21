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

        $nonce = $result->fetch_array()[0];

        if($result->num_rows == 0){
            return rand(0,999);
        } else {
            return $nonce;
        }
    }

    function login($password){
        $this->password = htmlentities($this->link->real_escape_string($password));

        $query = "SELECT password FROM users WHERE username = '$this->username'";

        $result = $this->link->query($query) or die($this->link->error);

        $correctpassword = $result->fetch_array()[0];

        $md5d = md5($correctpassword.($this->get_nonce()));

        $correcthash = $this->shuffle($md5d);

        if(strcmp($password,$correcthash)==0){
            return true;
        }
        return false;
    }

    function shuffle($correctpassword){
        $password = $correctpassword;



        $password = strrev($password); //reverse the md5

        $password = substr($password,16,16).substr($password,0,16);


        $password = (hexdec(substr($password,24,8))+10101).",".
            (hexdec(substr($password,16,8))+10101).",".
            (hexdec(substr($password,8,8))+10101).",".
            (hexdec(substr($password,0,8))+34);

        $password = strrev($password);

        return $password;

    }

    function antihash($password){

        $password = strrev($password);

        $password = explode(",",$password);


        $password = dechex($password[3]-34).dechex($password[2]-10101).dechex($password[1]-10101).dechex($password[0]-10101);

        $password = substr($password,16,16).substr($password,0,16);

        $password = strrev($password);
        return $password;

    }

}

?>
