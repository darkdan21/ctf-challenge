<?php
include_once("session.php");
include_once("header.php");

if(isset($_GET['state']) && $_GET['state'] == "success")
{
    echo "Registered succesfully, please check your emails for the registration key.<br>
        <br>
        ERROR: Email not sent, please go to the <strong><a href='activation.php?username=".$_GET['username']."'>activation</a></strong> page and activate your account manually.";
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
                    $genericerror = "An error occurred, please try again later.";

                    if($_GET['username'] == ""){
                        $namerror = "Please enter a username.";
                        $genericerror = "";
                    }
                    if($_GET['email'] == ""){
                        $emailerror = "Please enter an email.";
                        $genericerror = "";
                    }

                }

                if(($status-4)>=0){
                    $namerror = "This username was already taken";
                    $status-=4;
                }
                if(($status-2)>=0){
                    $emailerror = "This email was already taken";
                    $status-=2;
                }
                if(($status-1)>=0){
                    $passworderror = "The passwords do not match";
                    $status-=1;
                }
            }
        }

?>
<br>Registration<br><br>

<form action="registration_handler.php" method="post">
Username: <input type="text" name="username" <?php if(isset($_GET['username'])){ echo "value=".$_GET['username'];} ?> ><?php echo $namerror; ?> <br>
    Email: <input type="text" name="email" <?php if(isset($_GET['email'])){ echo "value=".$_GET['email'];} ?> ><?php echo $emailerror; ?> <br> 
    Password: <input type="password" name="pass1"><?php echo $passworderror; ?> <br>
    Repeat Password: <input type="password" name="pass2"><br>
    <input type="submit" value="Submit">
</form>
<?php
        echo $genericerror;
    }
}
?>
