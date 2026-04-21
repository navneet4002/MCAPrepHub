<?php 
include("includes/header.php"); 
include("includes/db.php");

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

$user_id = $_SESSION['user_id'] ?? 1;
$chat_id = $_GET['chat_id'] ?? 0;
?>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body {
    background: radial-gradient(circle at top, #1b2a41, #0b0b0b);
}
.glass {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,0.1);
}
.dot{
height:6px;width:6px;margin:0 2px;background:#ccc;border-radius:50%;
display:inline-block;animation:bounce 1.4s infinite;
}
.dot:nth-child(2){animation-delay:0.2s;}
.dot:nth-child(3){animation-delay:0.4s;}
@keyframes bounce{
0%,80%,100%{transform:scale(0);}
40%{transform:scale(1);}
}
</style>

<div class="flex h-screen text-gray-200 overflow-hidden">

<!-- SIDEBAR -->
<div class="w-64 bg-black/60 border-r border-white/10 p-4 flex flex-col">

<a href="ai/new_chat.php" class="mb-4 px-4 py-2 bg-white/10 rounded-lg text-center hover:bg-white/20">
➕ New Chat
</a>

<input type="text" id="searchChat" placeholder="Search chats..."
class="mb-3 px-3 py-2 rounded-lg bg-white/10 text-sm outline-none">

<div class="flex-1 overflow-y-auto space-y-2">

<?php
$res = mysqli_query($conn,"SELECT * FROM ai_conversations WHERE user_id='$user_id' ORDER BY id DESC");
while($row=mysqli_fetch_assoc($res)){
?>
<a href="?chat_id=<?php echo $row['id']; ?>" 
class="chat-item block px-3 py-2 rounded-lg bg-white/5 hover:bg-white/10 text-sm truncate">
<?php echo htmlspecialchars($row['title']); ?>
</a>
<?php } ?>

</div>

</div>

<!-- MAIN -->
<div class="flex-1 flex flex-col items-center justify-between">

<!-- CHAT -->
<div id="chat" class="w-full max-w-4xl flex-1 overflow-y-auto p-6 space-y-4">

<?php
if($chat_id){
$res = mysqli_query($conn,"SELECT * FROM ai_messages WHERE conversation_id='$chat_id' ORDER BY id ASC");
while($row=mysqli_fetch_assoc($res)){
?>

<div class="text-right">
<div class="inline-block bg-white/10 px-4 py-2 rounded-xl">
<?php echo htmlspecialchars($row['message']); ?>
</div>
</div>

<div class="text-left">
<div class="inline-block glass px-4 py-3 rounded-xl leading-relaxed text-sm">
<?php echo nl2br(htmlspecialchars($row['response'])); ?>
</div>
</div>

<?php } } else { ?>

<div class="text-center text-gray-400 mt-24">
<h1 class="text-3xl">Ask anything ✨</h1>
<p class="text-sm">Notes • Questions • Study Plans</p>
</div>

<?php } ?>

</div>

<!-- MODES -->
<div class="flex gap-2 mb-2">
<button onclick="setMode('notes')" class="glass px-3 py-1 text-sm">📄 Notes</button>
<button onclick="setMode('mcq')" class="glass px-3 py-1 text-sm">❓ MCQ</button>
<button onclick="setMode('plan')" class="glass px-3 py-1 text-sm">📅 Plan</button>
</div>

<!-- INPUT -->
<div class="w-full flex justify-center pb-6">
<div class="glass flex items-center rounded-2xl px-4 py-3 shadow-xl w-full max-w-xl">

<input id="msg" class="flex-1 bg-transparent outline-none text-white" placeholder="Message AI...">

<button onclick="sendMsg()" class="ml-3 px-3 py-2 bg-white/10 rounded-lg">
➤
</button>

</div>
</div>

</div>
</div>

<script>

let currentMode = "";

// MODE
function setMode(mode){
    currentMode = mode;
}

// FORMAT
function formatResponse(text){
    return text
        .replace(/\*\*(.*?)\*\*/g, "<b>$1</b>")
        .replace(/\n/g, "<br>");
}

// SEND MESSAGE
function sendMsg(){

    let input = document.getElementById("msg");
    let msg = input.value.trim();

    if(msg === "") return;

    let chat_id = "<?php echo $chat_id;?>";
    let chat = document.getElementById("chat");

    // USER MESSAGE
    chat.innerHTML += `
    <div class="text-right">
        <div class="bg-white/10 px-4 py-2 rounded-xl inline-block">${msg}</div>
    </div>`;

    input.value = "";

    // LOADING
    let loading = document.createElement("div");
    loading.innerHTML = `
    <div class="text-left">
        <div class="glass px-4 py-3 rounded-xl">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>`;
    chat.appendChild(loading);

    // API CALL
    fetch("ai/chatbot.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"message="+encodeURIComponent(msg)+"&chat_id="+chat_id+"&mode="+currentMode
    })
    .then(res => res.text())
    .then(data => {

        let newMsg = document.createElement("div");
        newMsg.className = "text-left";

        let responseHTML = formatResponse(data || "No response");

        newMsg.innerHTML = `
        <div class="glass px-4 py-3 rounded-xl leading-relaxed text-sm">
            ${responseHTML}
        </div>`;

        loading.replaceWith(newMsg);

        chat.scrollTop = chat.scrollHeight;
    })
    .catch(() => {
        loading.innerHTML = "Error loading response";
    });
}

// ENTER FIX
document.getElementById("msg").addEventListener("keydown",function(e){
    if(e.key==="Enter" && !e.shiftKey){
        e.preventDefault();
        sendMsg();
    }
});
</script>