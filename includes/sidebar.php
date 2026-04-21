<?php 
if(session_status() == PHP_SESSION_NONE){ session_start(); } 

// 🔥 CURRENT PAGE DETECT
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">

<h3>Quick Access</h3>

<a href="index.php" class="<?php if($current=='index.php') echo 'active'; ?>">Home</a>

<a href="dashboard.php" class="<?php if($current=='dashboard.php') echo 'active'; ?>">Tests</a>

<a href="study.php" class="<?php if($current=='study.php') echo 'active'; ?>">Study Material</a>

<a href="performance.php" class="<?php if($current=='performance.php') echo 'active'; ?>">Performance</a>

<a href="contact.php" class="<?php if($current=='contact.php') echo 'active'; ?>">Contact Us</a>

<a href="ai_mode.php" class="<?php if($current=='ai_mode.php') echo 'active'; ?>">🤖 AI Mode</a>

<?php if(isset($_SESSION['user'])){ ?>
    <a href="logout.php">Logout</a>
<?php } ?>

</div>