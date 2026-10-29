<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

$success = "";
$error = "";

if(isset($_GET["success"])){

    if($_GET["success"]=="deleted"){
        $success="Service supprimé avec succès.";
    }

}

if(isset($_GET["error"])){

    if($_GET["error"]=="delete"){
        $error="Erreur lors de la suppression.";
    }

}

if(isset($_POST["add"])){

    $icon = trim($_POST["icon"]);
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);

    if(empty($icon) || empty($title) || empty($description)){

        $error = "Veuillez remplir tous les champs.";

    }else{

        $stmt = $conn->prepare("INSERT INTO services(icon,title,description) VALUES(?,?,?)");

        $stmt->bind_param(
            "sss",
            $icon,
            $title,
            $description
        );

        if($stmt->execute()){

            $success = "Service ajouté avec succès.";

        }else{

            $error = "Erreur lors de l'ajout.";

        }
        if(isset($_GET["success"])){

    if($_GET["success"]=="deleted"){

        $success="Service supprimé avec succès.";

    }

}

if(isset($_GET["error"])){

    if($_GET["error"]=="delete"){

        $error="Erreur lors de la suppression.";

    }

}

        $stmt->close();

    }

}

$result = $conn->query("SELECT * FROM services ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Services Manager</title>

<link rel="stylesheet" href="CSS/services.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>

<i class="fas fa-briefcase"></i>

Services

</h1>

<a href="admin.php" class="back">

<i class="fas fa-arrow-left"></i>

Dashboard

</a>

</div>

<?php if($success!=""){ ?>

<div class="success">

<?= htmlspecialchars($success) ?>

</div>

<?php } ?>

<?php if($error!=""){ ?>

<div class="error">

<?= htmlspecialchars($error) ?>

</div>

<?php } ?>

<!-- ADD SERVICE -->

<div class="form-card">

<h2>

Ajouter un Service

</h2>

<form method="POST">

<label>Icon (Font Awesome)</label>

<input
type="text"
name="icon"
placeholder="fas fa-video"
required>

<label>Titre</label>

<input
type="text"
name="title"
placeholder="Création de contenu"
required>

<label>Description</label>

<textarea
name="description"
rows="5"
placeholder="Description du service..."
required></textarea>

<button
type="submit"
name="add">

<i class="fas fa-plus"></i>

Ajouter

</button>

</form>

</div>

<!-- TABLE -->

<div class="table-card">

<h2>

Liste des Services

</h2>

<table>

<tr>

<th>ID</th>

<th>Icon</th>

<th>Title</th>

<th>Description</th>

<th>Actions</th>

</tr>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td>

<?= $row["id"] ?>

</td>

<td>

<i class="<?= htmlspecialchars($row["icon"]) ?>"></i>

</td>

<td>

<?= htmlspecialchars($row["title"]) ?>

</td>

<td>

<?= nl2br(htmlspecialchars($row["description"])) ?>

</td>

<td>

<a
href="edit_service.php?id=<?= $row["id"] ?>"
class="edit">

<i class="fas fa-pen"></i>

Edit

</a>

<a
href="delete_service.php?id=<?= $row["id"] ?>"
class="delete"
onclick="return confirm('Supprimer ce service ?')">

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