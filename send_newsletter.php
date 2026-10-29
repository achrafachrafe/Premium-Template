<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location:login.php");
    exit();
}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Send Newsletter</title>

<style>

*{

margin:0;

padding:0;

box-sizing:border-box;

font-family:Poppins,sans-serif;

}

body{

background:#0f172a;

color:#fff;

display:flex;

justify-content:center;

align-items:center;

min-height:100vh;

}

.box{

width:700px;

background:#111827;

padding:40px;

border-radius:20px;

box-shadow:0 15px 40px rgba(0,0,0,.35);

}

h2{

margin-bottom:25px;

}

input,textarea{

width:100%;

padding:15px;

border:none;

outline:none;

border-radius:10px;

margin-bottom:20px;

font-size:16px;

}

textarea{

height:220px;

resize:none;

}

button{

padding:15px 35px;

border:none;

background:#2563eb;

color:#fff;

font-size:17px;

border-radius:10px;

cursor:pointer;

}

button:hover{

background:#1d4ed8;

}

.progress{

width:100%;

height:22px;

background:#1f2937;

border-radius:30px;

overflow:hidden;

margin-top:30px;

display:none;

}

.progress-bar{

height:100%;

width:0%;

background:#22c55e;

transition:.4s;

}

#status{

margin-top:20px;

font-weight:bold;

font-size:18px;

}
button:disabled{

background:#64748b;

cursor:not-allowed;

opacity:.7;

}

.stats{

margin-top:20px;

display:flex;

gap:20px;

font-size:18px;

font-weight:bold;

flex-wrap:wrap;

}

.good{

color:#22c55e;

}

.bad{

color:#ef4444;

}
.back{
margin-left: -200px;

margin-bottom: 600px;

gap:8px;

padding:14px 22px;

border-radius:12px;

background:#2563eb;

color:#fff;

text-decoration:none;

font-weight:600;

transition:.3s;

}

.back:hover{

transform:translateY(-3px);

background:#1d4ed8;

}
</style>

</head>

<body>

<a href="newsletter_admin.php" class="back">

← Back to newsletter

</a>

<div class="box">

<h2>📧 Send Newsletter</h2>

<form id="newsletterForm">

<input
type="text"
name="subject"
placeholder="Subject"
required>

<textarea
name="message"
placeholder="Message"
required></textarea>

<button
type="submit"
id="sendBtn">

📧 Send Newsletter

</button>

</form>

<div class="progress">

<div
class="progress-bar"
id="bar">

</div>
<div class="stats">

<div class="good">

✅ Sent:
<span id="sentCount">

0

</span>

</div>

<div class="bad">

❌ Failed:
<span id="failedCount">

0

</span>

</div>

</div>

</div>

<p id="status"></p>

</div>

<script>

const form=document.getElementById("newsletterForm");

const progress=document.querySelector(".progress");

const bar=document.getElementById("bar");

const status=document.getElementById("status");

const btn=document.getElementById("sendBtn");

const sent=document.getElementById("sentCount");

const failed=document.getElementById("failedCount");

let sentTotal=0;

let failedTotal=0;

form.addEventListener("submit",function(e){

e.preventDefault();

btn.disabled=true;

btn.innerHTML="Sending...";

progress.style.display="block";

bar.style.width="0%";

status.innerHTML="Preparing...";

sent.innerHTML="0";

failed.innerHTML="0";

sentTotal=0;

failedTotal=0;

sendBatch(0);

});

function sendBatch(offset){

let fd=new FormData(form);

fd.append("offset",offset);

fetch("send_newsletter_process.php",{

method:"POST",

body:fd

})

.then(r=>r.json())

.then(data=>{

if(!data.success){

btn.disabled=false;

btn.innerHTML="📧 Send Newsletter";

status.innerHTML="❌ "+data.message;

return;

}

sentTotal+=data.sent;

failedTotal+=data.failed;

sent.innerHTML=sentTotal;

failed.innerHTML=failedTotal;

let percent=Math.round(

(Math.min(data.offset,data.total)/data.total)*100

);

bar.style.width=percent+"%";

status.innerHTML=

"Sending "+

Math.min(data.offset,data.total)+

" / "+

data.total;

if(data.finished){

bar.style.width="100%";

status.innerHTML=

"✅ Newsletter sent successfully.";

btn.disabled=false;

btn.innerHTML="📧 Send Newsletter";

return;

}

setTimeout(function(){

sendBatch(data.offset);

},2000);

})

.catch(()=>{

btn.disabled=false;

btn.innerHTML="📧 Send Newsletter";

status.innerHTML="Connection error.";

});

}

</script>

</body>

</html>