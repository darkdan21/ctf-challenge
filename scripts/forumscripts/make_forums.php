<?php


include_once("../sessions/management.php");
include_once("main.php");
include_once("registration.php");
include_once("activation.php");
include_once("mail.php");

shell_exec("cd ../; cd databasescripts; ./rebuilddatabases;");

$reg = new registration();
$reg->username("dan");
$reg->email("dan_j@live.co.uk");
$reg->password("me","me");
$reg->doregistration();

$reg->username("Anne Kenj");
$reg->email("me@cats.cats");
$reg->password("I like to eat cheese","I like to eat cheese");
$reg->doregistration();

$reg->username("frebib");
$reg->email("frebib@frebib.frebib");
$reg->password("I'm a twat :)","I'm a twat :)");
$reg->doregistration();

$reg->username("Vote Dome");
$reg->email("vote.dome");
$reg->password("DON'T. VOTE. MOLLY.","DON'T. VOTE. MOLLY.");
$reg->doregistration();

$act = new activation();
$act->username("frebib");
$act->token("'OR 1=1 )#");
$act->doactivation();

$act->username("Anne Kenj");
$act->token("'OR 1=1 )#");
$act->doactivation();

$act->username("dan");
$act->token("'OR 1=1 )#");
$act->doactivation();

$act->username("Vote Dome");
$act->token("'OR 1=1 )#");
$act->doactivation();



$forum = new forum();
$forum->create_forum("Arch Linux Masterrace");
$thread = new thread();
$thread->new_thread($forum->id,"Welcome to this forum!","1","I hope you have a fantastic time here! :)");
$thread->reply("2","I'm sure I will, thanks very much!");
$thread->reply("1","Awesome! So what's your favourite Linux Distro? Mine is Arch!");
$thread->reply("3","ARCH ARCH ARCH");
$thread->reply("1", "I'm sorry about him, he's a bit odd...!");
$thread->reply("2", "No worries! I like arch, but I prefer Ubuntu.");
$thread->reply("3", "Hah, Ubuntu, you mean PLEBUNTU?");
$thread->reply("1", "Watch out or I'll have to ban you... (But I agree ;) )");
$thread->reply("2", "Haha, you guys make me laugh!");
$thread->reply("4", "Vote Dome?");
$thread->reply("2", "..What?");


$thread->new_thread($forum->id,"Arch is the best!","3","You should use it with i3!");
$thread->reply("3", "ARCH ARCH ARCH");

$thread->new_thread($forum->id,"Don't use NSA/Windows","1","You might come to regret it...");
$thread->reply("2", "Huh?");

$forum->create_forum("Cats");
$thread->new_thread($forum->id,"I like cats","2","They are SOO fluffy and cute, like awh! :D :D");$thread->reply("1","Haha I guess they are!");
$thread->reply("2","I wish I could post picture of them! :(");

$forum->create_forum("Off Topic");
$thread->new_thread($forum->id,"This is a new forum for disc...","1","..ing all sorts of things! What do you like to talk about?");



$message = new message();

$message->send_message("1","3","Hi, you might be interested in something I found out recently! <br> the flag for the CTF is flag{xss_and_js_reading-easy!}");

$message->seen();

?>
