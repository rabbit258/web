<?php
session_start();
if($_SESSION['username']!="")
{echo "<script>alert('你已经登录');location='index.php'</script>"; exit();}
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
    $row=mysqli_fetch_row($que);
    if($row>0)
    {
            echo "<script>alert('当前用户名已经被使用!')</script>";
    }
    else
    {
        $sql="insert into client(username,password) values('$username','$password')";
        $que=mysqli_query($con,$sql);
        $_SESSION['username']=$username;
        echo "<script> alert('注册成功');location.href='index.php' </script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>注册</title><link rel="stylesheet" href="asset/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/bootstrap-3.4.1-dist/css/mysetting.css">
    <script src="asset/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="asset/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
<script type="text/javascript">
    window.onload=function (){
        var name=document.getElementById("username");
        var password=document.getElementById("password");
        var conf=document.getElementById("confpassword");
        var name_alert=document.getElementById("name_alert");
        var password_alert=document.getElementById("password_alert");
        var conf_alert=document.getElementById("confpassword_alert");

        name.onblur=function (){
            if(!name.value)
                name_alert.innerText="❌用户名不能为空";
            else if(!(/^[\u4E00-\u9FA5A-Za-z0-9_]+$/.test(name.value)))
                name_alert.innerText="❌请不要输入特殊符号";
            else
                name_alert.innerText="";
        }
        name.onfocus=function (){
            name_alert.innerText="";
        }

        password.onblur=function (){
            if(!password.value)
                password_alert.innerText="❌密码不能为空";
            else if(!(/^[a-zA-Z]\w{5,17}$/.test(password.value)))
                password_alert.innerText="❌以字母开头，长度在6~18之间，只能包含字母、数字和下划线"
            else
                password_alert.innerText="";
        }
        password.onfocus=function (){
            password_alert.innerText="";
        }
        conf.onblur=function (){
            if(!conf.value)
                conf_alert.innerText="❌确认密码不能为空"
            else if(conf.value!=password.value)
                conf_alert.innerText="❌二次密码不一致";
            else
                password_alert.innerText="";
        }
        conf.onfocus=function (){
            conf_alert.innerText=""
        }

    }
    function check(){
        document.getElementById('username').onblur();
        document.getElementById('password').onblur();
        document.getElementById('confpassword').onblur();

        if(document.getElementById('name_alert').innerText===""&&document.getElementById('password_alert').innerText===""&&document.getElementById('confpassword_alert').innerText==="")
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
                    <h3 class="panel-title">注册</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" onsubmit="return check();" action="register.php" method="post">
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
                                <input type="password" class="form-control" id="password" name="password" maxlength="20" placeholder="请输入你的密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3">
                                <p class="text-danger" id="password_alert"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confpassword" class="col-md-2 control-label">确认密码</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" id="confpassword" maxlength="20" placeholder="请再次输入你的密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3">
                                <p class="text-danger" id="confpassword_alert"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 ">
                                <button type="submit" class="btn btn-info" onsubmit="return check()" id="register">注册</button>
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