<head>
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<?php
include_once("scripts/forumscripts/mail.php");

echo "<div id='menu'>";
if($session->valid == 1){
    $mailcheck = new mailcheck(get_id_from_user($session->username));
    $unreadcount = $mailcheck->unread_count();
    $mailtext = ($unreadcount == 0 ? "Messages" : "Messages  [$unreadcount new]");
?>
    <a class="button"  href="index.php">Index</a>
    <a class="button"  href="logout.php">Logout</a>
    <a class="button"  href="messages.php"><?php echo $mailtext ?></a>
<?php
    echo " [Logged In]";
} else {
?>
<a class="button"  href="index.php">Index</a>
<a class="button"  href="login.php">Login</a>
<a class="button"  href="register.php">Register</a>
<a class="button"  href="activation.php">Activate</a>
<?php
    echo " [Logged Out]";
}
echo "</div>";
?>

