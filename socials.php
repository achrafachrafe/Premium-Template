<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

$success = "";
$error = "";

if(isset($_POST["add"])){

    $platform = trim($_POST["platform"]);
    $icon = trim($_POST["icon"]);
    $url = trim($_POST["url"]);
    $followers = trim($_POST["followers"]);

    if($platform=="" || $icon=="" || $url==""){

        $error = "Veuillez remplir tous les champs.";

    }else{

        $stmt = $conn->prepare("INSERT INTO socials(platform,icon,url,followers) VALUES(?,?,?,?)");

        $stmt->bind_param(
            "ssss",
            $platform,
            $icon,
            $url,
            $followers
        );

        if($stmt->execute()){

            $success = "Social Media ajouté avec succès.";

        }else{

            $error = "Erreur lors de l'ajout.";

        }
        if(isset($_GET["success"])){

    if($_GET["success"]=="deleted"){

        $success = "Social Media supprimé avec succès.";

    }

}

if(isset($_GET["error"])){

    if($_GET["error"]=="delete"){

        $error = "Erreur lors de la suppression.";

    }

}

    }

}

$result = $conn->query("SELECT * FROM socials ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Social Media Manager</title>

<link rel="stylesheet" href="CSS/socials.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>

<i class="fas fa-share-alt"></i>

Social Media

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

<div class="form-card">

<h2>

Ajouter un réseau social

</h2>

<form method="POST">

<input
type="text"
name="platform"
placeholder="Platform (Instagram)"
required>

<input
type="text"
name="icon"
placeholder="Icon (fab fa-instagram)"
required>

<input
type="url"
name="url"
placeholder="https://instagram.com/username"
required>

<input
type="text"
name="followers"
placeholder="500K Followers">

<button
type="submit"
name="add">

<i class="fas fa-plus"></i>

Ajouter

</button>

</form>

</div>

<div class="table-card">

<h2>

Liste des réseaux sociaux

</h2>

<table>

<tr>

<th>ID</th>

<th>Icon</th>

<th>Platform</th>

<th>Followers</th>

<th>URL</th>

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

<?= htmlspecialchars($row["platform"]) ?>

</td>

<td>

<?= htmlspecialchars($row["followers"]) ?>

</td>

<td>

<a
href="<?= htmlspecialchars($row["url"]) ?>"
target="_blank">

Voir

</a>

</td>

<td>

<a
href="edit_social.php?id=<?= $row["id"] ?>"
class="edit">

Modifier

</a>

<a
href="delete_social.php?id=<?= $row["id"] ?>"
class="delete"
onclick="return confirm('Supprimer ce réseau social ?')">

Supprimer

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>