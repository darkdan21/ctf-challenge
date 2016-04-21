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
        $mail->seen();
        echo "<br>To: $mail->touser";
        echo "<br>From: $mail->fromuser";
        echo "<br>Date: $mail->date";
        echo "<br><br>$mail->content";
    }
    if($_GET['action'] == "reply"){
        if(isset($_POST['message'])){
            $mail->reply($_POST['message']);
            echo "<br>Message sent successfully";
        } else {
            $mail->seen();
            echo "<br>To: $mail->fromuser";
            echo "<br>From: $mail->touser";
        
?>

<form action="message.php?action=reply&id=<?php echo $_GET['id'] ?>" method="post">
<textarea name="message" rows=10 cols=40></textarea><br>
<input type="submit" name="submit" value="Submit">
</form>

<?php
        }
    }
}



?>
