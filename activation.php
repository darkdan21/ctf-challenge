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
        $GLOBALS['usererror'] = "<div class='error'>That username cannot be activated.</div>";
    } else if($tokenstatus != 1){
        $GLOBALS['tokenerror'] = "<div class='error'>This token is incorrect.</div>";
    }

    if($tokenstatus == 1 && $userstatus == 1 && $status == 0){
        $GLOBALS['generalerror'] = "<div class='error'>An error occurred, please try again later.</div>";
    }

    if($status+$userstatus+$tokenstatus == 3){
        echo "<div class='label'>Activation successful!";
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
?><br>
<div class='label'>Activation</div><br><br>
<form method ="get">
Username: <input type="text" name="username" <?php if(isset($_GET['username'])){ echo "value=".$_GET['username'];}?> > <?php echo  $GLOBALS['usererror']; ?><br><br>
Token: <input type="text" name="token" <?php if(isset($_GET['token'])){ echo 'value="'.$_GET['token'].'"';}?> ><?php echo  $GLOBALS['tokenerror']; ?><br><br>

<input type="submit">
</form>

<?php
    }
}
?>
