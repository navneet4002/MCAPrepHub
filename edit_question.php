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

<link rel="stylesheet" href="../css/style.css">

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