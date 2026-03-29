<?php
include("includes/auth.php");
include("includes/db.php");
include("includes/header.php");

$category = isset($_GET['cat']) ? $_GET['cat'] : 'all';
?>

<div class="container">

<h2>Topic Wise Tests</h2>
<p style="color:#555; margin-bottom:20px;">
Master each subject with focused topic-wise tests. Strengthen your weak areas and 
excel in Mathematics, Reasoning, Computer Awareness
</p>
<!--  CATEGORY BUTTONS -->
<div style="margin-bottom:20px;">

<a href="dashboard.php?cat=all">
<button class="btn" style="<?php if($category=='all') echo 'background:red'; ?>">
All
</button>
</a>

<a href="dashboard.php?cat=full_mock">
<button class="btn" style="<?php if($category=='full_mock') echo 'background:red'; ?>">
Full Mock
</button>
</a>

<a href="dashboard.php?cat=maths">
<button class="btn" style="<?php if($category=='maths') echo 'background:red'; ?>">
Maths
</button>
</a>

<a href="dashboard.php?cat=reasoning">
<button class="btn" style="<?php if($category=='reasoning') echo 'background:red'; ?>">
Reasoning
</button>
</a>

<a href="dashboard.php?cat=computer">
<button class="btn" style="<?php if($category=='computer') echo 'background:red'; ?>">
Computer
</button>
</a>

</div>

<?php
//  FILTER LOGIC
if($category == "all"){
    $query = "SELECT * FROM tests";
} else {
    $query = "SELECT * FROM tests WHERE category='$category'";
}

$res = mysqli_query($conn, $query);

if(mysqli_num_rows($res)>0){
while($row=mysqli_fetch_assoc($res)){
?>

<div class="card">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo strtoupper($row['category']); ?></p>

    <a href="test.php?id=<?php echo $row['id']; ?>">
        <button class="btn">Start Test</button>
    </a>
</div>

<?php }} else { echo "<p>No tests found</p>"; } ?>

</div>