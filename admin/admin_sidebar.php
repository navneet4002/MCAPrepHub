<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
<h3>Admin Panel</h3>

<a href="admin_dashboard.php" class="<?php if($current=='admin_dashboard.php') echo 'active'; ?>">Dashboard</a>

<a href="add_test.php" class="<?php if($current=='add_test.php') echo 'active'; ?>">Add Test</a>

<a href="view_tests.php" class="<?php if($current=='view_tests.php') echo 'active'; ?>">View Tests</a>

<a href="add_question.php" class="<?php if($current=='add_question.php') echo 'active'; ?>">Add Questions</a>

<a href="view_questions.php" class="<?php if($current=='view_questions.php') echo 'active'; ?>">View Questions</a>

<a href="add_study.php" class="<?php if($current=='add_study.php') echo 'active'; ?>">Add Study Material</a>

<a href="view_study.php" class="<?php if($current=='view_study.php') echo 'active'; ?>">View Study</a>

<a href="view_queries.php" class="<?php if($current=='view_queries.php') echo 'active'; ?>">Queries</a>

<a href="users.php" class="<?php if($current=='users.php') echo 'active'; ?>">Users</a>

<a href="admin_login.php">Logout</a>
</div>