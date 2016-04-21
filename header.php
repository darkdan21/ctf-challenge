<?php
include_once("scripts/forumscripts/mail.php");


if($session->valid == 1){
    echo "logged in";
    $mailcheck = new mailcheck(get_id_from_user($session->username));
    $unreadcount = count($mailcheck->unread());
    $mailtext = ($unreadcount == 0 ? "messages" : "messages[$unreadcount unread]");
?>
    <a href="logout.php">logout</a>
    <a href="messages.php"><?php echo $mailtext ?></a>
<?php
} else {
    echo "not logged in :(";
?>
<a href="login.php">login</a>
<a href="register.php">register</a>
<a href="activation.php">activate</a>
<?php
}
?>


