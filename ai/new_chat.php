<?php
include("../includes/db.php");
session_start();

$user_id = $_SESSION['user_id'] ?? 1;

mysqli_query($conn, "INSERT INTO ai_conversations(user_id,title) VALUES('$user_id','New Chat')");

$id = mysqli_insert_id($conn);

header("Location: ../ai_mode.php?chat_id=".$id);
?>