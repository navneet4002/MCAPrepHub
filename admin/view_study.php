<?php
include("../includes/db.php");

// 🔥 DELETE LOGIC
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM study_material WHERE id='$id'");
    header("Location: view_study.php");
    exit();
}

$current = basename($_SERVER['PHP_SELF']);
$res = mysqli_query($conn,"SELECT * FROM study_material");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Study Material</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="layout">

<!-- SIDEBAR -->
<?php include("admin_sidebar.php"); ?>

<!-- MAIN -->
<div class="main">

<div class="container">
<h2>📚 Study Materials</h2>

<div class="grid">

<?php while($row=mysqli_fetch_assoc($res)){ 

// 🔥 correct link
$link = !empty($row['youtube_link']) ? $row['youtube_link'] : $row['link'];
$link = str_replace("watch?v=", "embed/", $link);
?>

<div class="card">

    <!-- 🔥 THUMBNAIL -->
    <?php if(!empty($row['thumbnail'])){ ?>
        <img src="<?php echo $row['thumbnail']; ?>" class="thumb">
    <?php } ?>

    <div class="card-body">

        <h3><?php echo htmlspecialchars($row['title']); ?></h3>

        <p class="cat">📚 <?php echo ucfirst($row['category']); ?></p>

        <p class="desc">
            <?php echo !empty($row['description']) ? htmlspecialchars($row['description']) : "No description available"; ?>
        </p>

        <!-- 🔥 BUTTONS -->
        <div class="actions">

            <?php if(!empty($link)){ ?>
                <a href="<?php echo $link; ?>" target="_blank">
                    <button class="view-btn">▶ Watch</button>
                </a>
            <?php } ?>

            <a href="edit_study.php?id=<?php echo $row['id']; ?>">
                <button class="edit-btn">✏️</button>
            </a>

            <a href="view_study.php?delete=<?php echo $row['id']; ?>"
            onclick="return confirm('Delete this item?')">
                <button class="delete-btn">🗑</button>
            </a>

        </div>

    </div>

</div>

<?php } ?>

</div>

</div>
</div>
</div>

</body>
</html>