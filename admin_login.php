<?php
session_start();
include("../includes/db.php");

$msg="";

if(isset($_POST['login'])){
    $u=$_POST['username'];
    $p=$_POST['password'];

    $res=mysqli_query($conn,"SELECT * FROM admin WHERE username='$u' AND password='$p'");

    if(mysqli_num_rows($res)>0){
        $_SESSION['admin']=$u;
        header("Location: admin_dashboard.php");
    } else {
        $msg="Invalid Login";
    }
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="form-box">
<h2>Admin Login</h2>

<form method="POST">
<input name="username" placeholder="Username" required>
<input name="password" type="password" placeholder="Password" required>
<button name="login" class="btn">Login</button>
</form>

<p><?php echo $msg; ?></p>
</div>
