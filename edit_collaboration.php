<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

if(!isset($_GET["id"])){
    header("Location: collaborations.php");
    exit();
}

$id = (int)$_GET["id"];

$stmt = $conn->prepare("SELECT * FROM collaborations WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==0){
    header("Location: collaborations.php");
    exit();
}

$row = $result->fetch_assoc();

$error="";

if(isset($_POST["save"])){

    $brand_name = trim($_POST["brand_name"]);
    $website = trim($_POST["website"]);

    $logo = $row["logo"];

    if(!empty($_FILES["logo"]["name"])){

        $extension = strtolower(pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION));

        $allowed = ["jpg","jpeg","png","gif","webp"];

        if(!in_array($extension,$allowed)){

            $error="Format d'image non autorisé.";

        }else{

            $newLogo = time()."_".basename($_FILES["logo"]["name"]);

            if(move_uploaded_file($_FILES["logo"]["tmp_name"],"imgs/brands/".$newLogo)){

                if(file_exists("imgs/brands/".$logo)){
                    unlink("imgs/brands/".$logo);
                }

                $logo = $newLogo;

            }else{

                $error="Impossible d'envoyer l'image.";

            }

        }

    }

    if(empty($error)){

        $update = $conn->prepare("
        UPDATE collaborations
        SET brand_name=?,logo=?,website=?
        WHERE id=?
        ");

        $update->bind_param(
            "sssi",
            $brand_name,
            $logo,
            $website,
            $id
        );

        if($update->execute()){

            header("Location: collaborations.php");

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

<meta name="viewport" content="width=device-width,initial-scale=1">

<title>Edit Collaboration</title>

<link rel="stylesheet" href="CSS/collaborations.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>

<i class="fas fa-pen"></i>

Modifier Collaboration

</h1>

<a href="collaborations.php" class="back">

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

<form method="POST" enctype="multipart/form-data">

<label>Nom de la marque</label>

<input
type="text"
name="brand_name"
value="<?= htmlspecialchars($row["brand_name"]) ?>"
required>

<label>Logo actuel</label>

<img
src="imgs/brands/<?= htmlspecialchars($row["logo"]) ?>"
class="logo">

<br><br>

<label>Nouveau Logo (optionnel)</label>

<input
type="file"
name="logo"
accept="image/*">

<label>Website</label>

<input
type="url"
name="website"
value="<?= htmlspecialchars($row["website"]) ?>">

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