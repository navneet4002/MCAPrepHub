<?php
include("../includes/db.php");

// Fix sidebar color

$current = basename($_SERVER['PHP_SELF']);


$res = mysqli_query($conn,"SELECT * FROM tests");

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    // 🔥 Pehle questions delete karo (foreign key issue avoid)
    mysqli_query($conn,"DELETE FROM questions WHERE test_id='$id'");

    // 🔥 Fir test delete
    mysqli_query($conn,"DELETE FROM tests WHERE id='$id'");

    header("Location: view_tests.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View tests</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="layout">

<?php include("admin_sidebar.php"); ?>
    <!-- ✅ MAIN CONTENT -->
    <div class="main">


<div class="container">
<h2>All Tests</h2>

<?php while($row=mysqli_fetch_assoc($res)){ ?>

<div class="card">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['category']; ?></p>

    <a href="edit_test.php?id=<?php echo $row['id']; ?>">
        <button class="btn">✏️ Edit</button>
    </a>
    <a href="view_tests.php?delete=<?php echo $row['id']; ?>" 
    onclick="return confirm('Are you sure to delete this test?')">
    <button class="btn" style="background:#ef4444;">🗑 Delete</button>
</a>
<a href="../test.php?id=<?php echo $row['id']; ?>">
    <button class="btn" style="background:#10b981;">👁 Review</button>
</a>
</div>

<?php } ?>

</div>
</div>
</div>
