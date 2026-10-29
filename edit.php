<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location:login.php");
    exit();
}

include "db.php";

if(!isset($_GET["id"])){
    header("Location:admin.php");
    exit();
}

$id = intval($_GET["id"]);

$stmt = $conn->prepare("SELECT * FROM contacts WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows==0){
    header("Location:admin.php");
    exit();
}

$row = $result->fetch_assoc();

if(isset($_POST["update"])){

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if(empty($name) || empty($email) || empty($subject) || empty($message)){
        $error="Tous les champs sont obligatoires.";
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $error="Email invalide.";
    }else{

        $update=$conn->prepare("UPDATE contacts
        SET name=?,email=?,subject=?,message=?
        WHERE id=?");

        $update->bind_param(
        "ssssi",
        $name,
        $email,
        $subject,
        $message,
        $id
        );

        if($update->execute()){

            header("Location:admin.php?update=success");
            exit();

        }else{

            $error="Erreur.";

        }

    }

}
?>

<!DOCTYPE html>

<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Message</title>

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

padding:30px;

}

.container{

width:700px;

background:#111827;

padding:35px;

border-radius:15px;

color:white;

}

h2{

margin-bottom:25px;

text-align:center;

}

input,
textarea{

width:100%;

padding:15px;

margin-bottom:18px;

border:none;

border-radius:10px;

background:#1f2937;

color:white;

outline:none;

}

textarea{

resize:none;

height:180px;

}

button{

width:100%;

padding:15px;

background:#2563eb;

color:white;

border:none;

border-radius:10px;

cursor:pointer;

font-size:16px;

}

button:hover{

background:#1d4ed8;

}

.back{

display:block;

margin-top:20px;

text-align:center;

color:#60a5fa;

text-decoration:none;

}

.error{

background:#dc2626;

padding:12px;

margin-bottom:20px;

border-radius:8px;

text-align:center;

}

</style>

</head>

<body>

<div class="container">

<h2>Edit Message</h2>

<?php
if(isset($error)){
?>

<div class="error">

<?= htmlspecialchars($error) ?>

</div>

<?php
}
?>

<form method="POST">

<input
type="text"
name="name"
value="<?= htmlspecialchars($row["name"]) ?>"
required>

<input
type="email"
name="email"
value="<?= htmlspecialchars($row["email"]) ?>"
required>

<input
type="text"
name="subject"
value="<?= htmlspecialchars($row["subject"]) ?>"
required>

<textarea
name="message"
required><?= htmlspecialchars($row["message"]) ?></textarea>

<button
type="submit"
name="update">

Update Message

</button>

</form>

<a
class="back"
href="admin.php">

← Retour au Dashboard

</a>

</div>

</body>

</html>