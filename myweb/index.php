<?php
session_start();
if($_GET['act']=="logout")
{
    $_SESSION['username']='';
    ?>
<script>
    self.location.href="index.php";
</script>
<?php
    exit;
}
if(isset($_GET['page']))
    $page_cur=$_GET['page'];
else
    $page_cur=1;
header("Content-type:text/html;charset=utf-8");
$servername = "localhost";
$username = "root";
$password = "root";
$database= "myweb";
$con=mysqli_connect($servername,$username,$password,$database);
mysqli_set_charset($con,'utf8');

$page_show=5;
$all_sql="select count(*) from posts";
$all_que=mysqli_query($con,$all_sql);
$all_hand=mysqli_fetch_array($all_que);
$post_num=$all_hand[0];
$page_num=ceil($post_num/$page_show);

$start=($page_cur-1)*$page_show;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>首页</title>
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

            <?php
            if($_SESSION['username']=="")
            {
                ?>
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> 主页</a></li>
                <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li>
                <li><a href="register.php"><span class="glyphicon glyphicon-plane"></span> 注册</a></li>
                <?php
            }
            else
            {
                ?>
                <li><a>欢迎,<?php echo $_SESSION['username'] ?></a></li>
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> 主页</a></li>
                <li><a href="newpost.php"><span class="glyphicon glyphicon-pencil"></span> 发布</a></li>
                <li><a href="?act=logout"><span class="glyphicon glyphicon-log-out"></span> 注销</a></li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table class="table" style="table-layout: fixed;word-break: break-all">
                <caption>欢迎来到rabbit论坛</caption>
                <thead>
                <tr>
                    <th>标题</th>
                    <th>发帖人</th>
                    <th>最新回复时间</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
                    $sql="select * from posts order by last_time desc limit $start,$page_show";
                    $que=mysqli_query($con,$sql);
                        while($row=mysqli_fetch_array($que))
                        {
                            ?>
                                <tr class="success">
                                <td><a href="post.php?id=<?php echo $row['post_id'] ?>"><?php echo $row['title'] ?></a></td>
                                <td><?php echo $row["author"]?></td>
                                <td><?php echo $row["last_time"]?></td>
                            <?php
                        }
                    ?>
                </tr>
                </tbody>
            </table>
            <div style="text-align: center">
                <ul class="pagination">
                    <li><a class="<?php if($page_cur==1) echo "disabled btn";?>" href="<?php echo "$_SERVER[PHP_SELF]?page=".($page_cur-1)?>">&laquo;</a></li>
                    <?php
                    for($i=1;$i<=$page_num;$i++)
                        if($i==$page_cur)
                        {
                        ?>
                            <li class='active'><a href="<?php echo "$_SERVER[PHP_SELF]?page=".$i?>"> <?php echo $i;?></a></li>
                        <?php
                        }
                        else
                        {
                            ?>
                            <li><a href="<?php echo "$_SERVER[PHP_SELF]?page=".$i?>"> <?php echo $i;?></a></li>
                            <?php
                        }
                        ?>
                    <li><a class="<?php if($page_cur==$page_num) echo "disabled btn";?>" href="<?php echo "$_SERVER[PHP_SELF]?page=".($page_cur+1)?>">&raquo;</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>