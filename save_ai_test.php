<?php
session_start();
include(__DIR__ . "/../includes/db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = $_SESSION['ai_questions'] ?? [];

if(!$data){
    echo "NO_DATA";
    exit;
}

// TEST CREATE
$title = "AI Generated Test";
$duration = 600;

mysqli_query($conn,"INSERT INTO tests 
(title,category,duration,topic,difficulty,is_temporary)
VALUES ('$title','ai','$duration','AI','medium','1')");

$test_id = mysqli_insert_id($conn);

$ans_map = ['a'=>1,'b'=>2,'c'=>3,'d'=>4];

// SAFE INSERT
foreach($data as $q){

    if(empty($q['question']) || count($q['options']) < 4) continue;

    $question = mysqli_real_escape_string($conn, $q['question']);
    $opt1 = mysqli_real_escape_string($conn, $q['options'][0]);
    $opt2 = mysqli_real_escape_string($conn, $q['options'][1]);
    $opt3 = mysqli_real_escape_string($conn, $q['options'][2]);
    $opt4 = mysqli_real_escape_string($conn, $q['options'][3]);
    $correct = $ans_map[strtolower($q['answer'])] ?? 1;

    mysqli_query($conn,"INSERT INTO questions 
    (test_id,question,option1,option2,option3,option4,correct_option)
    VALUES ('$test_id','$question','$opt1','$opt2','$opt3','$opt4','$correct')");
}

// CLEAR SESSION
unset($_SESSION['ai_questions']);

// REDIRECT
echo "test.php?id=".$test_id;
?>