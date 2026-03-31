<?php
include("includes/auth.php");
include("includes/db.php");
include("includes/header.php");

$category = isset($_GET['cat']) ? $_GET['cat'] : 'all';
?>

<!-- LAYOUT WRAPPER -->
<div class="layout">

    <!-- SIDEBAR (FIXED) -->
    <?php include("includes/sidebar.php"); ?>

    <!-- MAIN CONTENT -->
    <div class="main">

        <h2>Topic Wise Tests</h2>

        <p style="color:#555; margin-bottom:20px;">
        Master each subject with focused topic-wise tests. Strengthen your weak areas and 
        excel in Mathematics, Reasoning, and Computer Awareness.
        </p>

        <!-- CATEGORY FILTER -->
        <div style="margin-bottom:20px;">

            <a href="dashboard.php?cat=all">
            <button class="btn <?php if($category=='all') echo 'active'; ?>">All</button>
            </a>

            <a href="dashboard.php?cat=full_mock">
            <button class="btn <?php if($category=='full_mock') echo 'active'; ?>">Full Mock</button>
            </a>

            <a href="dashboard.php?cat=maths">
            <button class="btn <?php if($category=='maths') echo 'active'; ?>">Maths</button>
            </a>

            <a href="dashboard.php?cat=reasoning">
            <button class="btn <?php if($category=='reasoning') echo 'active'; ?>">Reasoning</button>
            </a>

            <a href="dashboard.php?cat=computer">
            <button class="btn <?php if($category=='computer') echo 'active'; ?>">Computer</button>
            </a>

        </div>

        <?php
        // FILTER LOGIC
        if($category == "all"){
        $query = "SELECT * FROM tests ORDER BY created_at ASC";
        } else {
        $query = "SELECT * FROM tests WHERE category='$category' ORDER BY created_at ASC";
        }

        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res)>0){
            while($row=mysqli_fetch_assoc($res)){
        ?>

        <div class="card">
            <h3><?php echo $row['title']; ?></h3>

            <p><b>Category:</b> <?php echo strtoupper($row['category']); ?></p>

            <p><b>Duration:</b> <?php echo $row['duration']/60; ?> mins</p>

            <a href="test.php?id=<?php echo $row['id']; ?>">
                <button class="btn">Start Test</button>
            </a>
        </div>

        <?php 
            }
        } else { 
            echo "<p>No tests found</p>"; 
        } 
        ?>

    </div>

</div>
<?php include("includes/footer.php"); ?>