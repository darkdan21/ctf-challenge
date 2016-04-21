<?php
include_once("session.php");
include_once("header.php");
include_once("scripts/forumscripts/mail.php");

?>

<?php

echo "<br>";
if($session->valid == 1){
    echo "<a class='button' style='width:120px'  href='newmessage.php'>New Message</a><br>";
    $mailcheck = new mailcheck(get_id_from_user($session->username));

    $mailcount = $mailcheck->message_count();
    $unreadcount = $mailcheck->unread_count();

    if($mailcount>0){
        if($unreadcount>0){
            echo "<div class='label'>You have $unreadcount new messages<br></div>";
        }
        echo "<br><div class='label'>Recieved Messages:</div><br><br>";
        get_messages($mailcheck);

    }else{
        echo "<div class='label'>You have no messages!</div>";
    }

    if($mailcheck->sent_count()>0){
        echo "<br><div class='label'>Sent Messages:</div><br><br>";
        output_sent_messages($mailcheck->sent());
    }



} else {
    echo "You are not logged in";
}


function get_messages($mailcheck){
    $messages = $mailcheck->get_all();
    output_messages($messages);

}
function output_sent_messages($messages){
    echo "<div class='messages'>";
    $message = new message();
    foreach($messages as $messageid){
        $message->get_message($messageid,"");
        echo "<div class='message'>";
        item($message->touser,"");
        item((($message->seen == 1) ? "Read" : "Unread"),"small");
        item($message->date,"");
        $content = htmlentities((strlen($message->content)>20)?substr($message->content,0,20)."...":$message->content);
        item("$content","");

        echo "</div>";
    }
    echo "</div>";

}
function output_messages($messages){
    echo "<div class='messages'>";
    $message = new message();
    foreach($messages as $messageid){
        $message->get_message($messageid);
        echo "<div class='message'>";
        item($message->fromuser,"");
        item((($message->seen == 1) ? "Read" : "Unread"),"small");
        item($message->date,"");
        $content = htmlentities((strlen($message->content)>20)?substr($message->content,0,20)."...":$message->content);
        item("<a href='message.php?action=read&id=$message->id'>$content</a>","");
        item("<a href='message.php?action=reply&id=$message->id'>reply</a>","small");

        echo "</div>";
    }
    echo "</div>";
}
function item($string, $class){
    echo "<div class='field $class'>$string</div>";
}
?>
