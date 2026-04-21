<?php
include("../includes/db.php");
include("../includes/header.php");
// Fix sidebar color

$current = basename($_SERVER['PHP_SELF']);

// ✅ FIX PATH
include("../ai/ai_helper.php");

$msg = "";

// MANUAL ADD
if(isset($_POST['add'])){
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $minutes = $_POST['duration'];
    $duration = $minutes * 60;
    $desc = mysqli_real_escape_string($conn,$_POST['description']);
    $cat = $_POST['category'];

    mysqli_query($conn,"INSERT INTO tests(title,duration,description,category)
    VALUES('$title','$duration','$desc','$cat')");

    $msg = "✅ Test Added Successfully!";
}
?>

<link rel="stylesheet" href="../css/style.css">

<style>

body{
    background:#f3f4f6;
}

/* MAIN */
.main{
    padding:30px;
}

/* TITLE */
.page-title{
    text-align:center;
    font-size:28px;
    margin-bottom:20px;
}

/* BUTTONS */
.mode-buttons{
    display:flex;
    justify-content:center;
    gap:15px;
    margin-bottom:30px;
}

.mode-btn{
    padding:12px 22px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

.ai-btn{
    background:#0ea5e9;
    color:white;
}

.manual-btn{
    background:#f97316;
    color:white;
}

/* CARDS */
.card-container{
    display:flex;
    justify-content:center;
    gap:70px;
    margin-bottom:30px;
}

.card{
    width:260px;
    background:white;
    border-radius:20px;
    padding:20px;
    text-align:center;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
    cursor:pointer;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card img{
    width:200px;
    margin-bottom:10px;
}

/* FORM */
.form-box{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    max-width:500px;
    margin:auto;
}

/* INPUT */
input, select, textarea{
    width:100%;
    margin:10px 0;
    padding:10px;
    border-radius:8px;
    border:1px solid #d1d5db;
}

/* BTN */
.btn{
    width:100%;
    padding:10px;
    background:#0ea5e9;
    border:none;
    border-radius:8px;
    color:white;
    font-weight:bold;
}

/* HIDE */
.hidden{
    display:none;
}

</style>

<div class="layout">

<!-- SIDEBAR -->
<?php include("admin_sidebar.php"); ?>
<!-- MAIN -->
<div class="main">

<h2 class="page-title">💬 Add Test</h2>

<!-- BUTTONS -->
<div class="mode-buttons">
    <button class="mode-btn ai-btn" onclick="showAI()">🤖 Generate via AI</button>
    <button class="mode-btn manual-btn" onclick="showManual()">🔥 Enter Manual</button>
</div>

<!-- CARDS -->
<div class="card-container">

<div class="card" onclick="showAI()">
    <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png">
    <h3>Generate via AI</h3>
    <p>Automatically create test using AI</p>
</div>

<div class="card" onclick="showManual()">
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png">
    <h3>Enter Manual</h3>
    <p>Manually create test and add questions</p>
</div>

</div>

<!-- AI FORM -->
<div id="aiSection" class="form-box hidden">

<h3>AI Generator</h3>

<select id="category">
<option value="maths">Maths</option>
<option value="reasoning">Reasoning</option>
<option value="computer">Computer</option>
<option value="full_mock">Full Mock</option>
</select>

<input id="topic" placeholder="Topic (optional)">

<select id="difficulty">
<option value="easy">Easy</option>
<option value="medium">Medium</option>
<option value="hard">Hard</option>
</select>

<input type="number" id="num" value="5">
<input type="number" id="time" value="10">

<button onclick="generateTest()" class="btn">🚀 Generate Test</button>

</div>

<!-- MANUAL FORM -->
<div id="manualSection" class="form-box hidden">

<h3>Manual Test</h3>

<form method="POST">

<input name="title" placeholder="Test Title" required>
<input type="number" name="duration" placeholder="Duration (minutes)" required>

<select name="category" required>
<option value="">Select Category</option>
<option value="full_mock">Full Mock</option>
<option value="maths">Maths</option>
<option value="reasoning">Reasoning</option>
<option value="computer">Computer</option>
</select>

<textarea name="description" placeholder="Description"></textarea>

<button name="add" class="btn">Add Test</button>

</form>

<p><?php echo $msg; ?></p>

</div>

</div>
</div>

<script>

function showAI(){
    document.getElementById("aiSection").classList.remove("hidden");
    document.getElementById("manualSection").classList.add("hidden");
}

function showManual(){
    document.getElementById("manualSection").classList.remove("hidden");
    document.getElementById("aiSection").classList.add("hidden");
}

// AI CALL
function generateTest(){

let data = new FormData();

data.append("category", document.getElementById("category").value);
data.append("topic", document.getElementById("topic").value);
data.append("difficulty", document.getElementById("difficulty").value);
data.append("num", document.getElementById("num").value);
data.append("time", document.getElementById("time").value);

// 🔥 ADMIN FLAG
data.append("admin", "1");

// 🔥 LOADER
let btn = document.querySelector(".btn");
btn.innerText = "⏳ Generating AI Test...";
btn.disabled = true;

fetch("../ai/generate_ai_test.php", {
    method: "POST",
    body: data
})
.then(res => res.text())
.then(res => {

    btn.innerText = "🚀 Generate Test";
    btn.disabled = false;

    if(res === "success"){
        alert("✅ Test Generated & Saved!");
        window.location.href = "view_tests.php";
    } else {
        alert("Error: " + res);
    }
});
}

</script>

<?php include("../includes/footer.php"); ?>