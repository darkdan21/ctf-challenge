<?php
include_once("session.php");
include_once("header.php");

if($session->valid==1)
{
    $userid = $session->get_user_id();

    $mailcheck = new mailcheck($userid);

    $mail = $mailcheck->unread();

    $unread = new message();

    foreach($mail as $message){

        $unread->get_message($message);
        if($unread->toid == $userid)
        {


            $unread->seen();
            echo "<br><div class='post'><div class='postheader'>To: $unread->touser";
            echo "<br>From: $unread->fromuser";
            echo "<br>Date: $unread->date</div>";
            echo "<br>$unread->content<br><br></div>";


        }
    }
}
?>
