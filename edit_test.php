<?php
include("../includes/db.php");

//  check id exists
if(!isset($_GET['id'])){
    die("No Test ID");
}

$id = $_GET['id'];

//  fetch test
$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM tests WHERE id='$id'"));

//  update
if(isset($_POST['update'])){

    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $category = $_POST['category'];

    mysqli_query($conn,"UPDATE tests SET 
    title='$title',
    duration='$duration',
    category='$category'
    WHERE id='$id'");

    //  redirect (VERY IMPORTANT)
    header("Location: admin_dashboard.php");
    exit();
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
<div class="main">

<div class="form-box">
<h2>Edit Test</h2>

<form method="POST">

<input name="title" value="<?php echo $data['title']; ?>" required>

<input name="duration" value="<?php echo $data['duration']; ?>" required>

<select name="category">
<option value="maths" <?php if($data['category']=='maths') echo 'selected'; ?>>Maths</option>
<option value="reasoning" <?php if($data['category']=='reasoning') echo 'selected'; ?>>Reasoning</option>
<option value="computer" <?php if($data['category']=='computer') echo 'selected'; ?>>Computer</option>
<option value="full_mock" <?php if($data['category']=='full_mock') echo 'selected'; ?>>Full Mock</option>
</select>

<button name="update" class="btn">Update</button>

</form>
</div>
</div>
</div>
