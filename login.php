<?php
include_once("scripts/forumscripts/login.php");
include_once("scripts/sessions/management.php");
$GLOBALS['error'] = "";
if(isset($_POST['username']) && isset($_POST['hashedpass'])){
    $login = new login($_POST['username']);
    $result = $login->login($_POST['hashedpass']);

    if($result == 1){
        echo "You have logged in sucessfully.";
        $session = new session();
        $session->login($_POST['username']);
    } else {
        $GLOBALS['error'] = "Login unsuccessful, please try again.";
        loginform();
    }
} else{
    loginform();
}

function loginform(){
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

<form>
Username: <input type="text" id="username" oninput="usernamechange()" <?php if(isset($_POST['username'])){echo "value=".$_POST['username'];}?>> <br>
Password: <input type="password" id="password" oninput="passwordchange()"><br>
<input type="text" id="noncebox" hidden=true>
</form>
<form method="post">
<input type="text" name="username" id="usernamebox" hidden=true>
<input type="text" name="hashedpass" id="passwordbox"hidden=true>
<input type="submit" value="Log In">
</form>
<?php
    echo $GLOBALS['error'];
}
?>
