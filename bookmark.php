<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];
$user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE email='$email'"));
$user_id = $user['id'];

$test_id = $_GET['id'];

// check duplicate
$check = mysqli_query($conn,"SELECT * FROM bookmarks WHERE user_id='$user_id' AND test_id='$test_id'");

if(mysqli_num_rows($check) == 0){
    mysqli_query($conn,"INSERT INTO bookmarks(user_id,test_id) VALUES('$user_id','$test_id')");
}

header("Location: dashboard.php");
?>