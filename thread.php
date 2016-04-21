<?php
include_once("session.php");
include_once("header.php");
include_once("scripts/forumscripts/main.php");
$posterror = "";

if(isset($_GET['new']) && $session->valid==1){

    if(isset($_POST['name']) && isset($_POST['post'])){
        if($_POST['name'] == "")
        {
            $posterror = "<div class='error'>Thread name cannot be blank</div>";
            new_thread($posterror);
            die();
        }
        $thread = new thread();

        $id = $thread->new_thread($_GET['new'],$_POST['name'],$session->get_user_id(),$_POST['post']);

        echo "<br><br><div class='label'>Posted successfully! Goto <a href='thread.php?thread=$id'>thread</a></div>";
        die();

    }
    new_thread($posterror);
    die();
}

if(isset($_GET['thread']) && isset($_POST['post'])){
    if($session->valid==1){
        $post = new post();

        $post->new_post($session->get_user_id(),$_GET['thread'],$_POST['post']);
    }
}

if(!isset($_GET['thread'])){
    die();
}
$thread = new thread();

$thread->get_thread($_GET['thread']);
if($thread->threadname == ""){
    echo "<br>Thread not found<br>";
    die();
}
echo "<div class='label'><br>Thread: ".$thread->threadname." - <a href=forum.php?forum=".$thread->forumid.">".((new forum())->get_forum($thread->forumid))->name."</a></div><br><br><br>";

$post = new post();
$postids = $thread->list_posts();
foreach($postids as $postid){
    $post->get_post($postid);
    echo "<div class='post'><div class='postheader'>".get_user_from_id($post->userid)." - ".$post->date;
    echo "</div><br>".$post->content;
    echo "</div><br>";

}

if($session->valid==1){
    echo "<br>";
?>
<form action="thread.php?thread=<?php echo $_GET['thread']; ?>" method="post">
<textarea name="post" rows=10 cols=40></textarea><br>
<input type="submit" name="submit"class="foruminput" value="Submit">
</form>

<?php
}


function new_thread($posterror){
?>
<br><br>
<form action="thread.php?new=<?php echo $_GET['new']; ?>" method="post">
<div class="label">Thread name:</div><br> <br><input type="text" class="foruminput" name="name" <?php if(isset($_POST['name'])){echo "value=".$_POST['name'];} ?>><?php echo $posterror; ?><br><br>
<textarea name="post" rows=10 cols=40><?php if(isset($_POST['post'])){echo $_POST['post'];} ?></textarea><br>
<input type="submit" class="foruminput" name="submit" value="Submit">
</form>

<?php
}

?>
