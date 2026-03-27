<?php
include("../includes/db.php");

if(isset($_POST['add'])){
    $test_id=$_POST['test_id'];
    $q=$_POST['question'];
    $o1=$_POST['o1'];
    $o2=$_POST['o2'];
    $o3=$_POST['o3'];
    $o4=$_POST['o4'];
    $correct=$_POST['correct'];

    mysqli_query($conn,"INSERT INTO questions(test_id,question,option1,option2,option3,option4,correct_option)
    VALUES('$test_id','$q','$o1','$o2','$o3','$o4','$correct')");

    echo "Question Added!";
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="form-box">
<h2>Add Question</h2>

<form method="POST">

<!-- 🔥 DROPDOWN -->
<select name="test_id" required>
<option value="">Select Test</option>

<?php
$res=mysqli_query($conn,"SELECT * FROM tests");
while($row=mysqli_fetch_assoc($res)){
?>
<option value="<?php echo $row['id']; ?>">
<?php echo $row['title']; ?>
</option>
<?php } ?>

</select>

<textarea name="question" placeholder="Enter Question"></textarea>

<input name="o1" placeholder="Option 1">
<input name="o2" placeholder="Option 2">
<input name="o3" placeholder="Option 3">
<input name="o4" placeholder="Option 4">

<input name="correct" placeholder="Correct Option (1-4)">

<button name="add" class="btn">Add Question</button>

</form>
</div>