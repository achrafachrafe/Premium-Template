<?php
session_start();

if(file_exists("installed.lock")){
    header("Location: login.php");
    exit();
}

include "db.php";

$error = "";

if(isset($_POST["install"])){

    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $recovery_code = trim($_POST["recovery_code"]);

    if(empty($fullname) || empty($username) || empty($password)){

        $error = "Veuillez remplir tous les champs.";

    }else{

        $check = $conn->prepare("SELECT id FROM admins WHERE username=?");
        $check->bind_param("s",$username);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){

            $error = "Nom d'utilisateur déjà utilisé.";

        }else{

            $hash = password_hash($password,PASSWORD_DEFAULT);

                          $stmt = $conn->prepare("
INSERT INTO admins(
fullname,
username,
email,
password,
recovery_code
)
VALUES(?,?,?,?,?)
");

$stmt->bind_param(
"sssss",
$fullname,
$username,
$email,
$hash,
$recovery_code
);

            if($stmt->execute()){

                file_put_contents("installed.lock","Installed");

                 $_SESSION["install_success"] = true;

               header("Location: install_success.php");
               exit();

            }else{

                $error = "Erreur lors de l'installation.";

            }

            $stmt->close();

        }

        $check->close();

    }

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<title>Créer l'administrateur</title>

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
max-width:500px;

background:rgba(255,255,255,.08);
backdrop-filter:blur(15px);

border:1px solid rgba(255,255,255,.15);

border-radius:20px;

padding:40px;

color:#fff;

}

h1{

text-align:center;
margin-bottom:25px;

}

.form-group{

margin-bottom:18px;

}

label{

display:block;
margin-bottom:8px;

}

input{

width:100%;

padding:14px;

border:none;

border-radius:10px;

background:rgba(255,255,255,.08);

color:#fff;

outline:none;

}

button{

width:100%;

padding:15px;

background:#6C63FF;

border:none;

border-radius:10px;

color:#fff;

font-size:17px;

cursor:pointer;

}

.error{

background:#ff4d4d;

padding:12px;

border-radius:10px;

margin-bottom:20px;

}

.info{

display:block;

margin-top:10px;

font-size:13px;

line-height:1.6;

color:#ffd166;

}

.copy-btn{

margin-top:12px;

width:100%;

padding:12px;

border:none;

border-radius:10px;

background:#00D4FF;

color:#fff;

font-weight:600;

cursor:pointer;

transition:.3s;

}

.copy-btn:hover{

background:#0099cc;

}
</style>

</head>

<body>

<div class="card">

<h1>Créer l'administrateur</h1>

<?php if(!empty($error)){ ?>

<div class="error">
<?= htmlspecialchars($error) ?>
</div>

<?php } ?>

<form method="post">

<div class="form-group">

<label>Nom complet</label>

<input
type="text"
name="fullname"
required>

</div>

<div class="form-group">

<label>Nom d'utilisateur</label>

<input
type="text"
name="username"
required>

</div>

<div class="form-group">

<label>Mot de passe</label>

<input
type="password"
name="password"
required>

</div>

<div class="form-group">
<label>Email</label>
<input
type="email"
name="email"
required>
</div>

<div class="form-group">

<label>Recovery Code</label>

<input
type="text"
name="recovery_code"
id="recovery_code"
placeholder="Ex : AB123456"
required>

<small class="info">
⚠️ Conservez ce Recovery Code dans un endroit sûr.
Vous en aurez besoin si vous oubliez votre mot de passe.
</small>

<button
type="button"
class="copy-btn"
onclick="copyRecoveryCode()">

<i class="fas fa-copy"></i>
Copy Recovery Code

</button>

</div>

<button
type="submit"
name="install">

Terminer l'installation

</button>

</form>

</div>

<script>

function copyRecoveryCode(){

const input=document.getElementById("recovery_code");

if(input.value.trim()==""){

alert("Veuillez d'abord saisir un Recovery Code.");

return;

}

navigator.clipboard.writeText(input.value);

alert("✅ Recovery Code copié avec succès !");

}

</script>
</body>
</html>