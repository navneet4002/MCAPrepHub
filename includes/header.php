<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<link rel="stylesheet" href="css/style.css">
<script src="https://cdn.tailwindcss.com"></script>

<div class="navbar">

    <div class="logo">MCAPrepHub</div>

    <div class="nav-right">

        <a href="index.php">Home</a>
        <a href="index.php#about">About</a>
        <a href="contact.php">Contact</a>

        <?php if(isset($_SESSION['name'])){ ?>
            <div class="user-box">
                <span class="avatar">👤</span>
                <span class="user-name"><?php echo ucwords($_SESSION['name']); ?></span>
            </div>
        <?php } ?>

    </div>

</div>