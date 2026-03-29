<?php
include("../includes/db.php");

$res = mysqli_query($conn,"SELECT * FROM tests");
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
<h2>All Tests</h2>

<?php while($row=mysqli_fetch_assoc($res)){ ?>

<div class="card">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['category']; ?></p>

    <a href="edit_test.php?id=<?php echo $row['id']; ?>">
        <button class="btn">Edit</button>
    </a>
</div>

<?php } ?>

</div>