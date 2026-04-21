<?php
include("includes/db.php");
$msg="";

if(isset($_POST['register'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $confirm=$_POST['confirm_password'];

    if($password != $confirm){
        $msg = "<span class='error'>Passwords do not match</span>";
    } else {

        $check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($check)>0){
            $msg="<span class='error'>Email already exists</span>";
        } else {

            // 🔐 secure password
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn,"INSERT INTO users(name,email,password) VALUES('$name','$email','$hashed')");

            $msg="<span class='success'>Registered successfully! <a href='login.php'>Login</a></span>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login-page">

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="center">

    <div class="login-box">

        <h2>Create Account</h2>

        <form method="POST">

            <input name="name" placeholder="Enter Name" required>

            <input name="email" type="email" placeholder="Enter Email" required>

            <!-- PASSWORD -->
            <div class="input-group">
    <input type="password" id="password" name="password" placeholder="Enter Password" required>
    <span class="toggle-eye" onclick="togglePassword('password')">👁️</span>
</div>

<div class="input-group">
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
    <span class="toggle-eye" onclick="togglePassword('confirm_password')">👁️</span>
</div>

            <button name="register" class="btn">Register</button>

        </form>

        <p><?php echo $msg; ?></p>

        <p>Already have an account? <a href="login.php">Login</a></p>

    </div>

</div>

<script>
function togglePassword(id){
    const input = document.getElementById(id);
    if(input.type === "password"){
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>

</body>
</html>