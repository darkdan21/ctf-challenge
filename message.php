<?php
include_once("session.php");
include_once("header.php");

$userid = $session->get_user_id();

$mail = new message();
$mail->get_message($_GET['id']);
$messageid = $mail->toid;

if($messageid == $userid && $session->valid==1)
{
    if($_GET['action'] == "read")
    {

        echo "<a class='replybutton' href='message.php?action=reply&id=".$_GET['id']."'> Reply</a><br>";


        $mail->seen();
        echo "<br><div class='post'><div class='postheader'>To: $mail->touser";
        echo "<br>From: $mail->fromuser";
        echo "<br>Date: $mail->date</div>";
        echo "<br>$mail->content<br><br></div>";


    }
    if($_GET['action'] == "reply"){
        if(isset($_POST['message'])){
            $mail->reply($_POST['message']);
            echo "<br><div class='label'>Message sent successfully</div>";
        } else {
            $mail->seen();
            echo "<div class='label'>To: $mail->fromuser";
            echo "<br>From: $mail->touser</div><br><br><br>";

?>

<form action="message.php?action=reply&id=<?php echo $_GET['id'] ?>" method="post">
<textarea name="message" rows=10 cols=40></textarea><br>
<input type="submit" class='foruminput' name="submit" value="Submit">
</form>

<?php
        }
    }
}



?>
