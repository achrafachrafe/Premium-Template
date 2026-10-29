<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

$success = "";
$error = "";
/*==============================
UPLOAD IMAGE - DEBUG
==============================*/

if(isset($_POST["upload"])){

    $title = trim($_POST["title"]);

    // Vérifier le fichier
    if(!isset($_FILES["image"])){

        $error = "Aucune image reçue.";

    }elseif($_FILES["image"]["error"] != 0){

        $error = "Erreur upload : " . $_FILES["image"]["error"];

    }else{

        $allowed = ["jpg", "jpeg", "png", "webp"];

        $ext = strtolower(
            pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION)
        );

        // Vérifier extension
        if(!in_array($ext, $allowed)){

            $error = "Formats autorisés : JPG, JPEG, PNG, WEBP.";

        }else{

            // Dossier images
            $folder = __DIR__ . "/imgs/";

            if(!is_dir($folder)){

                if(!mkdir($folder, 0777, true)){

                    $error = "Impossible de créer le dossier imgs.";

                }

            }

            // Si pas d'erreur
            if($error == ""){

                $filename = time() . "_" . rand(1000,9999) . "." . $ext;

                $destination = $folder . $filename;

                // Déplacer l'image
                if(move_uploaded_file(
                    $_FILES["image"]["tmp_name"],
                    $destination
                )){

                    // Ajouter dans la base de données
                    $stmt = $conn->prepare(
                        "INSERT INTO gallery (image, title) VALUES (?, ?)"
                    );

                    if(!$stmt){

                        $error = "Erreur SQL prepare : " . $conn->error;

                    }else{

                        $stmt->bind_param(
                            "ss",
                            $filename,
                            $title
                        );

                        if($stmt->execute()){

                           header("Location: gallery.php?success=1");
                           exit();

                        }else{

                            $error = "Erreur SQL : " . $stmt->error;

                        }

                        $stmt->close();

                    }

                }else{

                    $error = "Impossible d'enregistrer l'image.";

                }

            }

        }

    }

}
/*==============================
DELETE IMAGE
==============================*/

if(isset($_GET["delete"])){

    $id = (int)$_GET["delete"];

    $stmt = $conn->prepare("SELECT image FROM gallery WHERE id=?");

    $stmt->bind_param("i",$id);

    $stmt->execute();

    $img = $stmt->get_result()->fetch_assoc();

    if($img){

        $path = __DIR__ . "/imgs/" . $img["image"];

        if(file_exists($path)){
            unlink($path);
        }

        $delete = $conn->prepare("DELETE FROM gallery WHERE id=?");

        $delete->bind_param("i",$id);

        $delete->execute();

        $delete->close();

        $success = "Image supprimée.";

    }

    $stmt->close();

}

/*==============================
GET IMAGES
==============================*/
if(isset($_GET["success"]) && $_GET["success"] == 1){
    $success = "Image ajoutée avec succès.";
}
$images = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gallery Manager</title>
<link rel="stylesheet" href="CSS/gallery.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>
<div class="container">

<div class="header">

<h1>

<i class="fa-solid fa-images"></i>

Gallery Manager

</h1>

<a href="admin.php" class="back">

<i class="fa-solid fa-arrow-left"></i>

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

<div class="upload-card">

<h2>Ajouter une image</h2>

<form method="POST" enctype="multipart/form-data">

    <input
        type="text"
        name="title"
        placeholder="Titre de l'image"
        required>

    <input
        type="file"
        name="image"
        id="image"
        accept=".jpg,.jpeg,.png,.webp"
        required>

    <button type="submit" name="upload">
        Upload
    </button>

</form>

</div>

<h2 class="gallery-title">

Toutes les images

</h2>

<div class="gallery-grid">

<?php while($row = $images->fetch_assoc()){ ?>

<div class="card">

<img
src="imgs/<?= htmlspecialchars($row["image"]) ?>"
alt="<?= htmlspecialchars($row["title"]) ?>">

<h3>

<?= htmlspecialchars($row["title"]) ?>

</h3>

<p>

<?= htmlspecialchars($row["created_at"]) ?>

</p>

<div class="actions">

<a
href="edit_gallery.php?id=<?= $row["id"] ?>"
class="edit">

<i class="fa-solid fa-pen"></i>

Modifier

</a>

<a
href="gallery.php?delete=<?= $row["id"] ?>"
class="delete"
onclick="return confirm('Supprimer cette image ?')">

<i class="fa-solid fa-trash"></i>

Supprimer

</a>

</div>

</div>

<?php } ?>

</div>

</div>
<script src="Javascript/gallerye.js"></script>
</body>

</html>