<?php
include_once("session.php");
include_once("header.php");

$personerror = "";

if(isset($_POST['to'])&&isset($_POST['message'])){
    $message = new message();

    $to = get_id_from_user($_POST['to']);
    $from = $session->get_user_id();

    if($to == -1){
        $personerror = "<div class='error'>This username is not registered</div>";
        messageform($personerror); 
    } else{
        $message->send_message($to,$from,$_POST['message']);
        echo "<br><div class='label'>Message sent sucessfully</div>";
    }
} else {
    messageform($personerror);
}

function messageform($personerror){
?>
<form  method="post">
<div class='label'>To:</div> <br><input type="text" name="to" class='foruminput'
<?php if(isset($_POST['to'])){echo "value=".$_POST['to'];} ?>
>
<?php echo $personerror; ?>
<br>
<textarea name="message" rows=10 cols=40>
<?php
    if(isset($_POST['message'])){echo $_POST['message'];}
?>
</textarea><br>
<input type="submit" name="submit" value="Submit">
</form>
<?php
}
?>
