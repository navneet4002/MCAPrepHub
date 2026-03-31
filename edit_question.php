<?php
include("../includes/db.php");

if(!isset($_GET['id'])){
    die("No Question ID");
}

$id = $_GET['id'];

$q = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM questions WHERE id='$id'"));

if(isset($_POST['update'])){

    $question=$_POST['question'];
    $o1=$_POST['o1'];
    $o2=$_POST['o2'];
    $o3=$_POST['o3'];
    $o4=$_POST['o4'];
    $correct=$_POST['correct'];

    mysqli_query($conn,"UPDATE questions SET 
    question='$question',
    option1='$o1',
    option2='$o2',
    option3='$o3',
    option4='$o4',
    correct_option='$correct'
    WHERE id='$id'");

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>edit_questions</title>
    <link rel="stylesheet" href="/MCAPrepHub/Mca_Mock_Test/css/style.css">
</head>

<body>

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

    <!-- MAIN CONTENT -->
    <div class="main">

<div class="form-box">
<h2>Edit Question</h2>

<form method="POST">

<textarea name="question" required><?php echo $q['question']; ?></textarea>

<input name="o1" value="<?php echo $q['option1']; ?>">
<input name="o2" value="<?php echo $q['option2']; ?>">
<input name="o3" value="<?php echo $q['option3']; ?>">
<input name="o4" value="<?php echo $q['option4']; ?>">

<input name="correct" value="<?php echo $q['correct_option']; ?>">

<button name="update" class="btn">Update</button>

</form>
</div>
</div>
</div>
<?php include("../includes/footer.php"); ?>
