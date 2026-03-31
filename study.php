<?php
include("includes/header.php");
include("includes/db.php");

$cat = isset($_GET['cat']) ? $_GET['cat'] : 'maths';
?>

<div class="layout">

    <!-- SIDEBAR (FIXED) -->
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

<!--  GRID -->
<div class="grid">

<?php
$res = mysqli_query($conn,"SELECT * FROM study_material WHERE category='$cat'");

if(mysqli_num_rows($res)>0){
while($row=mysqli_fetch_assoc($res)){
?>

<div class="card">
    <h4><?php echo $row['title']; ?></h4>
    <p><?php echo $row['description']; ?></p>

    <iframe width="100%" height="180"
    src="<?php echo $row['link']; ?>"
    allowfullscreen></iframe>
</div>


<?php }} else { echo "<p>No content available</p>"; } ?>

</div>

</div>

</div>
<?php include("includes/footer.php"); ?>
</div>
