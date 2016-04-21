<?php
include_once("scripts/forumscripts/login.php");

if(isset($_GET['user'])){
    $login = new login($_GET['user']);
    echo $login->get_nonce();

 }else {
    echo "-1";
}

?>
