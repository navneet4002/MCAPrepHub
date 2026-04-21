<?php
include("../includes/db.php");
session_start();

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM ai_conversations WHERE id='$id'");
mysqli_query($conn,"DELETE FROM ai_messages WHERE conversation_id='$id'");
?>