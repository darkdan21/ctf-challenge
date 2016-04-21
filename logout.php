<?php
include_once("session.php");
if($session->valid == true){
    $session->delete_sessions();
    header("Refresh:0");
}

include_once("header.php");
if($session->valid == false){
    echo "<br><div class='label'>You have been logged out</div>";
}
?>
