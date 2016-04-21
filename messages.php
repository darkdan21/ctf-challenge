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

    $mailcheck = new mailcheck(get_id_from_user($session->username));

    $mailcount = count($mailcheck->read());
    $unreadcount = count($mailcheck->unread());

    if($mailcount>0){
        if($unreadcount>0){
            echo "You have $unreadcount new messages<br>";
        }
        get_messages($mailcheck);

    }else{
        echo "You have no messages!";
    }

} else {
    echo "You are not logged in";
}


function get_messages($mailcheck){
    $messages = $mailcheck->get_all();
    output_messages($messages);

}

function output_messages($messages){
    echo "<table style='width:90%'>";
    $message = new message();
    foreach($messages as $messageid){
        $message->get_message($messageid);
        echo "<tr>";
        item($message->touser);
        item((($message->seen == 1) ? "Read" : "Unread"));
        item($message->date);
        item($message->content);
        echo "</tr>";
    }
    echo "</table>";
}
function item($string){
    echo "<td>$string</td>";
}
?>
