<?php
include("../includes/db.php");

$res=mysqli_query($conn,"
SELECT u.name, u.email, l.login_time 
FROM login_logs l
JOIN users u ON l.user_id=u.id
ORDER BY l.id DESC
");
?>
<link rel="stylesheet" href="/MCAPrepHub/Mca_Mock_Test/css/style.css">
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
<div class="main">

<h2>User Login Activity</h2>

<table border="1" cellpadding="10">
<tr>
<th>Name</th>
<th>Email</th>
<th>Login Time</th>
</tr>

<?php while($row=mysqli_fetch_assoc($res)){ ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['login_time']; ?></td>
</tr>
<?php } ?>

</table>
</div>
</div>
