<?php
include("../includes/db.php");

$res = mysqli_query($conn,"SELECT * FROM study_material");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View study Material</title>
    <link rel="stylesheet" href="/MCAPrepHub/Mca_Mock_Test/css/style.css">
</head>

<body>

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="layout">

    <!-- ✅ SIDEBAR (admin ke liye alag bana sakte ho later) -->
    <div class="sidebar">
        <h3>Admin Panel</h3>

        <a href="admin_dashboard.php" class="active">Dashboard</a>
        <a href="add_test.php">Add Test</a>
        <a href="view_tests.php">View Tests</a>

        <a href="add_question.php">Add Questions</a>
        <a href="view_questions.php">View Questions</a>

        <a href="add_study.php">Add Study Material</a>
        <a href="view_study.php">View Study</a>

        <a href="view_queries.php">Queries</a>
        <a href="users.php">Users</a>

        <a href="admin_login.php">Logout</a>
    </div>

    <!-- ✅ MAIN CONTENT -->
    <div class="main">


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
        <button class="btn">✏️ Edit</button>
    </a>
</div>

<?php } ?>

</div>
</div>
</div>
