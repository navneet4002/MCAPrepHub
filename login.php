<?php
session_start();
include("includes/db.php");

$msg="";

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $pass=$_POST['password'];

    $res=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if(mysqli_num_rows($res)>0){
        $_SESSION['user']=$email;
        header("Location: dashboard.php");
    } else {
        $msg="Invalid Login";
    }
}
?>

<link rel="stylesheet" href="css/style.css">

<div class="center">

    <div class="login-box">
        <h2>Login to MCAPrep</h2>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button name="login" class="btn">Login</button>
        </form>

        <p style="color:red;"><?php echo $msg; ?></p>

        <a href="register.php">Create Account</a>
    </div>

</div>