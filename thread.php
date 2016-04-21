<?php
include_once("session.php");
include_once("header.php");
include_once("scripts/forumscripts/main.php");
$posterror = "";

if(isset($_GET['new'])){

    if(isset($_POST['name']) && isset($_POST['post']) && $session->valid==1){
        if($_POST['name'] == "")
        {
            $posterror = "Thread name cannot be blank";
            new_post($posterror);
            die();
        }
        $thread = new thread();

        $id = $thread->new_thread($_GET['new'],$_POST['name'],$session->get_user_id(),$_POST['post']);

        echo "<br><br>Posted succesfully! Goto <a href='thread.php?thread=$id'>thread.</a>";
        die();

    }
    new_post($posterror);
    die();
}

function new_post($posterror){

?>
<br><br>
<form action="thread.php?new=<?php echo $_GET['new']; ?>" method="post">
Thread name: <input type="text" name="name" <?php if(isset($_POST['name'])){echo "value=".$_POST['name'];} ?>><?php echo $posterror; ?><br>
<textarea name="post" rows=10 cols=40><?php if(isset($_POST['post'])){echo $_POST['post'];} ?></textarea><br>
<input type="submit" name="submit" value="Submit">
</form>

<?php
}

?>
