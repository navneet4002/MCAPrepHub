<?php
include("../includes/db.php");

$res=mysqli_query($conn,"SELECT * FROM users");
$count=mysqli_num_rows($res);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
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


<h2>Total Users: <?php echo $count; ?></h2>

<table border="1" cellpadding="10">
<tr>
<th>Name</th>
<th>Email</th>
<th>Registered On</th>
</tr>

<?php while($row=mysqli_fetch_assoc($res)){ ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['created_at']; ?></td>
</tr>
<?php } ?>

</table>
</div>
</div>