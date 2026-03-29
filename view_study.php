<?php
include("../includes/db.php");

$res = mysqli_query($conn,"SELECT * FROM study_material");
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
<h2>Study Materials</h2>

<?php while($row=mysqli_fetch_assoc($res)){ ?>

<div class="card">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['category']; ?></p>
    <p><?php echo $row['description']; ?></p>

    <a href="<?php echo $row['link']; ?>" target="_blank">View Video</a>
    <br><br>

    <a href="edit_study.php?id=<?php echo $row['id']; ?>">
        <button class="btn">Edit</button>
    </a>
</div>

<?php } ?>

</div>