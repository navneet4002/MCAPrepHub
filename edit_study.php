<?php
include("../includes/db.php");

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM study_material WHERE id='$id'"));

if(isset($_POST['update'])){
    $title = $_POST['title'];
    $category = $_POST['category'];
    $desc = $_POST['description'];
    $link = $_POST['link'];

    mysqli_query($conn,"UPDATE study_material SET 
    title='$title',
    category='$category',
    description='$desc',
    link='$link'
    WHERE id='$id'");

    header("Location: view_study.php");
    exit();
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="form-box">
<h2>Edit Study Material</h2>

<form method="POST">

<input name="title" value="<?php echo $data['title']; ?>" required>

<select name="category">
<option value="maths" <?php if($data['category']=='maths') echo 'selected'; ?>>Maths</option>
<option value="reasoning" <?php if($data['category']=='reasoning') echo 'selected'; ?>>Reasoning</option>
<option value="computer" <?php if($data['category']=='computer') echo 'selected'; ?>>Computer</option>
</select>

<textarea name="description"><?php echo $data['description']; ?></textarea>

<input name="link" value="<?php echo $data['link']; ?>" placeholder="YouTube Embed Link">

<button name="update" class="btn">Update</button>

</form>
</div>