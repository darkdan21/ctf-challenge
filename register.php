<?php
include_once("session.php");
include_once("header.php");

if(isset($_GET['state']) && $_GET['state'] == "success")
{
    echo "<div class='label'>Registered succesfully, please check your emails for the registration key.<br>
        <br>
        ERROR: Email not sent, please go to the <strong><a href='activation.php?username=".$_GET['username']."'>activation</a></strong> page and activate your account manually.</div>";
} else {

    if($session->valid == 1)
    {
        echo "<br>You are already logged in!";
    } else {

        $namerror = "";
        $emailerror = "";
        $passworderror = "";
        $genericerror = "";
        if(isset($_GET['state']) && ($_GET['state'] == "fail")){
            if(isset($_GET['status'])){
                $status = $_GET['status'];

                if($status == 0){
                    $genericerror = "<div class='error'>An error occurred, please try again later.</div>";

                    if($_GET['username'] == ""){
                        $namerror = "<div class='error'>Please enter a username.</div>";
                        $genericerror = "";
                    }
                    if($_GET['email'] == ""){
                        $emailerror = "<div class='error'>Please enter an email.</div>";
                        $genericerror = "";
                    }

                }

                if(($status-4)>=0){
                    $namerror = "<div class='error'>This username was already taken</div>";
                    $status-=4;
                }
                if(($status-2)>=0){
                    $emailerror = "<div class='error'>This email was already taken</div>";
                    $status-=2;
                }
                if(($status-1)>=0){
                    $passworderror = "<div class='error'>The passwords do not match</div>";
                    $status-=1;
                }
            }
        }

?>
<br><div class='label'>Registration</div><br><br>

<form action="registration_handler.php" method="post">
Username: <input type="text" name="username" <?php if(isset($_GET['username'])){ echo "value=".$_GET['username'];} ?> ><?php echo $namerror; ?> <br><br>
    Email: <input type="text" name="email" <?php if(isset($_GET['email'])){ echo "value=".$_GET['email'];} ?> ><?php echo $emailerror; ?> <br><br> 
    Password: <input type="password" name="pass1"><?php echo $passworderror; ?> <br><br>
Repeat Password: <input type="password" name="pass2"><br><br>
    <input type="submit" value="Submit">
</form>
<?php
        echo $genericerror;
    }
}
?>
