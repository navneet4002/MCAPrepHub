<?php
include("ai_helper.php");

$topic = $_POST['topic'];

echo askAI("Generate 5 MCQ questions on $topic with options (a,b,c,d) and correct answers");
?>