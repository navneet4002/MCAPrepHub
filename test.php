<?php
session_start();
include("includes/db.php");

$test_id = $_GET['id'];

//  Get test info (for timer)
$test = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM tests WHERE id='$test_id'"));

$time = $test['duration'];   
$minutes = intval($time / 60);      

//  Get questions
$res = mysqli_query($conn,"SELECT * FROM questions WHERE test_id='$test_id'");
?>

<link rel="stylesheet" href="css/style.css">

<!-- TIMER -->
<div class="test-header">
    <h2>Test</h2>
    <h3 id="timer">Time: <?php echo $minutes; ?>:00</h3>
</div>

<div class="test-container">

<form method="POST" action="result.php" id="form">

<input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
<input type="hidden" name="time_taken" id="time_taken">

<div class="nav-panel">
<?php 
$i = 1;

// NAVIGATION LOOP
$qno = 1;
while($q=mysqli_fetch_assoc($res)){ ?>
    <button type="button" class="q-btn" 
    id="btn<?php echo $q['id']; ?>" 
    onclick="scrollToQ(<?php echo $q['id']; ?>)">
        <?php echo $i++; ?>
    </button>
<?php } ?>
</div>

<?php
$res = mysqli_query($conn,"SELECT * FROM questions WHERE test_id='$test_id'");

// QUESTIONS LOOP
$qno = 1;
while($q=mysqli_fetch_assoc($res)){ ?>

<div class="card" id="q<?php echo $q['id']; ?>">

    <p><b>Q<?php echo $qno++; ?>. <?php echo $q['question']; ?></b></p>

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
let totalTime = <?php echo $time; ?>; // original total time
let time = totalTime;

let timer = setInterval(function() {

    let minutes = Math.floor(time / 60);
    let seconds = time % 60;

    if (seconds < 10) {
        seconds = "0" + seconds;
    }

    document.getElementById("timer").innerHTML =
        "Time: " + minutes + ":" + seconds;

    // store time taken
    document.getElementById("time_taken").value = totalTime - time;

    // last 1 min red
    if(time <= 60){
        document.getElementById("timer").style.color = "red";
    }

    time--;

    if (time < 0) {
        clearInterval(timer);
        alert("Time is up! Submitting test...");
        document.getElementById("form").submit();
    }

}, 1000);
</script>

<script>
function scrollToQ(id){
    let element = document.getElementById("q"+id);

    window.scrollTo({
        top: element.offsetTop - 80, 
        behavior: "smooth"
    });
}
</script>
<script>
document.querySelectorAll("input[type=radio]").forEach(radio => {
    radio.addEventListener("change", function(){

        let name = this.name; // q5
        let id = name.replace("q","");

        let btn = document.getElementById("btn"+id);

        btn.style.background = "green";
        btn.style.color = "white";
    });
});
</script>