<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

if(!isset($_GET["id"])){
    header("Location: services.php");
    exit();
}

$id = (int)$_GET["id"];

$stmt = $conn->prepare("SELECT * FROM services WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==0){
    header("Location: services.php");
    exit();
}

$row = $result->fetch_assoc();

$error="";

if(isset($_POST["save"])){

    $icon = trim($_POST["icon"]);
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);

    if(empty($icon) || empty($title) || empty($description)){

        $error="Veuillez remplir tous les champs.";

    }else{

        $update = $conn->prepare("UPDATE services SET icon=?,title=?,description=? WHERE id=?");

        $update->bind_param(
            "sssi",
            $icon,
            $title,
            $description,
            $id
        );

        if($update->execute()){

            header("Location: services.php");
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

<title>Edit Service</title>

<link rel="stylesheet" href="CSS/services.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>

<i class="fas fa-pen"></i>

Modifier Service

</h1>

<a href="services.php" class="back">

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

<label>Icon</label>

<input
type="text"
name="icon"
value="<?= htmlspecialchars($row["icon"]) ?>"
required>

<label>Titre</label>

<input
type="text"
name="title"
value="<?= htmlspecialchars($row["title"]) ?>"
required>

<label>Description</label>

<textarea
name="description"
rows="6"
required><?= htmlspecialchars($row["description"]) ?></textarea>

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