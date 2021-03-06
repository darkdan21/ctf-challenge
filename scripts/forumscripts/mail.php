<?php

$link = new mysqli("localhost", "root", "cheese12345", "forum");

class message{
    public $id;
    public $toid;
    public $fromid;
    public $touser;
    public $fromuser;
    public $seen;
    public $date;
    public $content;
    function get_message($id){
        $this->id = escape($id);
        $query = "SELECT toid,fromid,seen,date,content FROM messages WHERE id='$this->id'";

        $result=do_query($query);

        $result=$result->fetch_array();

        $this->toid=$result[0];
        $this->fromid=$result[1];
        $this->touser=get_user_from_id($result[0]);
        $this->fromuser=get_user_from_id($result[1]);
        $this->seen=$result[2];
        $this->date=$result[3];
        $this->content=$result[4];
    }

    function send_message($toid,$fromid,$content){
        $this->toid=escape($toid);
        $this->fromid=escape($fromid);
        $this->content=mysql_escape($content);

        $this->fromuser=get_user_from_id($fromid);
        $this->touser=get_user_from_id($toid);

        $this->date = get_date();
        $this->seen = 0;

        $query = "INSERT INTO messages (toid,fromid,seen,date,content) VALUES ('$this->toid','$this->fromid','$this->seen','$this->date','$this->content')";

        $result = do_query($query);

        $this->id = get_last_id();
    }

    function reply($content){
        $this->seen();

        $this->send_message($this->fromid,$this->toid,$content);
    }

    function seen(){
        $query = "UPDATE messages set seen=1 WHERE id='$this->id'";

        do_query($query);
    }



}


class mailcheck{
    public $id;

    function __construct($id){
        $this->id = escape($id);
    }

    function unread(){
        $query = "SELECT group_concat(id ORDER BY id DESC) from messages WHERE toid='$this->id' AND seen='0'";

        $result = do_query($query);
        $result = explode(",",$result->fetch_array()[0]);
        return $result;
    }

    function sent(){
        $query = "SELECT group_concat(id ORDER BY id DESC) from messages WHERE fromid='$this->id'";

        $result = do_query($query);
        $result = explode(",",$result->fetch_array()[0]);
        return $result;
    }

    function sent_count(){
        $query = "SELECT id FROM messages WHERE fromid='$this->id'";

        $result = do_query($query);

        return $result->num_rows;
    }

    function unread_count(){
        $query = "SELECT id FROM messages WHERE toid='$this->id' AND seen='0'";

        $result = do_query($query);

        return $result->num_rows;
    }

    function read_count(){
        $query = "SELECT id FROM messages WHERE toid='$this->id' AND seen='1'";

        $result = do_query($query);

        return $result->num_rows;

    }

    function message_count(){
        $query = "SELECT id FROM messages WHERE toid='$this->id'";

        $result = do_query($query);

        return $result->num_rows;

    }

    function read(){
        $query = "SELECT group_concat(id ORDER BY id DESC) from messages WHERE toid='$this->id' AND seen='1'";

        $result = do_query($query);
        $result = explode(",",$result->fetch_array()[0]);
        return $result;

    }
    function get_all(){
        $query = "SELECT group_concat(id ORDER BY id DESC) from messages WHERE toid='$this->id'";

        $result = do_query($query);
        $result = explode(",",$result->fetch_array()[0]);
        return $result;
    }

    function get_unread(){

        $unread = $this->unread();



        if(count($unread)==0){
            return -1;
        }

        $mail = new message();
        $mail->get_message($unread[0]);

        return $mail;
    }
}

function get_user_from_id($id){
    $id = escape($id);
    $query = "SELECT username FROM users WHERE id='$id'";

    $result = do_query($query);

    if($result->num_rows == 0)
    {
        return -1;
    }
    return $result->fetch_array()[0];
}

function get_id_from_user($username){
    $username = escape($username);
    $query = "SELECT id FROM users WHERE username='$username'";

    $result = do_query($query);

    if($result->num_rows == 0)
    {
        return -1;
    }
    return $result->fetch_array()[0];

}

function do_query($query){
    $result = $GLOBALS['link']->query($query) or die($GLOBALS['link']->error);

    return $result;
}

function escape($string){
    return htmlentities($GLOBALS['link']->real_escape_string($string));
}
function mysql_escape($string){
    return $GLOBALS['link']->real_escape_string($string);
}

function get_last_id(){
    return $GLOBALS['link']->insert_id;
}

function get_date(){
    return date("H:i:s d/m/Y");
}

?>
