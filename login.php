<?php
include_once("session.php");
include_once("scripts/forumscripts/login.php");

if(isset($_POST['username']) && isset($_POST['hashedpass'])){
    $login = new login($_POST['username']);
    $result = $login->login($_POST['hashedpass']);
    if($result == 1){

        $session->login($_POST['username']);
        setcookie("password",$_POST['hashedpass'],time()+36000);
    } 
}
include_once("header.php");
$GLOBALS['error'] = "";
if(isset($_POST['username']) && isset($_POST['hashedpass'])){

    if($result == 1){
        echo "<br><div class='label'>You have been logged in sucessfully</div>";
    } else {
        $GLOBALS['error'] = "<div class='error'>Login unsuccessful, please try again.</div>";
        loginform($session);
    }
} else{
    loginform($session);
}

function loginform($session){

    if($session->valid==1){
        echo "<br>You are already logged in!";
    }
    else
    {
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="hash.js"></script>

        <script>
        function usernamechange(){
            $("#usernamebox").val($("#username").val());
            s = $.get("user_nonce.php?user="+$("#usernamebox").val(),function(data){changenonce(data)});
        }
        function changenonce(data){
            $("#noncebox").val(data);
            $("#passwordbox").val(shufflehash($("#password").val(),$("#noncebox").val()));
        }
        function passwordchange(){
            $("#passwordbox").val(shufflehash($("#password").val(),$("#noncebox").val()));
        }
        </script>

<br><div class="label">Login</div>
<br><br>
<form id="form">
Username: <input type="text" id="username" oninput="usernamechange()" <?php if(isset($_POST['username'])){echo "value=".$_POST['username'];}?>> <br><br>
Password: <input type="password" id="password" oninput="passwordchange()">
<input type="text" id="noncebox" hidden=true>
</form>
<form method="post">
<input type="text" name="username" id="usernamebox" hidden=true>
<input type="text" name="hashedpass" id="passwordbox"hidden=true>
<input type="submit" value="Log In" id="loginbutton">
</form>
<?php
        echo $GLOBALS['error'];
    }
}
?>
