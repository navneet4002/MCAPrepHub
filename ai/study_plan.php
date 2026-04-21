<?php
include("ai_helper.php");

$subject = $_POST['subject'];

echo askAI("Create a 5-day study plan for $subject for exam preparation");
?>