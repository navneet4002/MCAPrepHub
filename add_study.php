<?php
include("../includes/db.php");

if(isset($_POST['add'])){
    $title=$_POST['title'];
    $cat=$_POST['category'];
    $desc=$_POST['description'];
    $link=$_POST['link'];

    mysqli_query($conn,"INSERT INTO study_material(title,category,description,link)
    VALUES('$title','$cat','$desc','$link')");

    echo "Added!";
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>
<div class="layout">

    <!-- ✅ SIDEBAR (admin ke liye alag bana sakte ho later) -->
    <div class="sidebar">
        <h3>Admin Panel</h3>

        <a href="admin_dashboard.php" class="active">Dashboard</a>
        <a href="add_test.php">Add Test</a>
        <a href="view_tests.php">View Tests</a>

        <a href="add_question.php">Add Questions</a>
        <a href="view_questions.php">View Questions</a>

        <a href="add_study.php">Add Study Material</a>
        <a href="view_study.php">View Study</a>

        <a href="view_queries.php">Queries</a>
        <a href="users.php">Users</a>

        <a href="admin_login.php">Logout</a>
    </div>

<div class="form-box">
<h2>Add Study Material</h2>

<form method="POST">

<input name="title" placeholder="Title">

<select name="category">
<option value="maths">Maths</option>
<option value="reasoning">Reasoning</option>
<option value="computer">Computer</option>
</select>

<textarea name="description" placeholder="Description"></textarea>

<input name="link" placeholder="YouTube Link">

<button name="add" class="btn">Add</button>

</form>
</div>