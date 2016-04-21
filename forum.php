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
    echo "<br><div class='label'>No threads found.</div><br>";
}else{
    echo "<br><div class='label'>Threads in this forum:</div><br>";


    foreach($threadids as $threadid){
        $thread->get_thread($threadid);

        echo "<a class='forumlink' href=thread.php?thread=$threadid>$thread->threadname</a><br><br>";
    }
}
if($session->valid == 1){

    echo "<a class='forumlink new' href=thread.php?new=".$_GET['forum'].">New Thread</a>";
}

?>
