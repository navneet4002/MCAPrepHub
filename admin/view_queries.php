<?php
session_start();
include("../includes/db.php");

// Fix sidebar color    
$current = basename($_SERVER['PHP_SELF']);


$res=mysqli_query($conn,"SELECT * FROM queries ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Queries</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="layout">

    <!-- ✅ SIDEBAR (admin ke liye alag bana sakte ho later) -->
     <?php include("admin_sidebar.php"); ?>

    <!-- ✅ MAIN CONTENT -->
    <div class="main">


<h2>User Queries</h2>

<table border="1" cellpadding="10">
<tr>
<th>Subject</th>
<th>Email</th>
<th>Phone</th>
<th>Message</th>
<th>Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($res)){ ?>
<tr>
<td><?php echo $row['subject']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['message']; ?></td>
<td><?php echo $row['created_at']; ?></td>
</tr>
<?php } ?>

</table>
</div>
</div>
