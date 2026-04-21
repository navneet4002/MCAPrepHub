<?php
include("../includes/db.php");

$id = $_POST['id'];
$title = $_POST['title'];

mysqli_query($conn,"UPDATE ai_conversations SET title='$title' WHERE id='$id'");
?>