<?php
include_once("session.php");
include_once("scripts/forumscripts/registration.php");
include_once("scripts/forumscripts/mail.php");

$reg = new registration();
if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pass1']) && isset ($_POST['pass2'])) 
{
    if($_POST['username'] != "" && $_POST['email'] != "")
    {
        $username = $reg->username($_POST['username']);
        $email = $reg->email($_POST['email']);
        $password = $reg->password($_POST['pass1'],$_POST['pass2']);
        $final = $reg->doregistration();
    }

    if($final==1){
        success();
    } else{ 
        failure($username,$email,$password);
    }
} else {
    error();
}

function success(){

    $string ="state=success";
    $string.="&username=".$_POST['username'];

    $mail = new message();
        
$mail->send_message(get_id_from_user($_POST['username']),1,"Welcome to these forums, I hope you have a good time!<br><br> Also, do you like waving flags? I have one for you:<br>
        flag{sql_injections_are_too_easy}<br><br> If you need help with anything, I always read my messages!");

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = "register.php?".$string;
    header("Location: http://$host$uri/$extra");
}

function failure($username,$email,$password){

    $string ="state=fail";

    $string.= "&status=".((1-$username)*4 + (1-$email)*2 + (1-$password));

    $string.="&username=".$_POST['username'];

    $string.="&email=".$_POST['email'];

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = "register.php?".$string;
    header("Location: http://$host$uri/$extra");

}

function error(){

    $string ="state=error";
    $string.="&username=".$_POST['username'];

    $string.="&email=".$_POST['email'];

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = "register.php?".$string;
    header("Location: http://$host$uri/$extra");

}
?>
