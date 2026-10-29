<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

if(!isset($_GET["id"])){
    header("Location: gallery.php");
    exit();
}

$id = (int)$_GET["id"];

$stmt = $conn->prepare("SELECT * FROM gallery WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows==0){
    header("Location: gallery.php");
    exit();
}

$image = $result->fetch_assoc();

$success="";
$error="";

if(isset($_POST["save"])){

    $title = trim($_POST["title"]);

    $filename = $image["image"];

    if(isset($_FILES["image"]) && $_FILES["image"]["error"]==0){

        $allowed=["jpg","jpeg","png","webp"];

        $ext=strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));

        if(in_array($ext,$allowed)){

            $folder=__DIR__."/imgs/";

            $newName=time()."_".rand(1000,9999).".".$ext;

            if(move_uploaded_file($_FILES["image"]["tmp_name"],$folder.$newName)){

                if(file_exists($folder.$filename)){
                    unlink($folder.$filename);
                }

                $filename=$newName;

            }else{

                $error="Erreur upload image.";

            }

        }else{

            $error="Image non autorisée.";

        }

    }

    if(empty($error)){

        $update=$conn->prepare("UPDATE gallery SET image=?,title=? WHERE id=?");

        $update->bind_param("ssi",$filename,$title,$id);

        if($update->execute()){

            header("Location: gallery.php");

            exit();

        }else{

            $error="Erreur SQL.";

        }

    }

}
?>
<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Gallery</title>

<link rel="stylesheet" href="CSS/gallery.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>Edit Image</h1>

<a href="gallery.php" class="back">

Retour

</a>

</div>

<?php if($error!=""){ ?>

<div class="error">

<?= htmlspecialchars($error) ?>

</div>

<?php } ?>

<form method="POST" enctype="multipart/form-data" class="upload-card">

<img
src="imgs/<?= htmlspecialchars($image["image"]) ?>"
class="preview"
id="preview">

<input
type="text"
name="title"
value="<?= htmlspecialchars($image["title"]) ?>"
required>

<input
type="file"
name="image"
id="image">

<button
type="submit"
name="save">

<i class="fa-solid fa-floppy-disk"></i>

Save

</button>

</form>

</div>

<script src="Javascript/gallery.js"></script>

</body>

</html>