<?php
include_once("scripts/forumscripts/registration.php");
include_once("scripts/forumscripts/activation.php");

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
    echo "Registration sucessful! Please activate your account.";

    $string ="state=success";

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = "register.php?".$string;
    header("Location: http://$host$uri/$extra");
}

function failure($username,$email,$password){

    $string ="state=fail";

    $string.= "&status=".($username*4 + $password*2 + $email);

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
