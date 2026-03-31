<?php
session_start();
include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

$email = $_SESSION['user'];
$user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE email='$email'"));
$user_id = $user['id'];

$test_id = $_POST['test_id'];
$time_taken = $_POST['time_taken'];

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
$percentage = ($score / $total_marks) * 100;


//  SAVE RESULT
mysqli_query($conn,"INSERT INTO results(user_id,test_id,score,total,correct,wrong,unattempted,time_taken)
VALUES('$user_id','$test_id','$score','$total','$correct','$wrong','$unattempted','$time_taken')");
?>



<link rel="stylesheet" href="css/style.css">

<div class="center">

<div class="result-box">

<h2>Test Completed 🎉</h2>

<p><b>Your Score:</b> <?php echo $score; ?> / <?php echo $total_marks; ?></p>

<p><b>Percentage:</b> <?php echo round($percentage,2); ?>%</p>

<p><b>Correct:</b> <?php echo $correct; ?></p>
<p><b>Wrong:</b> <?php echo $wrong; ?></p>
<p><b>Unattempted:</b> <?php echo $unattempted; ?></p>
<p>

<?php
$percent = $percentage;

if($percent >= 80){
    echo "Excellent Performance ";
}
else if($percent >= 50){
    echo "Good Job 👍";
}
else{
    echo "Keep Practicing ";
}
?>
</p>

<!--  BUTTONS -->
<div style="margin-top:20px;">

<a href="dashboard.php">
<button class="btn">Back to Dashboard</button>
</a>

<a href="test.php?id=<?php echo $test_id; ?>">
<button class="btn">Retry Test</button>
</a>

<a href="performance.php">
<button class="btn">View Performance</button>
</a>

<a href="review.php?test_id=<?php echo $test_id; ?>">
<button class="btn">Review Answers</button>
</a>

</div>


</div>

</div>

</div>