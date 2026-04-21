<?php
ob_start(); 
session_start();
include("includes/db.php");

$msg="";

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $pass=$_POST['password'];

    // get user by email only
    $res=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($res)>0){
        $user = mysqli_fetch_assoc($res);

        // 🔐 verify hashed password
        if(password_verify($pass, $user['password'])){
			$_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $email;
            $_SESSION['name'] = $user['name'];

            mysqli_query($conn,"INSERT INTO login_logs(user_id,login_time)
            VALUES('".$user['id']."',NOW())");

            header("Location: index.php");
            exit();

        } else {
            $msg="<span class='error'>Incorrect Password</span>";
        }

    } else {
        $msg="<span class='error'>User not found</span>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login-page">

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="center">

    <div class="login-box">

        <h2>Login to MCAPrepHub</h2>

        <form method="POST">

            <input type="email" name="email" placeholder="Enter Email" required>

            <!-- PASSWORD FIELD WITH EYE -->
            <div class="input-group">
            <input type="password" id="login_password" name="password" placeholder="Enter Password" required>
            <span class="toggle-eye" onclick="togglePassword('login_password')">👁️</span>
            </div>

            <button name="login" class="btn">Login</button>

        </form>

        <p><?php echo $msg; ?></p>

        <p>
            Don’t have an account? <a href="register.php">Create Account</a>
        </p>

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
<?php ob_end_flush(); ?>