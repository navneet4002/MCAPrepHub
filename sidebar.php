<?php if(session_status() == PHP_SESSION_NONE){ session_start(); } ?>

<div class="sidebar">

<h3>Quick Access</h3>

<a href="index.php">Home</a>
<a href="dashboard.php">Tests</a>
<a href="study.php">Study Material</a>
<a href="performance.php">Performance</a>
<a href="contact.php">Contact Us</a>

<?php if(isset($_SESSION['user'])){ ?>
    <a href="logout.php">Logout</a>
<?php } ?>

</div>