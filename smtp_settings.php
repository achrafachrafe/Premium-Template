<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

$success="";
$error="";

$result=$conn->query("SELECT * FROM smtp_settings LIMIT 1");
$row=$result->fetch_assoc();

if(isset($_POST["save"])){

    $host=trim($_POST["host"]);
    $port=intval($_POST["port"]);
    $encryption=trim($_POST["encryption"]);
    $username=trim($_POST["username"]);
    $password=trim($_POST["password"]);
    $from_email=trim($_POST["from_email"]);
    $from_name=trim($_POST["from_name"]);

    $stmt=$conn->prepare("
    UPDATE smtp_settings SET

    host=?,
    port=?,
    encryption=?,
    username=?,
    password=?,
    from_email=?,
    from_name=?

    WHERE id=1
    ");

    $stmt->bind_param(

    "sisssss",

    $host,
    $port,
    $encryption,
    $username,
    $password,
    $from_email,
    $from_name

    );

    if($stmt->execute()){

        $success="SMTP settings saved successfully.";

        $result=$conn->query("SELECT * FROM smtp_settings LIMIT 1");
        $row=$result->fetch_assoc();

    }else{

        $error="Database error.";

    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMTP Settings</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{

background:#0f172a;

color:#fff;

min-height:100vh;

padding:40px;

}

.container{

max-width:750px;

margin:auto;

background:#111827;

padding:35px;

border-radius:20px;

box-shadow:0 20px 45px rgba(0,0,0,.35);

}

h1{

text-align:center;

margin-bottom:30px;

font-size:30px;

}

h1 i{

color:#3b82f6;

margin-right:10px;

}

.form-group{

margin-bottom:22px;

}

label{

display:block;

margin-bottom:8px;

font-weight:600;

font-size:15px;

}

input,
select{

width:100%;

padding:14px;

border:none;

outline:none;

border-radius:10px;

background:#1f2937;

color:#fff;

font-size:15px;

transition:.3s;

}

input:focus,
select:focus{

box-shadow:0 0 0 3px rgba(59,130,246,.35);

}

.password-box{

position:relative;

}

.password-box input{

padding-right:55px;

}

.password-box button{

position:absolute;

right:10px;

top:50%;

transform:translateY(-50%);

background:none;

border:none;

color:#fff;

font-size:18px;

cursor:pointer;

}

.buttons{

display:flex;

gap:15px;

margin-top:30px;

flex-wrap:wrap;

}

.save{

flex:1;

padding:15px;

border:none;

border-radius:10px;

background:#2563eb;

color:#fff;

font-size:16px;

font-weight:bold;

cursor:pointer;

transition:.3s;

}

.save:hover{

background:#1d4ed8;

transform:translateY(-2px);

}

.back{

flex:1;

display:flex;

justify-content:center;

align-items:center;

padding:15px;

border-radius:10px;

background:#374151;

color:#fff;

text-decoration:none;

font-weight:bold;

transition:.3s;

}

.back:hover{

background:#4b5563;

}

.success{

background:#16a34a;

padding:15px;

border-radius:10px;

margin-bottom:20px;

text-align:center;

}

.error{

background:#dc2626;

padding:15px;

border-radius:10px;

margin-bottom:20px;

text-align:center;

}

@media(max-width:768px){

body{

padding:20px;

}

.container{

padding:25px;

}

.buttons{

flex-direction:column;

}

.save,
.back{

width:100%;

}

}
/*==============================
TOAST
==============================*/

.toast{

position:fixed;

right:25px;

bottom:25px;

background:#2563eb;

color:#fff;

padding:15px 22px;

border-radius:10px;

font-weight:600;

opacity:0;

transform:translateY(30px);

transition:.35s;

z-index:9999;

box-shadow:0 10px 30px rgba(0,0,0,.35);

}

.toast.show{

opacity:1;

transform:translateY(0);

}
    </style>

</head>

<body>

<div class="container">

<h1>

<i class="fas fa-envelope"></i>

SMTP Settings

</h1>

<?php if($success!=""){ ?>

<div class="success">

<?= $success ?>

</div>

<?php } ?>

<?php if(isset($_GET["error"])){ ?>

<div class="error">

Please configure SMTP before sending newsletters.

</div>

<?php } ?>

<form method="post">

<div class="form-group">

<label>

SMTP Host

</label>

<input

type="text"

name="host"

required

value="<?= htmlspecialchars($row["host"]) ?>">

</div>

<div class="form-group">

<label>

SMTP Port

</label>

<input

type="number"

name="port"

required

value="<?= htmlspecialchars($row["port"]) ?>">

</div>

<div class="form-group">

<label>

Encryption

</label>

<select name="encryption">

<option

value="tls"

<?= $row["encryption"]=="tls"?"selected":""; ?>>

TLS

</option>

<option

value="ssl"

<?= $row["encryption"]=="ssl"?"selected":""; ?>>

SSL

</option>

</select>

</div>

<div class="form-group">

<label>

SMTP Username

</label>

<div class="password-box">

<input
id="username"
type="text"
name="username"
value="<?= htmlspecialchars($row["username"]) ?>">

<button
type="button"
onclick="copyInput('username')">

<i class="fas fa-copy"></i>

</button>

</div>

</div>

<div class="form-group">

<label>

SMTP Password

</label>

<div class="password-box">

<input

type="password"

id="password"

name="password"

required

value="<?= htmlspecialchars($row["password"]) ?>">

<button

type="button"

id="togglePassword">

<i class="fas fa-eye"></i>

</button>

</div>

</div>

<div class="form-group">

<label>

From Email

</label>

<input

type="email"

name="from_email"

required

value="<?= htmlspecialchars($row["from_email"]) ?>">

</div>

<div class="form-group">

<label>

From Name

</label>

<input

type="text"

name="from_name"

required

value="<?= htmlspecialchars($row["from_name"]) ?>">

</div>

<div class="buttons">

<button

type="submit"

name="save"

class="save">

<i class="fas fa-save"></i>

Save Settings

</button>

<a

href="newsletter_admin.php"

class="back">

<i class="fas fa-arrow-left"></i>

Back

</a>

</div>

</form>

</div>
<script>

//==============================
// Show / Hide Password
//==============================

const togglePassword =
document.getElementById("togglePassword");

const password =
document.getElementById("password");

togglePassword.addEventListener("click",()=>{

if(password.type==="password"){

password.type="text";

togglePassword.innerHTML=
'<i class="fas fa-eye-slash"></i>';

}else{

password.type="password";

togglePassword.innerHTML=
'<i class="fas fa-eye"></i>';

}

});

//==============================
// Copy Text
//==============================

function copyInput(id){

const input=document.getElementById(id);

navigator.clipboard.writeText(input.value);

showToast("Copied to clipboard");

}

//==============================
// Toast
//==============================

function showToast(message){

const toast=document.createElement("div");

toast.className="toast";

toast.innerHTML=message;

document.body.appendChild(toast);

setTimeout(()=>{

toast.classList.add("show");

},100);

setTimeout(()=>{

toast.classList.remove("show");

setTimeout(()=>{

toast.remove();

},300);

},2500);

}

</script>
</body>