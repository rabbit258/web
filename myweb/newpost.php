<?php
session_start();
header("Content-type:text/html;charset=utf-8");
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $con=mysqli_connect("localhost","root","root","myweb");
    mysqli_set_charset($con,"utf8");

    $author=$_SESSION["username"];
    $title=$_POST["title"];
    $content=$_POST["content"];
    $postime=date("Y-m-d h-i-s");
    $sql="insert into posts(title,author,content,last_time,new_time) values('$title','$author','$content','$postime','$postime')";
    mysqli_query($con,$sql);

    $sql="SELECT LAST_INSERT_ID()";
    $que=mysqli_query($con,$sql);
    $arr=mysqli_fetch_array($que);
    echo "<script>alert('发布成功');location.href='post.php?id='+'$arr[0]'</script>;";
}
?>
<!DOCTYPE html>
<html lang >
<head>
    <meta charset="UTF-8">
    <title>发帖</title>
    <link rel="stylesheet" href="asset/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/bootstrap-3.4.1-dist/css/mysetting.css">
    <script src="asset/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="asset/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">rabbit论坛</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
                <li><a>欢迎,<?php echo $_SESSION['username'] ?></a></li>
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> 主页</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">帖子</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" onsubmit="return check();" action="newpost.php" method="post" >
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="title" maxlength="20" placeholder="请输入帖子标题" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea style="width: 100%;height: 300px;resize: none"  placeholder="  请输入内容" name="content" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div style="text-align: center">
                                <button type="submit" class="btn btn-primary" >发布</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
