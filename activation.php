<?php
include_once("session.php");
include_once("header.php");
include_once("scripts/forumscripts/activation.php");
$usererror = "";
$tokenerror = "";
$generalerror = "";

if(isset($_GET['username']) && isset($_GET['token'])){
    $activation = new activation();
    $userstatus = $activation->username($_GET['username']);
    $tokenstatus = $activation->token($_GET['token']);
    $status = $activation->doactivation();




    if($userstatus != 1){
        $GLOBALS['usererror'] = "That username cannot be activated.";
    } else if($tokenstatus != 1){
        $GLOBALS['tokenerror'] = "This token is incorrect.";
    }

    if($tokenstatus == 1 && $userstatus == 1 && $status == 0){
        $GLOBALS['generalerror'] = "An error occurred, please try again later.";
    }

    if($status+$userstatus+$tokenstatus == 3){
        echo "Activation successful!";
    } else {
        activation_form($session);
    }

}else{
    activation_form($session);
}

function activation_form($session){
    if($session->valid){
        echo "<br>You are already logged in!";
    }else{
?>

<form method ="get">
Username: <input type="text" name="username" <?php if(isset($_GET['username'])){ echo "value=".$_GET['username'];}?> > <?php echo  $GLOBALS['usererror']; ?><br>
Token: <input type="text" name="token" <?php if(isset($_GET['token'])){ echo 'value="'.$_GET['token'].'"';}?> ><?php echo  $GLOBALS['tokenerror']; ?><br>

<input type="submit">
</form>

<?php
    }
}
?>
