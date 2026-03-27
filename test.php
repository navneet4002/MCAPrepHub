<?php
session_start();
include("includes/db.php");

$test_id = $_GET['id'];

//  Get test info (for timer)
$test = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM tests WHERE id='$test_id'"));

$minutes = $test['duration'];   // stored in minutes
$time = $minutes * 60;          // convert to seconds

//  Get questions
$res = mysqli_query($conn,"SELECT * FROM questions WHERE test_id='$test_id'");
?>

<link rel="stylesheet" href="css/style.css">

<div class="container">

<h2>Test</h2>

<!-- TIMER -->
<h3 id="timer">Time: <?php echo $minutes; ?>:00</h3>

<form method="POST" action="result.php" id="form">

<input type="hidden" name="test_id" value="<?php echo $test_id; ?>">

<?php while($q=mysqli_fetch_assoc($res)){ ?>

<div class="card">
    <p><b><?php echo $q['question']; ?></b></p>

    <label>
        <input type="radio" name="q<?php echo $q['id']; ?>" value="1">
        <?php echo $q['option1']; ?>
    </label><br>

    <label>
        <input type="radio" name="q<?php echo $q['id']; ?>" value="2">
        <?php echo $q['option2']; ?>
    </label><br>

    <label>
        <input type="radio" name="q<?php echo $q['id']; ?>" value="3">
        <?php echo $q['option3']; ?>
    </label><br>

    <label>
        <input type="radio" name="q<?php echo $q['id']; ?>" value="4">
        <?php echo $q['option4']; ?>
    </label>
</div>

<?php } ?>

<button type="submit" class="btn">Submit Test</button>

</form>

</div>

<!--  TIMER SCRIPT -->
<script>
let time = <?php echo $time; ?>;

let timer = setInterval(function(){

    let minutes = Math.floor(time / 60);
    let seconds = time % 60;

    if(seconds < 10) seconds = "0" + seconds;

    document.getElementById("timer").innerHTML =
        "Time: " + minutes + ":" + seconds;

    // turn red in last minute
    if(time < 60){
        document.getElementById("timer").style.color = "red";
    }

    time--;

    if(time < 0){
        clearInterval(timer);
        alert("Time is up! Submitting test...");
        document.getElementById("form").submit();
    }

}, 1000);
</script>