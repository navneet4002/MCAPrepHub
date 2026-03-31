<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/MCAPrepHub/Mca_Mock_Test/css/style.css">
</head>

<body>

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="layout">

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

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="admin-container">

            <h2>Admin Dashboard</h2>

            <!-- STATS -->
            <div class="stats">

            <?php
            $tests = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tests"));
            $questions = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM questions"));
            $users = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));
            ?>

            <div class="stat-box">
                <h3><?php echo $tests; ?></h3>
                <p>Tests</p>
            </div>

            <div class="stat-box">
                <h3><?php echo $questions; ?></h3>
                <p>Questions</p>
            </div>

            <div class="stat-box">
                <h3><?php echo $users; ?></h3>
                <p>Users</p>
            </div>

            </div>

            <!-- ACTION CARDS -->
            <div class="admin-grid">

             <!-- TEST -->
            <a href="add_test.php" class="admin-card">➕ Add Test</a>
            <a href="view_tests.php" class="admin-card">📋 View Tests</a>

            <!-- QUESTIONS -->
            <a href="add_question.php" class="admin-card">➕ Add Questions</a>
            <a href="view_questions.php" class="admin-card">📋 View Questions</a>
            <!-- STUDY -->
            <a href="add_study.php" class="admin-card">📘 Add Study</a>
            <a href="view_study.php" class="admin-card">📂 View Study</a>
            
            <!-- OTHER -->
            <a href="view_queries.php" class="admin-card">📩 Queries</a>
            <a href="users.php" class="admin-card">👤 Users</a>

        </div>

        </div>

    </div>

</div>

<?php include("../includes/footer.php"); ?>

</body>
</html>