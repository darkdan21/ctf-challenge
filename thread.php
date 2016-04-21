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
            new_thread($posterror);
            die();
        }
        $thread = new thread();

        $id = $thread->new_thread($_GET['new'],$_POST['name'],$session->get_user_id(),$_POST['post']);

        echo "<br><br>Posted succesfully! Goto <a href='thread.php?thread=$id'>thread.</a>";
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


$thread = new thread();

$thread->get_thread($_GET['thread']);
if($thread->threadname == ""){
    echo "<br>Thread not found<br>";
    die();
}
echo "<br>Thread: ".$thread->threadname."<br>";

$post = new post();
$postids = $thread->list_posts();
foreach($postids as $postid){
    $post->get_post($postid);
    echo "<br>".get_user_from_id($post->userid)." - ".$post->date;
    echo "<br>".$post->content;

}

if($session->valid==1){
    echo "<br>";
?>
<form action="thread.php?thread=<?php echo $_GET['thread']; ?>" method="post">
<textarea name="post" rows=10 cols=40></textarea><br>
<input type="submit" name="submit" value="Submit">
</form>

<?php
}


function new_thread($posterror){
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
