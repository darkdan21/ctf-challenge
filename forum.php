<?php
include_once("session.php");
include_once("header.php");
include_once("scripts/forumscripts/main.php");

if(!isset($_GET['forum'])){
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'index.php';
    header("Location: http://$host$uri/$extra");
}
$forum = new forum();
$forum->get_forum($_GET['forum']);

if($forum->name==""){
    echo "<br>This forum doesn't exist!";
    die();
}
$thread = new thread();
$threadids = $forum->list_threads();
if($threadids[0]==""){
    echo "<br>No threads found.<br>";
}else{
    echo "<br>Threads in this forum:<br>";


    foreach($threadids as $threadid){
        $thread->get_thread($threadid);

        echo "<a href=thread.php?thread=$threadid>$thread->threadname</a><br>";
    }
}
echo "<a href=thread.php?new=".$_GET['forum'].">New Thread</a>";

?>