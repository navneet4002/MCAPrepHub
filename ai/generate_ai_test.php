<?php
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

include(__DIR__ . "/../includes/db.php");
include(__DIR__ . "/ai_helper.php");

session_start();

$category   = $_POST['category'] ?? '';
$topic      = $_POST['topic'] ?? '';
$totalQ     = intval($_POST['num'] ?? 5); // no limit
$time       = intval($_POST['time'] ?? 10);
$difficulty = $_POST['difficulty'] ?? 'medium';

// ADMIN CHECK
$is_temp = 1;
if(isset($_SESSION['admin_id']) || isset($_POST['admin'])){
    $is_temp = 0;
}

// CREATE TEST FIRST
$title = ($category === "full_mock") ? "Full Mock Test" : $topic;
$duration = $time * 60;

mysqli_query($conn,"INSERT INTO tests 
(title,category,duration,topic,difficulty,is_temporary)
VALUES ('$title','$category','$duration','$topic','$difficulty','$is_temp')");

$test_id = mysqli_insert_id($conn);

$ans_map = ['a'=>1,'b'=>2,'c'=>3,'d'=>4];

$remaining = $totalQ;

// 🔥 LOOP BATCH (SAFE)
while($remaining > 0){

    // small batch
    $batchSize = ($remaining >= 3) ? 3 : $remaining;

    // PROMPT
    if($category === "full_mock"){
        $prompt = "Generate $batchSize $difficulty level MCQs in STRICT JSON format.

Mix questions from:
- Mathematics
- Logical Reasoning
- Computer Science

Return ONLY JSON array.";
    } else {
        $prompt = "Generate $batchSize $difficulty level MCQs in STRICT JSON format.

Topic: $topic

Return ONLY JSON array.";
    }

    // AI CALL
    $response = askAI($prompt);

    // CLEAN JSON
    $clean = preg_replace('/```json|```/i', '', $response);
    $clean = preg_replace('/^[^\[]*/', '', $clean);
    $clean = preg_replace('/[^\]]*$/', '', $clean);

    $data = json_decode(trim($clean), true);

    if(!$data || !is_array($data)){
        break; // AI fail
    }

    foreach($data as $q){

        if(empty($q['question']) || count($q['options']) < 4) continue;

        // 🔥 reconnect each time (IMPORTANT)
        include(__DIR__ . "/../includes/db.php");

        $question = mysqli_real_escape_string($conn, $q['question']);
        $opt1 = mysqli_real_escape_string($conn, $q['options'][0]);
        $opt2 = mysqli_real_escape_string($conn, $q['options'][1]);
        $opt3 = mysqli_real_escape_string($conn, $q['options'][2]);
        $opt4 = mysqli_real_escape_string($conn, $q['options'][3]);
        $explanation = mysqli_real_escape_string($conn, $q['explanation'] ?? '');

        $correct = $ans_map[strtolower($q['answer'])] ?? 1;

        mysqli_query($conn,"INSERT INTO questions 
        (test_id,question,option1,option2,option3,option4,correct_option,explanation)
        VALUES ('$test_id','$question','$opt1','$opt2','$opt3','$opt4','$correct','$explanation')");
    }

    $remaining -= $batchSize;
}

// FINAL RESPONSE
if($is_temp == 0){
    echo "success";
} else {
    echo "test.php?id=".$test_id;
}

ob_end_flush();
?>