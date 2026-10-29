<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

if(!isset($_GET["id"])){
    header("Location: timeline.php");
    exit();
}

$id = (int)$_GET["id"];

$stmt = $conn->prepare("SELECT * FROM timeline WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==0){
    header("Location: timeline.php");
    exit();
}

$row = $result->fetch_assoc();

$error="";

if(isset($_POST["save"])){

    $year = trim($_POST["year"]);
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);

    if($year=="" || $title=="" || $description==""){

        $error="Veuillez remplir tous les champs.";

    }else{

        $update = $conn->prepare("
        UPDATE timeline
        SET year=?, title=?, description=?
        WHERE id=?
        ");

        $update->bind_param(
            "sssi",
            $year,
            $title,
            $description,
            $id
        );

        if($update->execute()){

            header("Location: timeline.php");
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

<title>Edit Timeline</title>

<link rel="stylesheet" href="CSS/timeline.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>

<i class="fas fa-pen"></i>

Modifier Timeline

</h1>

<a href="timeline.php" class="back">

<i class="fas fa-arrow-left"></i>

Retour

</a>

</div>

<?php if($error!=""){ ?>

<div class="success" style="background:#dc2626;">

<?= htmlspecialchars($error) ?>

</div>

<?php } ?>

<div class="form-card">

<form method="POST">

<input
type="text"
name="year"
value="<?= htmlspecialchars($row["year"]) ?>"
required>

<input
type="text"
name="title"
value="<?= htmlspecialchars($row["title"]) ?>"
required>

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