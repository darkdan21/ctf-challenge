<?php

class session{

    public $username = "";
    public $valid = False;
    public $loggedout = False;
    var $token;
    var $link;
    var $id;

    function __construct(){
        $this->link = new mysqli('localhost','root','cheese12345','sessions');

        if(isset($_COOKIE['username'])&&isset($_COOKIE['token'])){
            //check to see if the session is set
            $this->username = $this->link->real_escape_string($_COOKIE['username']);
            $this->token = $this->link->real_escape_string($_COOKIE['token']);

            if($this->verify_session()){
                //verify the session is correct
                $this->valid=True;

                $this->gen_next_token();
            } else {
                //if it is not correct, unset cookies
                $this->valid=False;


                $this->delete_sessions();
            }
        } else {
            $this->delete_sessions();
        }
    }

    function get_user_id(){
        $link2 = new mysqli("localhost", "root", "cheese12345", "forum");

        $query = "SELECT id FROM users WHERE username='$this->username'";
        $result = $link2->query($query) or die($GLOBALS['link']->error);


        if($result->num_rows == 0)
        {
            return -1;
        }
        return $result->fetch_array()[0];


    }

    function verify_session(){
        $query="SELECT id FROM sessions WHERE username='$this->username' AND token='$this->token'";
        $result = $this->link->query($query) or die($this->link->error);

        if($result->num_rows == 1){

            $this->id = $result->fetch_array()[0];

            return True;
        } else {
            return false;
        }
    }

    function gen_next_token(){
        $this->token = $this->gen_token($this->username,$this->token);
        setcookie("username", $this->username, time() + (3*60*60), "/");
        setcookie("token", $this->token, time()+(3*60*60),"/");

        $this->update_database();
    }

    function update_database(){
        $query = "UPDATE sessions SET token='$this->token' WHERE username='$this->username'";
        $result = $this->link->query($query) or die($this->link->error());

    }

    function gen_token($username,$data){
        $string = $data.$username.time();
        return hash("sha256",$data.$string,false);
    }

    function delete_sessions(){
        setcookie("username", "", time()-3600, "/");
        setcookie("token", "", time()-3600, "/");
        $this->loggedout=True; //so we know when something has gone wrong and they've been logged out

    }

    function make_tokens($user){
        $this->username=$this->link->real_escape_string($user);
        $random = random_int(100000,999999);
        $this->token=$this->gen_token($this->username,$random);
    }

    function login($user){
        $this->make_tokens($user);
        $this->update_database();
        setcookie("username", $this->username, time() + (3*60*60), "/");
        setcookie("token", $this->token, time()+(3*60*60),"/");
        $this->valid = $this->verify_session();
    }

    function register($user){
        $this->make_tokens($user);

        $query = "INSERT INTO sessions (username,token) VALUES ('$this->username','$this->token')";
        $result = $this->link->query($query) or die($this->link->error);
    }

    function get($item){
        $item = $this->link->real_escape_string($item);

        $query = "SELECT value FROM session_variables WHERE userid='$this->id' AND name='$item'";

        $result = $this->link->query($query) or die($this->link->error);
        if($result->num_rows == 1){
            return $result->fetch_array()[0];
        }
        return -1;
    }

    function has_entry($item){
        $item = $this->link->real_escape_string($item);

        $query = "SELECT value FROM session_variables WHERE userid='$this->id' AND name='$item'";

        $result = $this->link->query($query) or die($this->link->error);
        if($result->num_rows == 1){
            return True;
        }
        return False;
    }

    function add($item,$value){
        $value=$this->link->real_escape_string($value);
        $item=$this->link->real_escape_string($item);

        if($this->has_entry($item)){
            $query = "UPDATE session_variables SET value='$value' WHERE userid='$this->id' AND name='$item'";
        } else {
            $query = "INSERT INTO session_variables (userid,name,value) VALUES ('$this->id','$item','$value')";
        }

        $result = $this->link->query($query) or die($this->link->error);
    }

    function remove($item){
        $item=$this->link->real_escape_string($item);

        $query = "DELETE FROM session_variables WHERE userid='$this->id' AND name='$item'";

        $result = $this->link->query($query) or die($this->link->error);

    }
}

?>
