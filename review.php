<?php
session_start();
include("includes/db.php");
include("includes/header.php");

// ✅ Check login
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];

// ✅ Secure user fetch
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if(!$user){
    die("User not found");
}

$user_id = $user['id'];

// ✅ Validate test_id
$test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : 0;
if($test_id <= 0){
    die("Invalid Test ID");
}
?>

<!-- BACK BUTTON -->
<div style="padding:15px 20px;">
    <a href="result.php?test_id=<?php echo $test_id; ?>">
        <button style="
            background:#2563eb;
            color:white;
            border:none;
            padding:8px 14px;
            border-radius:6px;
            cursor:pointer;">
            ⬅ Back to Result
        </button>
    </a>
</div>

<?php
// ✅ Secure question fetch
$stmt = $conn->prepare("
SELECT q.*, ua.selected_option 
FROM questions q
LEFT JOIN user_answers ua 
ON q.id = ua.question_id 
AND ua.user_id=? 
AND ua.test_id=?
WHERE q.test_id=?
");

$stmt->bind_param("iii", $user_id, $test_id, $test_id);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];

while($row = $result->fetch_assoc()){
    // ✅ XSS protection
    foreach($row as $key => $val){
        $row[$key] = htmlspecialchars($val ?? '');
    }
    $questions[] = $row;
}

$total = count($questions);
?>

<style>
body{ background:#f3f4f6; }

.review-wrapper{
    display:flex;
    gap:20px;
    padding:20px;
    min-height:100vh;
}

.review-left{
    flex:3;
    background:white;
    border-radius:12px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.review-right{
    flex:1;
    background:white;
    border-radius:12px;
    padding:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.option{
    padding:14px;
    margin:10px 0;
    border-radius:8px;
    background:#f9fafb;
    border:1px solid #e5e7eb;
}

.correct{
    background:#dcfce7 !important;
    border:2px solid #22c55e !important;
}

.wrong{
    background:#fee2e2 !important;
    border:2px solid #ef4444 !important;
}

.q-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:10px;
}

.q-btn{
    padding:10px;
    border:none;
    border-radius:8px;
    background:#e5e7eb;
    cursor:pointer;
}

.q-btn.active{
    background:#22c55e;
    color:white;
}

.q-btn:disabled{
    background:#d1d5db;
    cursor:not-allowed;
}

.nav-btn{
    padding:10px 18px;
    border:none;
    border-radius:8px;
    background:#2563eb;
    color:white;
    cursor:pointer;
}

.nav-btn:disabled{
    background:#9ca3af;
    cursor:not-allowed;
}

.solution{
    margin-top:15px;
    padding:12px;
    background:#f9fafb;
    border-left:4px solid #22c55e;
}
</style>

<div class="review-wrapper">

<div class="review-left" id="questionBox"></div>

<div class="review-right">
<h3>Questions</h3>

<div class="q-grid">
<?php for($i=0;$i<$total;$i++){ ?>
<button class="q-btn" onclick="loadQ(<?php echo $i; ?>)">
<?php echo $i+1; ?>
</button>
<?php } ?>
</div>

</div>
</div>

<script>
// ✅ Safe JSON encoding
let questions = <?php echo json_encode($questions, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

let current = 0;

function getCorrectNumber(val){
    if(!val) return -1;
    val = String(val).toLowerCase();
    if(val==='a') return 1;
    if(val==='b') return 2;
    if(val==='c') return 3;
    if(val==='d') return 4;
    return Number(val);
}

function loadQ(index){
    current = index;
    let q = questions[index];

    let correct = getCorrectNumber(q.correct_option);
    let selected = Number(q.selected_option) || 0;

    let html = `<h3>Q${index+1}. ${q.question}</h3>`;

    for(let i=1;i<=4;i++){
        let cls = "option";
        if(i===correct) cls+=" correct";
        if(i===selected && i!==correct) cls+=" wrong";

        html += `<div class="${cls}">${q["option"+i]}</div>`;
    }

    if(q.explanation){
        html += `<div class="solution"><b>💡 Solution:</b><br>${q.explanation}</div>`;
    }

    html += `
    <div style="margin-top:20px; display:flex; justify-content:space-between;">
        <button class="nav-btn" onclick="prevQ()" ${current===0?'disabled':''}>⬅ Previous</button>
        <button class="nav-btn" onclick="nextQ()" ${current===questions.length-1?'disabled':''}>Next ➡</button>
    </div>`;

    document.getElementById("questionBox").innerHTML = html;

    document.querySelectorAll(".q-btn").forEach((btn,i)=>{
        btn.classList.remove("active");
        if(i===index) btn.classList.add("active");
    });
}

function nextQ(){
    if(current < questions.length-1){
        loadQ(current+1);
    }
}

function prevQ(){
    if(current > 0){
        loadQ(current-1);
    }
}

// ✅ Load first question
if(questions.length > 0){
    loadQ(0);
}else{
    document.getElementById("questionBox").innerHTML = "<h3>No questions found</h3>";
}
</script>

<?php include("includes/footer.php"); ?>