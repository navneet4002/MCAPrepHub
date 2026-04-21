<?php
session_start();
include("../includes/db.php");

/* CHECK ID */
if(!isset($_GET['id'])){
    echo "Invalid Request";
    exit();
}

$id = $_GET['id'];

/* FETCH DATA */
$res = mysqli_query($conn,"SELECT * FROM study_material WHERE id='$id'");
$data = mysqli_fetch_assoc($res);

if(!$data){
    echo "Data not found";
    exit();
}

/* UPDATE */
if(isset($_POST['update'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);

    mysqli_query($conn,"UPDATE study_material SET 
        title='$title',
        category='$category',
        description='$desc',
        link='$link'
        WHERE id='$id'
    ");

    header("Location: view_study.php");
    exit();
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="layout">

    <?php include("../includes/sidebar.php"); ?>
<div class="main">

<div class="form-box">
<h2>Edit Study Material</h2>

<form method="POST">

<input name="title" value="<?php echo $data['title']; ?>">

<select name="category">
    <option value="maths" <?php if($data['category']=="maths") echo "selected"; ?>>Maths</option>
    <option value="reasoning" <?php if($data['category']=="reasoning") echo "selected"; ?>>Reasoning</option>
    <option value="computer" <?php if($data['category']=="computer") echo "selected"; ?>>Computer</option>
</select>

<textarea name="description"><?php echo $data['description']; ?></textarea>

<input name="link" value="<?php echo $data['link']; ?>">

<button name="update" class="btn">Update</button>

</form>
</div>
</div>
</div>
