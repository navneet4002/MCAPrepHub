<?php
include("../includes/db.php");

$msg = "";

if(isset($_POST['add'])){

    $test_id = $_POST['test_id'];

    $questions = $_POST['question'];
    $o1 = $_POST['o1'];
    $o2 = $_POST['o2'];
    $o3 = $_POST['o3'];
    $o4 = $_POST['o4'];
    $correct = $_POST['correct'];

    for($i=0; $i<count($questions); $i++){

        // skip empty questions
        if(empty($questions[$i])) continue;

        mysqli_query($conn,"INSERT INTO questions(test_id,question,option1,option2,option3,option4,correct_option)
        VALUES('$test_id','".$questions[$i]."','".$o1[$i]."','".$o2[$i]."','".$o3[$i]."','".$o4[$i]."','".$correct[$i]."')");
    }

    $msg = "All Questions Added Successfully!";
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="navbar">
    <div><b>MCAPrepHub</b></div>
</div>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>Admin Panel</h3>

        <a href="admin_dashboard.php">Dashboard</a>
        <a href="add_test.php">Add Test</a>
        <a href="view_tests.php">View Tests</a>

        <a href="add_question.php" class="active">Add Questions</a>
        <a href="view_questions.php">View Questions</a>

        <a href="add_study.php">Add Study Material</a>
        <a href="view_study.php">View Study</a>

        <a href="view_queries.php">Queries</a>
        <a href="users.php">Users</a>

        <a href="admin_login.php">Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="form-box">
        <h2>Add Questions (Bulk)</h2>

        <form method="POST">

        <!-- TEST SELECT -->
        <select name="test_id" required>
            <option value="">Select Test</option>

            <?php
            $res=mysqli_query($conn,"SELECT * FROM tests");
            while($row=mysqli_fetch_assoc($res)){
            ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['title']; ?>
            </option>
            <?php } ?>
        </select>

        <br><br>

        <!-- QUESTION COUNT -->
        <input type="number" id="qcount" placeholder="Enter No. of Questions (e.g. 25)">
        <button type="button" onclick="generateQuestions()" class="btn">Generate</button>

        <br><br>

        <!-- QUESTIONS WILL APPEAR HERE -->
        <div id="questionsContainer"></div>

        <br>

        <button name="add" class="btn">Add All Questions</button>

        </form>

        <p><?php echo $msg; ?></p>

        </div>

    </div>
</div>

<!-- JS -->
<script>
function generateQuestions(){

    let count = document.getElementById("qcount").value;
    let container = document.getElementById("questionsContainer");

    container.innerHTML = "";

    if(count <= 0){
        alert("Enter valid number");
        return;
    }

    for(let i=1; i<=count; i++){

        container.innerHTML += `
        <div class="card" style="margin-bottom:20px;">
            <h4>Question ${i}</h4>

            <textarea name="question[]" placeholder="Enter Question" required></textarea>

            <input name="o1[]" placeholder="Option 1" required>
            <input name="o2[]" placeholder="Option 2" required>
            <input name="o3[]" placeholder="Option 3" required>
            <input name="o4[]" placeholder="Option 4" required>

            <input name="correct[]" placeholder="Correct Option (1-4)" required>
        </div>
        `;
    }
}
</script>

<?php include("../includes/footer.php"); ?>