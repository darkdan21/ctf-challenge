<?php
include_once("session.php");
include_once("header.php");
include_once("scripts/forumscripts/mail.php");

?>

<style>
table,th, td {
    border: 1px solid black;
    border-collapse: collapse;

}
</style>

<?php

echo "<br>";
if($session->valid == 1){
    echo "<a href='newmessage.php'>New Message</a><br>";
    $mailcheck = new mailcheck(get_id_from_user($session->username));

    $mailcount = $mailcheck->message_count();
    $unreadcount = $mailcheck->unread_count();

    if($mailcount>0){
        if($unreadcount>0){
            echo "You have $unreadcount new messages<br>";
        }
        echo "Recieved Messages:";
        get_messages($mailcheck);

    }else{
        echo "You have no messages!";
    }

    if($mailcheck->sent_count()>0){
        echo "Sent Messages:";
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
    echo "<table style='width:90%'>";
    $message = new message();
    foreach($messages as $messageid){
        $message->get_message($messageid);
        echo "<tr>";
        item($message->touser);
        item((($message->seen == 1) ? "Read" : "Unread"));
        item($message->date);
        $content = htmlentities((strlen($message->content)>20)?substr($message->content,0,20)."...":$message->content);
        item("$content");

        echo "</tr>";
    }
    echo "</table>";

}
function output_messages($messages){
    echo "<table style='width:90%'>";
    $message = new message();
    foreach($messages as $messageid){
        $message->get_message($messageid);
        echo "<tr>";
        item($message->fromuser);
        item((($message->seen == 1) ? "Read" : "Unread"));
        item($message->date);
        $content = htmlentities((strlen($message->content)>20)?substr($message->content,0,20)."...":$message->content);
        item("<a href='message.php?action=read&id=$message->id'>$content</a>");
        item("<a href='message.php?action=reply&id=$message->id'>reply</a>");

        echo "</tr>";
    }
    echo "</table>";
}
function item($string){
    echo "<td>$string</td>";
}
?>
