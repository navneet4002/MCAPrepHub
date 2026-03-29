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

<div class="form-box">
<h2>Add Study Material</h2>

<form method="POST">

<input name="title" placeholder="Title">

<select name="category">
<option value="maths">Maths</option>
<option value="reasoning">Reasoning</option>
<option value="computer">Computer</option>
</select>

<textfield name="description" placeholder="Description"></textarea>

<input name="link" placeholder="YouTube Link">

<button name="add" class="btn">Add</button>

</form>
</div>
