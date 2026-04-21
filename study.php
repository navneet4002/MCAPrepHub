<?php
include("includes/header.php");
include("includes/db.php");

// 🔥 safe category handling
$cat = isset($_GET['cat']) ? strtolower($_GET['cat']) : 'maths';
?>

<div class="layout">

<!-- SIDEBAR -->
<?php include("includes/sidebar.php"); ?>

<div class="main">

<h2>Study Materials</h2>
<p style="color:#555;">
Master subjects with videos and notes
</p>

<!-- TABS -->
<div class="tabs">
    <a href="?cat=maths">
        <button class="btn <?php if($cat=='maths') echo 'active'; ?>">Mathematics</button>
    </a>
    <a href="?cat=reasoning">
        <button class="btn <?php if($cat=='reasoning') echo 'active'; ?>">Reasoning</button>
    </a>
    <a href="?cat=computer">
        <button class="btn <?php if($cat=='computer') echo 'active'; ?>">Computer</button>
    </a>
</div>

<!-- GRID -->
<div class="grid">

<?php
// 🔥 IMPORTANT FIX (case-insensitive match)
$res = mysqli_query($conn,"SELECT * FROM study_material WHERE LOWER(category)='$cat'");

if(mysqli_num_rows($res)>0){

while($row=mysqli_fetch_assoc($res)){

    // 🔥 SMART LINK HANDLING
    $link = !empty($row['youtube_link']) ? $row['youtube_link'] : $row['link'];

    // convert youtube format if needed
    $link = str_replace("watch?v=", "embed/", $link);
?>

<div class="card">

    <h4><?php echo htmlspecialchars($row['title']); ?></h4>

    <p><?php echo htmlspecialchars($row['description']); ?></p>

    <?php if(!empty($link)){ ?>
        <iframe width="100%" height="200"
        src="<?php echo $link; ?>"
        allowfullscreen>
        </iframe>
    <?php } else { ?>
        <p style="color:red;">No video available</p>
    <?php } ?>

</div>

<?php
}
} else {
    echo "<p>No content available</p>";
}
?>

</div>

</div>
</div>

<?php include("includes/footer.php"); ?>