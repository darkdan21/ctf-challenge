<?php

class activation{

    var $link;
    var $username;
    var $id;
    var $token;
    
    function __construct(){
        $this->link = new mysqli("localhost", "root", "cheese12345", "forum");
    }

    function username($username){
        $username = $this->link->real_escape_string($username);

        $query="SELECT active,id FROM users WHERE username='$username'";

        $result = $this->link->query($query) or die($this->link->error);

        $result = $result->fetch_array();

        $active = $result[0];
        $id = $result[1];


        if($active == 0){
            $this->username = $username;
            $this->id = $id;
            return True;
        }
        return False;
    }

    function token($token){

        if(!$this->checkstring($token)){
           return False;
        }

        
        $userid = $this->id;

        $query = "SELECT * FROM registration_keys WHERE userid='$userid' AND (token='$token')";


        $result = $this->link->query($query) or die($this->link->error);


         if($result->num_rows == 1){
             $this->token=$token;
             return True;
         }
        return False;

    }

    function doactivation(){

        if($this->token != "" && $this->username != "" && $this->id != ""){
            $query = "UPDATE users SET active=1 WHERE id='$this->id'";

            $result = $this->link->query($query) or die($this->link->error);


            return True;
        }

        return False;
    }

    function checkstring($string){
        //I want people to be able to mysql inject here, but not do anything crazy, so some safeguards are in place.

        $badwords = array("SELECT", "UNION", "DROP", "INSERT", "SLEEP", "DELETE", "CHAR", "ALTER", "BEGIN", "CREATE", "END", "CAST", "CONVERT", "CURSOR", "EXEC", "FETCH", "INTO", "KILL", "OPEN", "IF", "NULL", "DATABASE", "TABLE", "TRUNCATE", "LIKE", "CASE", "WHEN", "CHAR", "WHERE", "%", "TIME", "DATE", "LOCK", "FORMAT", "FROM", "ALL", "ANY", "CONCURRENT", "WRITE", "READ", "OUT", "SET", "SCHEMA", "USER", "INTO", "LOAD", "FILE", "LENGTH", "<",">","SUBSTRING","BENCHMARK","0x","HAVING","SUM","CONCAT","DELAY");

        foreach($badwords as $badword){
            if(strpos($string, $badword) !== false){
                return False;
            }
        }
        return True;
    }
}

//$activation = new activation();

//echo "<br>username: ".$activation->username("dan2");
//echo "<br>token: ".$activation->token("aT1n5ina00");
//echo "<br>final: ".$activation->doactivation();

?>
