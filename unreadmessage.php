<?php
include_once("session.php");
include_once("header.php");

$userid = $session->get_user_id();

$mailcheck = new mailcheck($userid);

$mail = $mailcheck->get_unread();

$messageid = $mail->toid;

if($messageid == $userid && $session->valid==1)
{

        echo "<a class='replybutton' href='message.php?action=reply&id=".$messageid."'> Reply</a><br>";


        $mail->seen();
        echo "<br><div class='post'><div class='postheader'>To: $mail->touser";
        echo "<br>From: $mail->fromuser";
        echo "<br>Date: $mail->date</div>";
        echo "<br>$mail->content<br><br></div>";


    }
?>
