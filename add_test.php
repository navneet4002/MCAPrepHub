<?php
include("../includes/db.php");

$msg = "";

if(isset($_POST['add'])){

    //  Get form data
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $desc = $_POST['description'];
    $cat = $_POST['category'];   

    // Insert into database
    mysqli_query($conn,"INSERT INTO tests(title,duration,description,category)
    VALUES('$title','$duration','$desc','$cat')");

    $msg = "Test Added Successfully!";
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="form-box">
<h2>Add Test</h2>

<form method="POST">

<input name="title" placeholder="Test Title" required>
<input name="duration" placeholder="Duration (seconds)" required>

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