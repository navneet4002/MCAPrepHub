<?php 
session_start();
include("includes/db.php");
include("includes/header.php");

$email=$_SESSION['user'];
$user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE email='$email'"));
$user_id=$user['id'];

/* SUBJECT WISE DATA */
$maths = mysqli_query($conn,"SELECT r.score FROM results r 
JOIN tests t ON r.test_id=t.id 
WHERE r.user_id='$user_id' AND t.category='maths'");

$reasoning = mysqli_query($conn,"SELECT r.score FROM results r 
JOIN tests t ON r.test_id=t.id 
WHERE r.user_id='$user_id' AND t.category='reasoning'");

$computer = mysqli_query($conn,"SELECT r.score FROM results r 
JOIN tests t ON r.test_id=t.id 
WHERE r.user_id='$user_id' AND t.category='computer'");

$mock = mysqli_query($conn,"SELECT r.score FROM results r 
JOIN tests t ON r.test_id=t.id 
WHERE r.user_id='$user_id' AND t.category='mock'");

/* ===== STATS (OUTSIDE LOOP) ===== */
$total_tests = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM results WHERE user_id='$user_id'"));

$avg_score = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT AVG((score/(total*4))*100) as avg FROM results WHERE user_id='$user_id'"));

$best_subject = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT t.category, AVG(r.score/r.total) as avg 
 FROM results r 
 JOIN tests t ON r.test_id=t.id 
 WHERE r.user_id='$user_id' 
 GROUP BY t.category 
 ORDER BY avg DESC LIMIT 1"));
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="layout">
<?php include("includes/sidebar.php"); ?>

<div class="main">

<h2>Performance Dashboard</h2>
<p>Track your progress and analyze your performance.</p>

<?php
if($total_tests == 0){
    echo "<p style='color:gray;'>No tests attempted yet</p>";
}
?>

<div class="stats">
    <div class="stat-box">
        <h3><?php echo $total_tests; ?></h3>
        <p>Tests Attempted</p>
    </div>

    <div class="stat-box">
        <h3>
    <?php 
    if($avg_score['avg']){
        echo round($avg_score['avg'],2)."%";
    } else {
        echo "0%";
    }
    ?>
    </h3>
        <p>Average Score</p>
    </div>

    <div class="stat-box">
        <h3>
    <?php 
        if($best_subject && $best_subject['category']){
        echo strtoupper($best_subject['category']);
        } else {
        echo "N/A";
        }
    ?>
    </h3>
        <p>Best Subject</p>
    </div>
</div>

<!-- CHARTS -->
<style>
.chart-box{
    width: 400px;
    height: 250px;
    margin:20px;
    display:inline-block;
}
</style>
<div class="chart-container">

<div class="chart-box"><canvas id="mathChart"></canvas></div>
<div class="chart-box"><canvas id="reasonChart"></canvas></div>
<div class="chart-box"><canvas id="compChart"></canvas></div>
<div class="chart-box"><canvas id="mockChart"></canvas></div>
</div>

<div style="width:400px;margin:auto;">
<canvas id="pieChart"></canvas>
</div>

<!-- TABLE -->
<div class="table-card">
<h3>📊 Subject-wise Test History</h3>

<table class="modern-table">
<thead>
<tr>
<th>Test</th>
<th>Subject</th>
<th>Score</th>
<th>Total</th>
<th>%</th>
<th>Time Taken</th>
</tr>
</thead>

<tbody>

<?php
$res = mysqli_query($conn,"SELECT r.*, t.title, t.category 
FROM results r 
JOIN tests t ON r.test_id=t.id 
WHERE r.user_id='$user_id'");

while($row=mysqli_fetch_assoc($res)){

$marks_per_question = 2; // ya jo tum use kar rahi ho

$total_marks = $row['total'] * $marks_per_question;

$percent = ($total_marks > 0) ? ($row['score']/$total_marks)*100 : 0;

if($percent >= 80) $class="high";
elseif($percent >= 50) $class="medium";
else $class="low";

$time = $row['time_taken'];
$min = floor($time / 60);
$sec = $time % 60;
?>

<tr>
<td><?php echo $row['title']; ?></td>

<td>
<span class="badge"><?php echo ucfirst($row['category']); ?></span>
</td>

<td><?php echo $row['score']; ?></td>
<td><?php echo $row['total']; ?></td>

<td>
<span class="percent <?php echo $class; ?>">
<?php echo round($percent,2); ?>%
</span>
</td>

<td><?php echo $min . "m " . $sec . "s"; ?></td>
</tr>

<?php } ?>

</tbody>
</table>

</div>

</div>
</div>

<script>

/* FETCH DATA */
let maths = [<?php while($r=mysqli_fetch_assoc($maths)){ echo $r['score'].",";} ?>];
let reasoning = [<?php while($r=mysqli_fetch_assoc($reasoning)){ echo $r['score'].",";} ?>];
let computer = [<?php while($r=mysqli_fetch_assoc($computer)){ echo $r['score'].",";} ?>];
let mock = [<?php while($r=mysqli_fetch_assoc($mock)){ echo $r['score'].",";} ?>];

function createChart(id,data,label,color){
    new Chart(document.getElementById(id),{
        type:'line',
        data:{
            labels:data.map((_,i)=>i+1),
            datasets:[{
                label:label,
                data:data,
                borderColor:color,
                fill:false
            }]
        }
    });
}

createChart("mathChart",maths,"Mathematics","blue");
createChart("reasonChart",reasoning,"Reasoning","green");
createChart("compChart",computer,"Computer","orange");
createChart("mockChart",mock,"Full Mock","red");

function avg(arr){
    if(arr.length==0) return 0;
    return arr.reduce((a,b)=>a+b,0)/arr.length;
}

new Chart(document.getElementById("pieChart"),{
    type:'pie',
    data:{
        labels:["Maths","Reasoning","Computer","Mock"],
        datasets:[{
            data:[avg(maths),avg(reasoning),avg(computer),avg(mock)]
        }]
    }
});

</script>

<?php include("includes/footer.php"); ?>