<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

$msg="";

if(isset($_POST['login'])){
    $u=$_POST['username'];
    $p=$_POST['password'];

   $res = mysqli_query($conn,"SELECT * FROM admin WHERE username='$u'");
$data = mysqli_fetch_assoc($res);

if($data && $p == $data['password']){
    $_SESSION['admin']=$u;
    header("Location: admin_dashboard.php");
    exit();
} else {
    $msg="Invalid Login";
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="login-page">

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>
<div class="layout">
    <div class="main">

<div class="login-box">
<h2>Admin Login</h2>

<form method="POST">
<input name="username" placeholder="Username" required>
<input name="password" type="password" placeholder="Password" required>
<button name="login" class="btn">Login</button>
</form>

<p><?php echo $msg; ?></p>
</div>
</div>
</div>