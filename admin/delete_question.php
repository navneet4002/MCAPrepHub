<?php
include("../includes/db.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    mysqli_query($conn,"DELETE FROM questions WHERE id='$id'");
}

header("Location: view_questions.php");
exit();
$test_id = mysqli_real_escape_string($conn, $_GET['test_id']);