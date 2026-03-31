<?php
// SAFE SESSION START
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

include("includes/db.php");

// LOGIN CHECK
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// USER FETCH
$email = $_SESSION['user'];

$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM users WHERE email='$email'"));

$user_id = $user['id'];

//  TEST ID
$test_id = $_GET['test_id'];

// FETCH QUESTIONS + USER ANSWERS
$res = mysqli_query($conn,"
SELECT q.*, ua.selected_option 
FROM questions q
LEFT JOIN user_answers ua 
ON q.id = ua.question_id 
AND ua.user_id='$user_id'
AND ua.test_id='$test_id'
WHERE q.test_id='$test_id'
");

$qno = 1;
?>


<link rel="stylesheet" href="css/style.css">

<div class="review-container">
<h2>Review Answers</h2>

<div class="review-grid">

<?php while($q=mysqli_fetch_assoc($res)){ ?>

<div class="card">
    <p><b>Q<?php echo $qno++; ?>. <?php echo $q['question']; ?></b></p>

<p>
<?php
if($q['selected_option'] == $q['correct_option']){
    echo "<span style='color:green;'>✔ Correct</span>";
}
elseif(empty($q['selected_option'])){
    echo "<span style='color:gray;'>⚪ Unattempted</span>";
}
else{
    echo "<span style='color:red;'>❌ Wrong</span>";
}
?>
</p>



<?php 
for($i=1;$i<=4;$i++){

    $option = $q["option".$i];
    $class = "option";

    if($i == $q['correct_option']){
        $class = "correct";
    }
    elseif($i == $q['selected_option']){
        $class = "wrong";
    }
?>
    <p class="<?php echo $class; ?>">
        <?php
        if($i == $q['correct_option']){
            echo "✔ " . $option;
        }
        elseif($i == $q['selected_option']){
            echo "❌ " . $option;
        }
        else{
            echo $option;
        }
        ?>
    </p>

<?php } ?>

</div>

<?php } ?>

</div>
<div style="text-align:center; margin-top:20px;">

    <a href="performance.php">
        <button class="btn">Back to Result</button>
    </a>

</div>

</div>