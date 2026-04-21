<?php
session_start();
include("includes/db.php");
include("includes/header.php");

$test_id = $_GET['id'] ?? 0;

$test = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM tests WHERE id='$test_id'"));
$time = $test['duration'] ?? 600;

// QUESTIONS
$questions = [];
$res = mysqli_query($conn,"SELECT * FROM questions WHERE test_id='$test_id'");
while($row = mysqli_fetch_assoc($res)){
    $questions[] = $row;
}

$total = count($questions);
?>

<div class="exam-wrapper">

<!-- 🔥 FIXED TIMER BAR -->
<div class="timer-bar">
    <div class="left-title">📋 Online Test</div>

    <div class="timer-box">
        ⏳ <span id="time-text">00:00</span>
    </div>

    <button class="submit-btn" onclick="submitTest()">Submit Test</button>
</div>

<div class="exam-body">

<!-- LEFT -->
<div class="left">

<h2><?php echo $test['title']; ?></h2>
<p>Question <span id="qno">1</span> of <?php echo $total; ?></p>

<form method="POST" action="result.php" id="form">

<input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
<input type="hidden" name="time_taken" id="time_taken">

<?php foreach($questions as $index => $q){ ?>

<div class="question-box" id="q<?php echo $index; ?>">

<h3><?php echo $q['question']; ?></h3>

<?php for($i=1;$i<=4;$i++){ ?>
<div class="opt">
    <input type="radio" 
        name="q<?php echo $q['id']; ?>" 
        id="q<?php echo $q['id'].'_'.$i; ?>" 
        value="<?php echo $i; ?>">
    <label for="q<?php echo $q['id'].'_'.$i; ?>">
        <?php echo $q['option'.$i]; ?>
    </label>
</div>
<?php } ?>

</div>

<?php } ?>

</form>

<div class="bottom-nav">
    <button onclick="prevQ()">⬅ Previous</button>
    <button onclick="nextQ()">Save & Next ➡</button>
</div>

</div>

<!-- RIGHT -->
<div class="right">

<h3>Question Navigation</h3>

<div class="grid">
<?php for($i=0;$i<$total;$i++){ ?>
    <div class="box" id="nav<?php echo $i; ?>" onclick="goToQ(<?php echo $i; ?>)">
        <?php echo $i+1; ?>
    </div>
<?php } ?>
</div>

</div>

</div>
</div>

<script>
let current = 0;
let total = <?php echo $total; ?>;

showQ(current);

function showQ(i){
    document.querySelectorAll(".question-box").forEach(q=>q.style.display="none");
    document.getElementById("q"+i).style.display="block";
    document.getElementById("qno").innerText = i+1;
}

function nextQ(){
    mark();
    if(current < total-1){
        current++;
        showQ(current);
    }
}

function prevQ(){
    if(current > 0){
        current--;
        showQ(current);
    }
}

function goToQ(i){
    current = i;
    showQ(i);
}

function mark(){
    let radios = document.querySelectorAll(`#q${current} input`);
    radios.forEach(r=>{
        if(r.checked){
            document.getElementById("nav"+current).classList.add("done");
        }
    });
}

function submitTest(){
    document.getElementById("form").submit();
}

// 🔥 TIMER
let time = <?php echo $time ? $time : 600; ?>;
let totalTime = time;

function updateTimer(){
    let m = Math.floor(time/60);
    let s = time % 60;

    if(s < 10) s = "0" + s;
    if(m < 10) m = "0" + m;

    document.getElementById("time-text").innerText = m + ":" + s;
    document.getElementById("time_taken").value = totalTime - time;
}

updateTimer();

let timerInterval = setInterval(() => {
    time--;
    updateTimer();

    if(time < 0){
        clearInterval(timerInterval);
        alert("⏰ Time up!");
        submitTest();
    }
}, 1000);
</script>

<style>

/* 🔥 TIMER BAR FIX */
.timer-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 20px;
    background:#fff;
    border-bottom:1px solid #ddd;
}

/* TIMER BOX */
.timer-box{
    background:#ef4444;
    padding:10px 20px;
    border-radius:10px;
    color:white;
    font-weight:bold;
    font-size:18px;
}

/* BUTTON */
.submit-btn{
    background:#2563eb;
    color:white;
    border:none;
    padding:10px 16px;
    border-radius:8px;
}

/* BODY */
.exam-body{
    display:flex;
    gap:20px;
    padding:20px;
}

.left{
    flex:3;
    background:white;
    padding:20px;
    border-radius:10px;
}

.right{
    flex:1;
    background:white;
    padding:20px;
    border-radius:10px;
}

/* OPTIONS */
.opt label{
    display:block;
    padding:12px;
    margin:10px 0;
    background:#f1f5f9;
    border-radius:6px;
}

.opt input{
    display:none;
}

.opt input:checked + label{
    background:#bbf7d0;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:10px;
}

.box{
    padding:10px;
    text-align:center;
    background:#e5e7eb;
    border-radius:6px;
    cursor:pointer;
}

.box.done{
    background:#22c55e;
    color:white;
}

/* NAV */
.bottom-nav{
    display:flex;
    justify-content:space-between;
    margin-top:20px;
}

.bottom-nav button{
    padding:10px 15px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:6px;
}

</style>

<?php include("includes/footer.php"); ?>