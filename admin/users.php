<?php
include("../includes/db.php");

$res=mysqli_query($conn,"SELECT * FROM users");
$count=mysqli_num_rows($res);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
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


<h2>Total Users: <?php echo $count; ?></h2>

<table border="1" cellpadding="10">
<tr>
<th>Name</th>
<th>Email</th>
<th>Registered On</th>
</tr>

<?php while($row=mysqli_fetch_assoc($res)){ ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['created_at']; ?></td>
</tr>
<?php } ?>

</table>
</div>
</div>