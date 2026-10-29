<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

$message="";

if(isset($_POST["add"])){

    $year=trim($_POST["year"]);
    $title=trim($_POST["title"]);
    $description=trim($_POST["description"]);

    if($year!="" && $title!="" && $description!=""){

        $stmt=$conn->prepare("
        INSERT INTO timeline(year,title,description)
        VALUES(?,?,?)
        ");

        $stmt->bind_param(
            "sss",
            $year,
            $title,
            $description
        );

        if($stmt->execute()){

            $message="Étape ajoutée avec succès.";

        }else{

            $message="Erreur lors de l'ajout.";

        }

    }else{

        $message="Veuillez remplir tous les champs.";

    }
    if(isset($_GET["success"])){

    if($_GET["success"]=="deleted"){

        $message="Étape supprimée avec succès.";

    }

}

if(isset($_GET["error"])){

    if($_GET["error"]=="delete"){

        $message="Erreur lors de la suppression.";

    }

}

}

$result=$conn->query("
SELECT *
FROM timeline
ORDER BY year ASC
");
?>

<!DOCTYPE html>

<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Timeline</title>

<link rel="stylesheet" href="CSS/timeline.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>

<i class="fas fa-road"></i>

Timeline

</h1>

<a href="admin.php" class="back">

<i class="fas fa-arrow-left"></i>

Dashboard

</a>

</div>

<?php if($message!=""){ ?>

<div class="success">

<?= htmlspecialchars($message) ?>

</div>

<?php } ?>

<div class="form-card">

<form method="POST">

<input
type="text"
name="year"
placeholder="2026"
required>

<input
type="text"
name="title"
placeholder="Titre"
required>

<textarea
name="description"
rows="5"
placeholder="Description"
required></textarea>

<button
type="submit"
name="add">

<i class="fas fa-plus"></i>

Ajouter

</button>

</form>

</div>

<div class="table-card">

<table>

<tr>

<th>ID</th>

<th>Année</th>

<th>Titre</th>

<th>Description</th>

<th>Actions</th>

</tr>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td>

<?= $row["id"] ?>

</td>

<td>

<?= htmlspecialchars($row["year"]) ?>

</td>

<td>

<?= htmlspecialchars($row["title"]) ?>

</td>

<td>

<?= nl2br(htmlspecialchars($row["description"])) ?>

</td>

<td class="actions">

<a
href="edit_timeline.php?id=<?= $row["id"] ?>"
class="edit">

<i class="fas fa-pen"></i>

Edit

</a>

<a
href="delete_timeline.php?id=<?= $row["id"] ?>"
class="delete"
onclick="return confirm('Supprimer cette étape ?')">

<i class="fas fa-trash"></i>

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>