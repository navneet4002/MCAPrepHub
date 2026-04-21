<?php
include("../includes/db.php");
// Fix sidebar color
$current = basename($_SERVER['PHP_SELF']);


$query = "SELECT * FROM questions WHERE 1=1";

if(!empty($_GET['test_id'])){
    $test_id = $_GET['test_id'];
    $query .= " AND test_id='$test_id'";
}

if(!empty($_GET['search'])){
    $search = $_GET['search'];
    $query .= " AND question LIKE '%$search%'";
}

$res = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Questions</title>
    <link rel="stylesheet" href="/css/style.css">
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

    <!-- ✅ MAIN CONTENT -->
    <div class="main">


<div class="container">
<h2>All Questions</h2>
<form method="GET" style="margin-bottom:20px; display:flex; gap:10px;">

<select name="test_id">
<option value="">All Tests</option>

<?php
$tests = mysqli_query($conn,"SELECT * FROM tests");
while($t=mysqli_fetch_assoc($tests)){
?>
<option value="<?php echo $t['id']; ?>">
<?php echo $t['title']; ?>
</option>
<?php } ?>

</select>

<input type="text" name="search" placeholder="Search question...">

<button class="btn">Filter</button>

</form>

<?php while($row=mysqli_fetch_assoc($res)){ ?>

<div class="card">
    <p><b>Q:</b> <?php echo $row['question']; ?></p>

    <p style="color:gray; font-size:14px;">
    Test ID: <?php echo $row['test_id']; ?>
    </p>

    <a href="edit_question.php?id=<?php echo $row['id']; ?>">
        <button class="btn">✏️ Edit</button>
    </a>
    <a href="delete_question.php?id=<?php echo $row['id']; ?>" 
    onclick="return confirm('Delete this question?')">
    <button class="btn" style="background:red;">Delete</button>
</a>
</div>

<?php } ?>

</div>
</div>
</div>
