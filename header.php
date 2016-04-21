<?php
include_once("scripts/forumscripts/mail.php");


if($session->valid == 1){
    $mailcheck = new mailcheck(get_id_from_user($session->username));
    $unreadcount = $mailcheck->unread_count();
    $mailtext = ($unreadcount == 0 ? "Messages" : "Messages[$unreadcount unread]");
?>
    <a href="index.php">Index</a>
    <a href="logout.php">Logout</a>
    <a href="messages.php"><?php echo $mailtext ?></a>
<?php
    echo " [Logged In]";
} else {
?>
<a href="index.php">Index</a>
<a href="login.php">Login</a>
<a href="register.php">Register</a>
<a href="activation.php">Activate</a>
<?php
    echo " [Logged Out]";
}
?>


