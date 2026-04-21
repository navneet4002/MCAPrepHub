<?php
include("ai_helper.php");

$topic = $_POST['topic'];

$prompt = "Create short and clear exam notes on '$topic' in this format:

Definition:
- ...

Key Points:
- ...
- ...
- ...

Example:
- ...

Keep it simple, well-structured and easy for students.";

echo askAI($prompt);
?>