<?php
include("../includes/db.php");

$msg = "";

if(isset($_POST['add'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = strtolower(trim($_POST['category']));
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $link = trim($_POST['link']);

    // 🔥 CLEAN + CONVERT LINK
    if(!empty($link)){
        $link = str_replace(" ", "", $link);
        $link = str_replace("watch?v=", "embed/", $link);

        if(strpos($link, "youtu.be/") !== false){
            $link = str_replace("youtu.be/", "youtube.com/embed/", $link);
        }
    }

    // 🔥 THUMBNAIL GENERATE
    $thumbnail = "";
    if(!empty($link)){
        if(preg_match("/embed\/([a-zA-Z0-9_-]+)/", $link, $match)){
            $video_id = $match[1];
            $thumbnail = "https://img.youtube.com/vi/".$video_id."/0.jpg";
        }
    }

    $link = mysqli_real_escape_string($conn, $link);
    $thumbnail = mysqli_real_escape_string($conn, $thumbnail);

    // 🔥 INSERT WITH THUMBNAIL
    $query = "INSERT INTO study_material 
    (title, category, description, youtube_link, thumbnail)
    VALUES ('$title', '$category', '$desc', '$link', '$thumbnail')";

    if(mysqli_query($conn, $query)){
        $msg = "✅ Study Material Added Successfully!";
    } else {
        $msg = "❌ Error: " . mysqli_error($conn);
    }
}

$current = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="../css/style.css">

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="layout">

<!-- SIDEBAR -->
<?php include("admin_sidebar.php"); ?>

<div class="form-box">
<h2>Add Study Material</h2>

<form method="POST">

<input name="title" placeholder="Title" required>

<select name="category" required>
<option value="maths">Maths</option>
<option value="reasoning">Reasoning</option>
<option value="computer">Computer</option>
</select>

<textarea name="description" placeholder="Description"></textarea>

<input name="link" placeholder="YouTube Link">

<button name="add" class="btn">Add</button>

</form>

<p><?php echo $msg; ?></p>

</div>
</div>