<?php
include_once("session.php");
include_once("header.php");
include_once("scripts/forumscripts/main.php");

$board = new board();

$forumids = $board->list_forums();
echo "<br><div class='label'>Forums:</div><br>";
$forum = new forum();
foreach($forumids as $forumid){
    $forum->get_forum($forumid);

    echo "<a class='forumlink' href=forum.php?forum=$forumid>$forum->name</a><br><br>";
}

?>
