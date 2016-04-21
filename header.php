<?php

if($session->valid == 1){
    echo "logged in";
?>
    <a href="logout.php">logout</a>
<?php
} else {
    echo "not logged in :(";
?>
<a href="login.php">login</a>
<a href="register.php">register</a>
<a href="activation.php">activate</a>
<?php
}
?>


