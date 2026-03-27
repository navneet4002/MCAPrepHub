<?php
include("includes/db.php");
$msg="";

if(isset($_POST['register'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    $check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check)>0){
        $msg="Email already exists";
    } else {
        mysqli_query($conn,"INSERT INTO users(name,email,password) VALUES('$name','$email','$password')");
        $msg="Registered! <a href='login.php'>Login</a>";
    }
}
?>

<link rel="stylesheet" href="css/style.css">

<div class="form-box">
<h2>Create Account</h2>

<form method="POST">
<input name="name" placeholder="Name" required>
<input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Password" required>

<button name="register" class="btn">Register</button>
</form>

<p><?php echo $msg; ?></p>

<a href="login.php">Already have account?</a>
</div>