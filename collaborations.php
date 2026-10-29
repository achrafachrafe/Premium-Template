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
        $success="Collaboration supprimée avec succès.";
    }

}

if(isset($_GET["error"])){

    if($_GET["error"]=="delete"){
        $error="Erreur lors de la suppression.";
    }

}

if(isset($_POST["add"])){

    $brand_name = trim($_POST["brand_name"]);
    $website = trim($_POST["website"]);

    if(empty($brand_name) || empty($_FILES["logo"]["name"])){

        $error="Veuillez remplir tous les champs.";

    }else{

        $extension = strtolower(pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION));

        $allowed = ["jpg","jpeg","png","webp","gif"];

        if(!in_array($extension,$allowed)){

            $error="Format d'image non autorisé.";

        }else{

            $logo = time()."_".basename($_FILES["logo"]["name"]);

            if(move_uploaded_file(
                $_FILES["logo"]["tmp_name"],
                "imgs/brands/".$logo
            )){

                $stmt = $conn->prepare("
                INSERT INTO collaborations
                (brand_name,logo,website)
                VALUES(?,?,?)
                ");

                $stmt->bind_param(
                    "sss",
                    $brand_name,
                    $logo,
                    $website
                );

                if($stmt->execute()){

                    $success="Collaboration ajoutée avec succès.";

                }else{

                    $error="Erreur SQL.";

                    unlink("imgs/brands/".$logo);

                }
                if(isset($_GET["success"])){

    if($_GET["success"]=="deleted"){

        $success="Collaboration supprimée avec succès.";

    }

}

if(isset($_GET["error"])){

    if($_GET["error"]=="delete"){

        $error="Erreur lors de la suppression.";

    }

}

                $stmt->close();

            }else{

                $error="Impossible d'envoyer l'image.";

            }

        }

    }

}

$result = $conn->query("
SELECT *
FROM collaborations
ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Collaborations / Présence professionnelle</title>

<link rel="stylesheet" href="CSS/collaborations.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>

<i class="fas fa-handshake"></i>

Collaborations / Présence professionnelle

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

<!-- ADD BRAND -->

<div class="form-card">

<h2>

Ajouter une Collaborations / Présence professionnelle

</h2>

<form method="POST" enctype="multipart/form-data">

<label>Nom de la marque</label>

<input
type="text"
name="brand_name"
placeholder="Apple"
required>

<label>Logo</label>

<input
type="file"
name="logo"
accept="image/*"
required>

<label>Website</label>

<input
type="url"
name="website"
placeholder="https://apple.com">

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

Liste des Collaborations / Présence professionnelle

</h2>

<table>

<tr>

<th>ID</th>

<th>Logo</th>

<th>Marque</th>

<th>Website</th>

<th>Actions</th>

</tr>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td>

<?= $row["id"] ?>

</td>

<td>

<img
src="imgs/brands/<?= htmlspecialchars($row["logo"]) ?>"
class="logo">

</td>

<td>

<?= htmlspecialchars($row["brand_name"]) ?>

</td>

<td>

<?php if(!empty($row["website"])){ ?>

<a
href="<?= htmlspecialchars($row["website"]) ?>"
target="_blank">

Visiter

</a>

<?php }else{ ?>

—

<?php } ?>

</td>

<td>

<a
href="edit_collaboration.php?id=<?= $row["id"] ?>"
class="edit">

<i class="fas fa-pen"></i>

Edit

</a>

<a
href="delete_collaboration.php?id=<?= $row["id"] ?>"
class="delete"
onclick="return confirm('Supprimer cette collaboration ?')">

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