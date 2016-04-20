<?php
$link = new mysqli("localhost", "root", "cheese12345", "forum");

class board{

    function get_forums(){
        $query = "SELECT group_concat(id) FROM forums";
        $result = do_query($query);

        $result = explode(",",$result->fetch_array()[0]);

        return $result;   
    }
}

class forum{
    var $id;
    var $name;
    function get_forum($id){
        $this->id = escape($id);
        $query = "SELECT name FROM forums WHERE id='$this->id'";
        $result = do_query($query);
        $this->name = $result->fetch_array()[0];
    }
    function create_forum($name){
        $this->name = escape($name);
        $query = "INSERT INTO forums (name) VALUES ('$this->name')";
        do_query($query);
        $this->id = get_last_id();

    }
}

$forum = new forum();
$forum->create_forum("hiya");

function do_query($query){
    $result = $GLOBALS['link']->query($query) or die($GLOBALS['link']->error);

    return $result;
}

function escape($string){
    return htmlspecialchars($GLOBALS['link']->real_escape_string($string));
}

function get_last_id(){
    return $GLOBALS['link']->insert_id;
}
?>
