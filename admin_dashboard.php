<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
    <h2>Admin Panel</h2>

    <div class="card">
    <h3>Manage Tests</h3>
    <a href="add_test.php"><button class="btn">Add Test</button></a>
    <a href="view_tests.php"><button class="btn">View / Edit Tests</button></a>
    </div>

    <div class="card">
    <h3>Manage Questions</h3>
    <a href="add_question.php"><button class="btn">Add Questions</button></a>
    <a href="view_questions.php"><button class="btn">View / Edit Questions</button></a>
    </div>

    <div class="card">
    <h3>Study Material</h3>
    <a href="add_study.php"><button class="btn">Add Study Content</button></a>
    <a href="view_study.php"><button class="btn">View / Edit Study</button></a>
    </div>

    <a href="../logout.php"><button class="btn">Logout</button></a>
</div>
