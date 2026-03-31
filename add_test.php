<?php
include("../includes/db.php");

$msg = "";

if(isset($_POST['add'])){

    $title = $_POST['title'];
    $minutes = $_POST['duration'];   
    $duration = $minutes * 60;       
    $desc = $_POST['description'];
    $cat = $_POST['category'];   

    mysqli_query($conn,"INSERT INTO tests(title,duration,description,category)
    VALUES('$title','$duration','$desc','$cat')");

    $msg = "Test Added Successfully!";
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>
<div class="layout">

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
<h2>Add Test</h2>

<form method="POST">

<input name="title" placeholder="Test Title" required>
<input type="number" name="duration" placeholder="Duration (minutes)" required>

<!--  CATEGORY DROPDOWN -->
<select name="category" required>
<option value="">Select Category</option>
<option value="full_mock">Full Mock</option>
<option value="maths">Maths</option>
<option value="reasoning">Reasoning</option>
<option value="computer">Computer</option>
</select>

<textarea name="description" placeholder="Description"></textarea>

<button name="add" class="btn">Add Test</button>
</form>

<p><?php echo $msg; ?></p>

</div>
</div>
<?php include("../includes/footer.php"); ?>