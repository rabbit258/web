<?php
session_start();
if($_SESSION['username']!="")
{echo "<script>alert('你已经登录');location='index.php'</script>";}
header("Content-type:text/html;charset=utf-8");
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $con = mysqli_connect('localhost','root','root','myweb');
    mysqli_set_charset($con,'utf8');

    $username=$_POST['username'];
    $password=$_POST['password'];

    $sql="select username,password from client where username = '$username'";
    $que=mysqli_query($con,$sql);
//    if (!$que) {
//        printf("Error: %s\n", mysqli_error($con));
//        exit();
//    }
    $row=mysqli_fetch_array($que);
    if($row)
    {
        if($password!=$row['password'])
            echo "<script>alert('密码错误!')</script>";
        else{
            $_SESSION['username']=$row['username'];
            echo "<script>location.href='index.php'</script>";
        }
    }
    else
    {
        echo "<script>alert('用户名不存在!')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="asset/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/bootstrap-3.4.1-dist/css/mysetting.css">
    <script src="asset/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="asset/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
<script type="text/javascript">
    window.onload=function (){
        var name=document.getElementById("username");
        var password=document.getElementById("password");
        var name_alert=document.getElementById("name_alert");
        var password_alert=document.getElementById("password_alert");
        var register=document.getElementById("register");

        name.onblur=function (){
            if(!name.value)
                name_alert.innerText="❌用户名不能为空";
            else
                name_alert.innerText="";
        }
        name.onfocus=function (){
            name_alert.innerText="";
        }

        password.onblur=function (){
            if(!password.value)
               password_alert.innerText="❌密码不能为空";
            else
                password_alert.innerText="";
        }
        password.onfocus=function (){
            password_alert.innerText="";
        }


        register.onclick=function (){
            window.open("register.php","_self");
        }
    }
    function check(){
        document.getElementById('username').onblur();
        document.getElementById('password').onblur();

        if(document.getElementById('name_alert').innerText===""&&document.getElementById('password_alert').innerText==="")
            return true;
        else
            return false;
    }
</script>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">rabbit论坛</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> 主页</a></li>
        </ul>
    </div>
</nav>
<div class="container" style="margin-top: 100px">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">登录</h3>
                </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" onsubmit="return check();" action="login.php" method="post">
                            <div class="form-group">
                                <label for="username" class="col-md-2 control-label">用户名</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="username" name="username" maxlength="15" placeholder="请输入用户名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-3">
                                    <p class="text-danger" id="name_alert"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-2 control-label">密码</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" name="password" id="password" maxlength="20" placeholder="请输入你的密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-3">
                                    <p class="text-danger" id="password_alert"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-4 ">
                                    <button type="submit" class="btn btn-primary" >登录</button>
                                </div>
                                <div class="col-md-offset-8 ">
                                    <button type="button" class="btn btn-info" id="register">注册</button>
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
