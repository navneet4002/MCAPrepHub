<?php
include("../includes/db.php");

$res = mysqli_query($conn,"SELECT * FROM questions");
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
<h2>All Questions</h2>

<?php while($row=mysqli_fetch_assoc($res)){ ?>

<div class="card">
    <p><?php echo $row['question']; ?></p>

    <a href="edit_question.php?id=<?php echo $row['id']; ?>">
        <button class="btn">Edit</button>
    </a>
</div>

<?php } ?>

</div>