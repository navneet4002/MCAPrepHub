<?php
include("../includes/db.php");
session_start();

$user_id = $_SESSION['user_id'] ?? 1;

mysqli_query($conn, "DELETE FROM ai_chats WHERE user_id='$user_id'");
?>