<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $reply_id=$_POST['reply_id'];
    $post_id=$_POST['post_id'];
    $author=$_POST['author'];
    $comment_time=date("Y-m-d h:i:s");
    $content=$_POST['content'];
    $floor=$_POST['floor'];

    $con=mysqli_connect('localhost','root','root','myweb');
    mysqli_set_charset($con,"utf8");

    $sql="insert into comment(reply_id,post_id,author,floor,comment_time,content) values ('$reply_id','$post_id','$author','$floor','$comment_time','$content')";
    $que=mysqli_query($con,$sql);

    $sql="update posts set last_time= '$comment_time' where post_id = $post_id";
    $que=mysqli_query($con,$sql);

    echo "<script> window.location.href='post.php?id='+'$post_id' </script>";
}