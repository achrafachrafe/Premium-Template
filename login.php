<?php
session_start();
include "db.php";

if(isset($_SESSION["admin"])){
    header("Location: admin.php");
    exit();
}

$error = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if(empty($username) || empty($password)){
        $error = "Tous les champs sont obligatoires.";
    }else{

        $stmt = $conn->prepare("SELECT * FROM admins WHERE username=? LIMIT 1");
        $stmt->bind_param("s",$username);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0){

            $admin = $result->fetch_assoc();

            if(password_verify($password,$admin["password"])){

                $_SESSION["admin"] = $admin["username"];
                $_SESSION["admin_id"] = $admin["id"];

                header("Location: admin.php");
                exit();

            }else{

                $error = "Mot de passe incorrect.";

            }

        }else{

            $error = "Utilisateur introuvable.";

        }

        $stmt->close();

    }

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins,sans-serif;
}

body{

display:flex;
justify-content:center;
align-items:center;

height:100vh;

background:linear-gradient(135deg,#0f172a,#1e293b);

}

.login{

width:400px;

background:#111827;

padding:40px;

border-radius:15px;

box-shadow:0 20px 40px rgba(0,0,0,.4);

}

h2{

text-align:center;

margin-bottom:30px;

color:white;

}

input{

width:100%;

padding:14px;

margin-bottom:18px;

border:none;

border-radius:10px;

background:#1f2937;

color:white;

outline:none;

}

button{

width:100%;

padding:14px;

border:none;

border-radius:10px;

background:#2563eb;

color:white;

font-size:16px;

cursor:pointer;

transition:.3s;

}

button:hover{

background:#1d4ed8;

}

.error{

background:#dc2626;

padding:12px;

border-radius:8px;

margin-bottom:15px;

text-align:center;

color:white;

}

.forgot{
    margin-top:15px;
    text-align:center;
}

.forgot a{
    color:#6C63FF;
    text-decoration:none;
}

.forgot a:hover{
    text-decoration:underline;
}
a{
    color:#6C63FF;
    text-decoration:none;
}
</style>

</head>

<body>

<div class="login">

<h2>Admin Login</h2>

<?php if($error!=""){ ?>

<div class="error">

<?= htmlspecialchars($error) ?>

</div>

<?php } ?>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<p class="forgot">
<a href="forgot_password.php">
Forgot Password?
</a>
</p>
<br>
<button type="submit">

Connexion

</button>

</form>

</div>

</body>

</html>