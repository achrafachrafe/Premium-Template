<?php
session_start();

if(empty($_SESSION["install_success"])){
    header("Location: login.php");
    exit();
}

unset($_SESSION["install_success"]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Installation terminée</title>

<style>

body{
display:flex;
justify-content:center;
align-items:center;
height:100vh;
font-family:Poppins,sans-serif;
background:#0f172a;
color:#fff;
}

.card{
max-width:600px;
padding:40px;
border-radius:20px;
background:#1e293b;
text-align:center;
}

a{
display:inline-block;
margin-top:20px;
padding:15px 25px;
background:#6C63FF;
color:#fff;
text-decoration:none;
border-radius:10px;
}

</style>

</head>

<body>

<div class="card">

<h1>🎉 Installation terminée</h1>

<p>
Votre site a été installé avec succès.
</p>

<p>
Pour des raisons de sécurité, supprimez les fichiers :
</p>

<pre>
install.php
installer.php
admin_install.php
</pre>

<a href="login.php">
Aller à la connexion
</a>

</div>

</body>
</html>