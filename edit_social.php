<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

if(!isset($_GET["id"])){
    header("Location: socials.php");
    exit();
}

$id=(int)$_GET["id"];

$stmt=$conn->prepare("SELECT * FROM socials WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result=$stmt->get_result();

if($result->num_rows==0){
    header("Location: socials.php");
    exit();
}

$row=$result->fetch_assoc();

$success="";
$error="";

if(isset($_POST["save"])){

    $platform=trim($_POST["platform"]);
    $icon=trim($_POST["icon"]);
    $url=trim($_POST["url"]);
    $followers=trim($_POST["followers"]);

    if($platform=="" || $icon=="" || $url==""){

        $error="Veuillez remplir tous les champs.";

    }else{

        $update=$conn->prepare("UPDATE socials SET platform=?,icon=?,url=?,followers=? WHERE id=?");

        $update->bind_param(
            "ssssi",
            $platform,
            $icon,
            $url,
            $followers,
            $id
        );

        if($update->execute()){

            header("Location: socials.php");

            exit();

        }else{

            $error="Erreur lors de la modification.";

        }

    }

}
?>

<!DOCTYPE html>

<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Social Media</title>

<link rel="stylesheet" href="CSS/socials.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>

<i class="fas fa-pen"></i>

Modifier Social Media

</h1>

<a href="socials.php" class="back">

<i class="fas fa-arrow-left"></i>

Retour

</a>

</div>

<?php if($error!=""){ ?>

<div class="error">

<?= htmlspecialchars($error) ?>

</div>

<?php } ?>

<div class="form-card">

<form method="POST">

<input
type="text"
name="platform"
value="<?= htmlspecialchars($row["platform"]) ?>"
required>

<input
type="text"
name="icon"
value="<?= htmlspecialchars($row["icon"]) ?>"
required>

<input
type="url"
name="url"
value="<?= htmlspecialchars($row["url"]) ?>"
required>

<input
type="text"
name="followers"
value="<?= htmlspecialchars($row["followers"]) ?>">

<button
type="submit"
name="save">

<i class="fas fa-save"></i>

Enregistrer

</button>

</form>

</div>

</div>

</body>

</html>