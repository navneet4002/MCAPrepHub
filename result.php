<?php
session_start();
include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];
$user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE email='$email'"));
$user_id = $user['id'];

/* =========================
   🔥 CASE 1: FORM SUBMIT
========================= */
if(isset($_POST['test_id'])){

    $test_id = $_POST['test_id'];
    $time_taken = $_POST['time_taken'] ?? 0;

    $q = mysqli_query($conn,"SELECT * FROM questions WHERE test_id='$test_id'");
    $total = mysqli_num_rows($q);

    $correct = 0;
    $wrong = 0;
    $unattempted = 0;
    $score = 0;

    mysqli_query($conn,"DELETE FROM user_answers WHERE user_id='$user_id' AND test_id='$test_id'");

    while($row=mysqli_fetch_assoc($q)){
        $qid = $row['id'];
        $user_ans = $_POST["q$qid"] ?? 0;

        mysqli_query($conn,"INSERT INTO user_answers(user_id,test_id,question_id,selected_option)
        VALUES('$user_id','$test_id','$qid','$user_ans')");

        if($user_ans == 0){
            $unattempted++;
        }
        else if($user_ans == $row['correct_option']){
            $correct++;
            $score += 4;
        }
        else{
            $wrong++;
            $score -= 1;
        }
    }

    $total_marks = $total * 4;
    $percentage = $total_marks > 0 ? ($score / $total_marks) * 100 : 0;
    $accuracy = $total > 0 ? ($correct / $total) * 100 : 0;

    mysqli_query($conn,"INSERT INTO results(user_id,test_id,score,total,correct,wrong,unattempted,time_taken)
    VALUES('$user_id','$test_id','$score','$total','$correct','$wrong','$unattempted','$time_taken')");

    // 🔥 IMPORTANT: REDIRECT (fix resubmission + FK issue)
    header("Location: result.php?test_id=".$test_id);
    exit;
}


/* =========================
   🔥 CASE 2: RESULT DISPLAY
========================= */

$test_id = $_GET['test_id'] ?? 0;

$res = mysqli_query($conn,"
SELECT * FROM results 
WHERE test_id='$test_id'
ORDER BY id DESC LIMIT 1
");

$data = mysqli_fetch_assoc($res);

$score = $data['score'] ?? 0;
$total = $data['total'] ?? 0;
$correct = $data['correct'] ?? 0;
$wrong = $data['wrong'] ?? 0;
$unattempted = $data['unattempted'] ?? 0;
$time_taken = $data['time_taken'] ?? 0;

$total_marks = $total * 4;
$percentage = $total_marks > 0 ? ($score / $total_marks) * 100 : 0;
$accuracy = $total > 0 ? ($correct / $total) * 100 : 0;

$minutes = floor($time_taken / 60);
$seconds = $time_taken % 60;

if($percentage >= 80){
    $message = "🔥 Excellent Performance";
}
elseif($percentage >= 50){
    $message = "👍 Good Job";
}
else{
    $message = "⚠️ Keep Practicing";
}

/* =========================
   🔥 AUTO DELETE TEMP TEST (SAFE)
========================= */

$res2 = mysqli_query($conn,"SELECT is_temporary FROM tests WHERE id='$test_id'");
$row2 = mysqli_fetch_assoc($res2);

if($row2 && $row2['is_temporary'] == 1){
    mysqli_query($conn,"DELETE FROM questions WHERE test_id='$test_id'");
    mysqli_query($conn,"DELETE FROM tests WHERE id='$test_id'");
}
?>

<link rel="stylesheet" href="css/style.css">

<style>
body{
    background:#f3f4f6;
}

.result-wrapper{
    min-height:90vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;
}

.result-card{
    width:100%;
    max-width:850px;
    background:white;
    border-radius:14px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    text-align:center;
}

.progress{
    height:12px;
    background:#e5e7eb;
    border-radius:10px;
    overflow:hidden;
    margin:20px 0;
}
.fill{
    height:100%;
    background:linear-gradient(90deg,#22c55e,#4f46e5);
}

.stats{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
    margin-top:20px;
}
.stat{
    padding:15px;
    border-radius:10px;
    background:#f1f5f9;
    font-weight:500;
}

.btn{
    padding:10px 16px;
    border:none;
    border-radius:8px;
    background:#2563eb;
    color:white;
    transition:0.3s;
}
.btn:hover{
    background:#1d4ed8;
    transform:scale(1.05);
}

.btn-group{
    margin-top:25px;
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    justify-content:center;
}
</style>

<div class="result-wrapper">

<div class="result-card">

<h2>🎉 Test Completed</h2>

<h3><?php echo $score; ?> / <?php echo $total_marks; ?></h3>

<div class="progress">
    <div class="fill" style="width:<?php echo $percentage; ?>%"></div>
</div>

<p><b>Percentage:</b> <?php echo round($percentage,2); ?>%</p>
<p><b>Accuracy:</b> <?php echo round($accuracy,2); ?>%</p>
<p><b>Time Taken:</b> <?php echo $minutes; ?>m <?php echo $seconds; ?>s</p>

<h3><?php echo $message; ?></h3>

<div class="stats">
    <div class="stat">✔ Correct: <?php echo $correct; ?></div>
    <div class="stat">❌ Wrong: <?php echo $wrong; ?></div>
    <div class="stat">⚪ Unattempted: <?php echo $unattempted; ?></div>
    <div class="stat">📊 Score: <?php echo $score; ?></div>
</div>

<p style="margin-top:20px;">
<b>📌 Insight:</b><br>
<?php
if($wrong > $correct){
    echo "You need more practice on this topic.";
}
elseif($correct >= ($total * 0.7)){
    echo "You have strong command on this topic.";
}
else{
    echo "You are improving, keep going!";
}
?>
</p>

<div class="btn-group">

<a href="dashboard.php"><button class="btn">🏠 Dashboard</button></a>

<a href="performance.php"><button class="btn">📊 Performance</button></a>
<a href="review.php?test_id=<?php echo $test_id; ?>"><button class="btn">📖 Review</button></a>

</div>

</div>

</div>

<?php include("includes/footer.php"); ?>