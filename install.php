<?php
if(file_exists("installed.lock")){
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Install LinkPro</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins,sans-serif;
}

body{

background:#0f172a;
display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
padding:20px;

}

.card{

width:100%;
max-width:550px;

background:rgba(255,255,255,.08);

backdrop-filter:blur(20px);

border:1px solid rgba(255,255,255,.15);

border-radius:20px;

padding:40px;

color:#fff;

}

h1{

text-align:center;

margin-bottom:30px;

font-size:32px;

}

.form-group{

margin-bottom:20px;

}

label{

display:block;

margin-bottom:8px;

font-weight:600;

}

input{

width:100%;

padding:14px;

border:none;

border-radius:10px;

background:rgba(255,255,255,.1);

color:#fff;

outline:none;

}

input::placeholder{

color:#ccc;

}

button{

width:100%;

padding:15px;

border:none;

border-radius:12px;

background:#6C63FF;

color:#fff;

font-size:17px;

font-weight:bold;

cursor:pointer;

transition:.3s;

}

button:hover{

background:#4F46E5;

}

.step{

text-align:center;

margin-bottom:25px;

color:#bbb;

}

</style>

</head>

<body>

<div class="card">

<h1>🚀 Install LinkPro</h1>

<p class="step">
Étape 1 / Configuration de la base de données
</p>

<form action="installer.php" method="post">

<div class="form-group">

<label>Database Host</label>

<input
type="text"
name="db_host"
value="localhost"
required>

</div>

<div class="form-group">

<label>Database Name</label>

<input
type="text"
name="db_name"
placeholder="linkpro"
required>

</div>

<div class="form-group">

<label>Database Username</label>

<input
type="text"
name="db_user"
value="root"
required>

</div>

<div class="form-group">

<label>Database Password</label>

<input
type="password"
name="db_pass">

</div>

<button type="submit">
Continuer →
</button>

</form>

</div>

</body>
</html>