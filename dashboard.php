
<?php
include("includes/auth.php");
include("includes/db.php");
include("includes/header.php");

$category = $_GET['cat'] ?? 'all';
?>

<style>
.ai-card {
    border: 1px solid #6366f1;
    box-shadow: 0 0 15px rgba(99,102,241,0.4);
}

.ai-modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(6px);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.ai-modal-box {
    width: 420px;
    background: #0f172a;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 0 30px rgba(99,102,241,0.4);
}

.form-group {
    margin-bottom: 12px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 8px;
    border-radius: 8px;
    border: none;
    background: #1f2937;
    color: white;
}

.modal-actions {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
}
</style>

<div class="layout">

<?php include("includes/sidebar.php"); ?>

<div class="main">

<h2>📚 Topic Wise Tests</h2>

<p style="color:#9ca3af; margin-bottom:20px;">
Practice topic-wise tests and improve your performance.
</p>

<!-- CATEGORY FILTER -->
<div style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">

<a href="dashboard.php?cat=all"><button class="btn <?php if($category=='all') echo 'active'; ?>">All</button></a>
<a href="dashboard.php?cat=full_mock"><button class="btn <?php if($category=='full_mock') echo 'active'; ?>">Full Mock</button></a>
<a href="dashboard.php?cat=maths"><button class="btn <?php if($category=='maths') echo 'active'; ?>">Maths</button></a>
<a href="dashboard.php?cat=reasoning"><button class="btn <?php if($category=='reasoning') echo 'active'; ?>">Reasoning</button></a>
<a href="dashboard.php?cat=computer"><button class="btn <?php if($category=='computer') echo 'active'; ?>">Computer</button></a>
<a href="dashboard.php?cat=ai"><button class="btn <?php if($category=='ai') echo 'active'; ?>">🤖 AI Tests</button></a>

</div>

<!-- GENERATE BUTTON -->
<div style="margin:20px 0;">
<button onclick="openAIModal()" class="btn" style="background:#6366f1;">
🤖 Generate AI Test
</button>
</div>

<!-- TEST CARDS -->
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:20px;">

<?php
$query = ($category == "all")
    ? "SELECT * FROM tests ORDER BY created_at DESC"
    : "SELECT * FROM tests WHERE category='$category' ORDER BY created_at DESC";

$res = mysqli_query($conn, $query);

if(mysqli_num_rows($res)>0){
    while($row=mysqli_fetch_assoc($res)){
?>

<div class="card glass <?php if($row['category']=='ai') echo 'ai-card'; ?>">

<h3><?php echo $row['title']; ?></h3>

<p><b>Category:</b> <?php echo strtoupper($row['category']); ?></p>
<p><b>Duration:</b> <?php echo $row['duration']/60; ?> mins</p>

<?php if(!empty($row['difficulty'])){ ?>
<p>
<b>Difficulty:</b>
<span style="color:
<?php
if($row['difficulty']=='easy') echo 'lightgreen';
elseif($row['difficulty']=='medium') echo 'orange';
else echo 'red';
?>">
<?php echo ucfirst($row['difficulty']); ?>
</span>
</p>
<?php } ?>

<a href="test.php?id=<?php echo $row['id']; ?>">
<button class="btn">Start Test</button>
</a>

</div>

<?php
    }
}else{
    echo "<p style='color:#aaa;'>No tests found</p>";
}
?>

</div>

</div>
</div>

<!-- MODAL -->
<div id="aiModal" class="ai-modal-overlay">
<div class="ai-modal-box">

<h2 style="text-align:center;">🤖 Generate AI Test</h2>

<div class="form-group">
<label>Category</label>
<select id="category">
<option value="maths">Maths</option>
<option value="reasoning">Reasoning</option>
<option value="computer">Computer</option>
<option value="full_mock">Full Mock</option>
</select>
</div>

<div class="form-group" id="topicGroup">
<label>Topic</label>
<input type="text" id="topic" placeholder="e.g. DBMS">
</div>

<div class="form-group">
<label>Difficulty</label>
<select id="difficulty">
<option value="easy">Easy</option>
<option value="medium">Medium</option>
<option value="hard">Hard</option>
</select>
</div>

<div class="form-group">
<label>No. of Questions</label>
<input type="number" id="num" value="5">
</div>

<div class="form-group">
<label>Time (minutes)</label>
<input type="number" id="time" value="10">
</div>

<div class="modal-actions">
<button onclick="generateTest()" class="btn">Generate</button>
<button onclick="closeAIModal()" class="btn">Cancel</button>
</div>

</div>
</div>

<!-- LOADER -->
<div id="loader" style="
display:none;
position:fixed;
top:0; left:0;
width:100%; height:100%;
background:rgba(0,0,0,0.7);
z-index:1000;
justify-content:center;
align-items:center;
color:white;
font-size:20px;">
⏳ Generating AI Test...
</div>

<!-- FINAL SCRIPT -->
<script>

function openAIModal(){
    document.getElementById("aiModal").style.display = "flex";
}

function closeAIModal(){
    document.getElementById("aiModal").style.display = "none";
}

window.onclick = function(e){
    let modal = document.getElementById("aiModal");
    if(e.target == modal){
        modal.style.display = "none";
    }
}

// hide topic for full mock
document.getElementById("category").addEventListener("change", function(){
    document.getElementById("topicGroup").style.display =
        this.value === "full_mock" ? "none" : "block";
});

function generateTest(){

    let category = document.getElementById("category").value;
    let topic = document.getElementById("topic").value.trim();
    let num = document.getElementById("num").value;
    let time = document.getElementById("time").value;
    let difficulty = document.getElementById("difficulty").value;

    if(category !== "full_mock" && !topic){
        alert("Enter topic!");
        return;
    }

    if(category === "full_mock"){
        topic = "Full Mock";
    }

    document.getElementById("aiModal").style.display = "none";
    document.getElementById("loader").style.display = "flex";

    fetch("ai/generate_ai_test.php", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: `category=${encodeURIComponent(category)}
        &topic=${encodeURIComponent(topic)}
        &num=${num}
        &time=${time}
        &difficulty=${encodeURIComponent(difficulty)}`
    })
    .then(res => res.text())
    .then(data => {

        document.getElementById("loader").style.display = "none";

        data = data.trim();
        console.log("AI RESPONSE:", data);

        if(data.includes("test.php")){
            window.location.href = data;
        } else {
            alert("❌ AI failed to generate test");
            console.log(data);
        }

    })
    .catch(err => {
        document.getElementById("loader").style.display = "none";
        alert("Server error!");
        console.error(err);
    });
}

</script>

<?php include("includes/footer.php"); ?>