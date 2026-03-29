<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

$email = $_SESSION['user'];
$user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE email='$email'"));
$user_id = $user['id'];

$test_id = $_POST['test_id'];

$q = mysqli_query($conn,"SELECT * FROM questions WHERE test_id='$test_id'");

$total = mysqli_num_rows($q);
$score = 0;

while($row=mysqli_fetch_assoc($q)){
    $qid = $row['id'];

    if(isset($_POST["q$qid"]) && $_POST["q$qid"] == $row['correct_option']){
        $score++;
    }
}

//  SAVE RESULT
mysqli_query($conn,"INSERT INTO results(user_id,test_id,score) VALUES('$user_id','$test_id','$score')");
?>

<link rel="stylesheet" href="css/style.css"

<div class="center">

<div class="result-box">

<h2>Test Completed 🎉</h2>

<p><b>Your Score:</b> <?php echo $score; ?> / <?php echo $total; ?></p>

<p>
<?php
$percent = ($score/$total)*100;

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

</div>

</div>

</div>
