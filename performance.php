<?php
include("includes/db.php");
include("includes/header.php");
session_start();

$email=$_SESSION['user'];
$user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE email='$email'"));
$user_id=$user['id'];

$res=mysqli_query($conn,"SELECT score FROM results WHERE user_id='$user_id'");
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="chart"></canvas>

<script>
let scores=[
<?php while($r=mysqli_fetch_assoc($res)){ ?>
<?php echo $r['score']; ?>,
<?php } ?>
];

new Chart(document.getElementById("chart"),{
type:'line',
data:{labels:scores.map((_,i)=>i+1),datasets:[{data:scores}]}
});
</script>