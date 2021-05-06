<?php
session_start();
header("Content-type:text/html;charset=utf-8");

$post_id=$_GET['id'];
$con=mysqli_connect('localhost','root','root','myweb');
mysqli_set_charset($con,"utf8");

$sql="select title,author,new_time,content from posts where post_id = $post_id";
$que=mysqli_query($con,$sql);
$arr=mysqli_fetch_array($que);
$title=$arr['title'];
$author=$arr['author'];
$post_time=$arr['new_time'];
$content=$arr['content'];

if(isset($_GET['page_index']))
    $page_index=$_GET['page_index'];
else
    $page_index=1;
$per_page=5;
$sql="select count(*) from comment where post_id = '$post_id'";
$que=mysqli_query($con,$sql);
$arr=mysqli_fetch_array($que);
$total=$arr[0];
$num_page=ceil($total/$per_page);
$start=($page_index-1)*$per_page;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="asset/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/bootstrap-3.4.1-dist/css/mysetting.css">
    <script src="asset/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="asset/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
<script type="text/javascript">
    function judger(obj){
        reply_obj=obj.getAttribute("id");//全局变量
    }
    function sub(){
        var bu=document.getElementById("content");
        var reply_id=document.getElementById("reply_id")
        var fo=document.getElementById("myform");
        if(bu.value=="")
            bu.value="内容不能为空";
        else
        {
            reply_id.value=reply_obj;
            fo.submit();
        }
    }
</script>


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
        <div class="col-md-10 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $title ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo $content ?>
                </div>
                <div class="panel-footer" style="height: 40px">
                    <div class="col-md-offset-4">
                        <p style="text-align: right"><?php echo $author ?>&nbsp;发表于&nbsp;<?php echo $post_time ?></p>
                    </div>
                 </div>
            </div>
                <?php
                    $sql="select id,reply_id,author,comment_time,content,floor from comment where post_id=$post_id order by id limit $start,$per_page";
                    $que=mysqli_query($con,$sql);
                    $num=mysqli_num_rows($que);
                    if($num)
                    {
                        while($arr=mysqli_fetch_array($que))
                        {
                            ?>
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <?php
                                    $floor_cur=$arr['floor'];
                                    $id_reply = $arr['reply_id'];
                                    if($id_reply)
                                    {
                                        $sql_reply_floor="select floor from comment where id= $id_reply";
                                        $srh=mysqli_query($con,$sql_reply_floor);
                                        $reply_floor=mysqli_fetch_array($srh)[0];
                                        echo '<p class="text-muted">回复自'."$reply_floor".'楼</p><br>';
                                        $sql2="select content from comment where id = $id_reply";
                                        $que2=mysqli_query($con,$sql2);
                                        $reply_conntent=mysqli_fetch_array($que2)[0];
                                        echo '<p class="text-success">'."$reply_conntent".'</p><hr>';
                                    }
                                    echo $arr['content'];
                                    ?>
                                </div>
                                <div class="panel-footer" style="height: 40px">
                                    <div class="col-md-4" >
                                        <p style="text-align: left"><?php echo $arr['author'] ?>&nbsp;发表于&nbsp;<?php echo $arr['comment_time'] ?></p>
                                    </div>
                                    <div class="col-md-offset-11">
                                        <?php echo $floor_cur ?>楼
                                        <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#reply" onclick="judger(this)" id="<?php echo $arr['id'] ?>" >回复</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            <div class="modal fade" id="reply" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="dialog_title">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form class="form-horizontal" action="addcomment.php" id="myform" method="post">
                                <input type="hidden" name="reply_id" id="reply_id">
                                <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                                <input type="hidden" name="author" value="<?php echo $_SESSION['username'] ?>">
                                <input type="hidden" name="floor" value="<?php echo ($total+1) ?>">
                                <textarea id="content" name="content" style="border: none ;width: 100%;height: 300px" placeholder="请输入回复内容"></textarea>
                            </form></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="sub" onclick="sub()">回复</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align: center"><button class="btn btn-success  btn-sm" data-toggle="modal" data-target="#reply" id="0" onclick="judger(this)">回复主题</button><br></div>
            <div style="text-align: center">
                <ul class="pagination">
                    <li><a class="<?php if($page_index==1) echo "disabled btn";?>" href="<?php echo "$_SERVER[PHP_SELF]?id=".$post_id."&page_index=".($page_index-1)?>">&laquo;</a></li>
                    <?php
                    for($i=1;$i<=$num_page;$i++)
                        if($i==$page_index)
                        {
                            ?>
                            <li class='active'><a class="btn disabled" href="<?php echo "$_SERVER[PHP_SELF]?id=".$post_id."&page_index=".$i?>"> <?php echo $i;?></a></li>
                            <?php
                        }
                        else
                        {
                            ?>
                            <li><a href="<?php echo "$_SERVER[PHP_SELF]?id=".$post_id."&page_index=".$i?>"> <?php echo $i;?></a></li>
                            <?php
                        }
                    ?>
                    <li><a class="<?php if($page_index==$num_page) echo "disabled btn";?>" href="<?php echo "$_SERVER[PHP_SELF]?id=".$post_id."&page=".($page_index+1)?>">&raquo;</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>