<?php
include("../includes/db.php");
include("ai_helper.php");

session_start();

$user_id = $_SESSION['user_id'] ?? 1;
$chat_id = $_POST['chat_id'] ?? 0;
$message = trim($_POST['message'] ?? '');
$mode = $_POST['mode'] ?? '';

if(!$message){
    echo "Empty message";
    exit;
}

// 🔥 ORIGINAL USER MESSAGE (save for history)
$original_message = $message;

// 🔥 PROMPT MODIFY
if($mode == "notes"){
    $message = "Explain in short exam notes format with headings, bullet points and simple language:\n".$message;
}
elseif($mode == "mcq"){
    $message = "Generate exactly 5 MCQs in STRICT format:

Q1. Question
a) option1
b) option2
c) option3
d) option4
Answer: a

No extra text.

Topic: ".$message;
}
elseif($mode == "plan"){
    $message = "Create a structured study plan with days, topics and tasks:\n".$message;
}

// 🔥 CALL AI
$response = askAI($message);


// ================== 🔥 MCQ → TEST ==================
if($mode == "mcq"){

    $title = "AI Test - ".date("H:i");

    mysqli_query($conn,"INSERT INTO tests (title,category,duration)
    VALUES ('$title','ai',600)");

    $test_id = mysqli_insert_id($conn);

    // 🔥 CLEAN RESPONSE
    $clean = strip_tags($response);
    $clean = html_entity_decode($clean);

    preg_match_all('/Q[0-9]+\..*?Answer:\s*[a-d]/is',$clean,$matches);

    foreach($matches[0] as $block){

        preg_match('/Q[0-9]+\.\s*(.*)/',$block,$q);

        // ✅ FIXED REGEX (non-greedy + line safe)
        preg_match('/a\)\s*(.*?)\n/',$block,$a);
        preg_match('/b\)\s*(.*?)\n/',$block,$b);
        preg_match('/c\)\s*(.*?)\n/',$block,$c);
        preg_match('/d\)\s*(.*?)\n/',$block,$d);

        preg_match('/Answer:\s*([a-d])/i',$block,$ans);

        $question = mysqli_real_escape_string($conn, $q[1] ?? '');
        $opt1 = mysqli_real_escape_string($conn, $a[1] ?? '');
        $opt2 = mysqli_real_escape_string($conn, $b[1] ?? '');
        $opt3 = mysqli_real_escape_string($conn, $c[1] ?? '');
        $opt4 = mysqli_real_escape_string($conn, $d[1] ?? '');
        $correct = strtolower($ans[1] ?? 'a');

        if($question){
            // ✅ FIX: option_a → option1
            mysqli_query($conn,"INSERT INTO questions 
            (test_id,question,option1,option2,option3,option4,correct_option)
            VALUES ('$test_id','$question','$opt1','$opt2','$opt3','$opt4','$correct')");
        }
    }

    $response .= "\n\n✅ Test Created Successfully!\n👉 Open: test.php?id=$test_id";
}
// ================== END ==================


// 🔥 SAVE CHAT
mysqli_query($conn,"INSERT INTO ai_messages(conversation_id,message,response)
VALUES('$chat_id','$original_message','$response')");


// 🔥 AUTO TITLE
$res = mysqli_query($conn,"SELECT COUNT(*) as t FROM ai_messages WHERE conversation_id='$chat_id'");
$row = mysqli_fetch_assoc($res);

if($row['t']==1){
    $title = substr($original_message,0,30);
    mysqli_query($conn,"UPDATE ai_conversations SET title='$title' WHERE id='$chat_id'");
}


// 🔥 OUTPUT
echo $response;
?>