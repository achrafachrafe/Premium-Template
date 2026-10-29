<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

$success = "";
$error = "";

/* Récupérer les paramètres */

$result = $conn->query("SELECT * FROM settings WHERE id=1");

if($result->num_rows == 0){
    die("La table settings est vide.");
}

$row = $result->fetch_assoc();

/* Mise à jour */

if(isset($_POST["save"])){

    $fullname = trim($_POST["fullname"]);
    $job = trim($_POST["job"]);
    $about = trim($_POST["about"]);

    $followers = trim($_POST["followers"]);
    $brands = trim($_POST["brands"]);
    $views = trim($_POST["views"]);

    $instagram = trim($_POST["instagram"]);
    $tiktok = trim($_POST["tiktok"]);
    $youtube = trim($_POST["youtube"]);
    $facebook = trim($_POST["facebook"]);

    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);

    $logo_title = trim($_POST["logo_title"]);

    $avatar = $row["avatar"];
    $logo = $row["logo"];
    $favicon = $row["favicon"];
    

    /* Upload Avatar */

    if(isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0){

        $allowed = ["jpg","jpeg","png","webp"];

        $ext = strtolower(pathinfo($_FILES["avatar"]["name"],PATHINFO_EXTENSION));

        if(in_array($ext,$allowed)){

            $avatar = time().".".$ext;

            move_uploaded_file(
                $_FILES["avatar"]["tmp_name"],
                "imgs/".$avatar
            );

        }else{

            $error = "Format image non autorisé.";

        }

    }
    /* Upload Logo */

if(isset($_FILES["logo"]) && $_FILES["logo"]["error"]==0){

    $ext=strtolower(pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION));

    if(in_array($ext,["jpg","jpeg","png","webp","svg"])){

        $logo=time()."_logo.".$ext;

        move_uploaded_file(
    $_FILES["logo"]["tmp_name"],
    "imgs/".$logo
);

    }

}

/* Upload Favicon */

if(isset($_FILES["favicon"]) && $_FILES["favicon"]["error"]==0){

    $ext=strtolower(pathinfo($_FILES["favicon"]["name"],PATHINFO_EXTENSION));

    if(in_array($ext,["ico","png","jpg","jpeg","svg"])){

        $favicon=time()."_favicon.".$ext;

        move_uploaded_file(
    $_FILES["favicon"]["tmp_name"],
    "imgs/".$favicon
);

    }

}


$seo_title=trim($_POST["seo_title"]);
$seo_description=trim($_POST["seo_description"]);
$seo_keywords=trim($_POST["seo_keywords"]);
$website_url=trim($_POST["website_url"]);

    if(empty($error)){

        $stmt = $conn->prepare("UPDATE settings SET

        fullname=?,
        job=?,
        about=?,
        avatar=?,
        followers=?,
        brands=?,
        views=?,
        instagram=?,
        tiktok=?,
        youtube=?,
        facebook=?,
        email=?,
        phone=?,
        address=?,
        logo=?,
        favicon=?,
        seo_title=?,
        seo_description=?,
        seo_keywords=?,
        website_url=?,
        logo_title=?

        WHERE id=1");

        $stmt->bind_param(

        "sssssssssssssssssssss",

        $fullname,
        $job,
        $about,
        $avatar,
        $followers,
        $brands,
        $views,
        $instagram,
        $tiktok,
        $youtube,
        $facebook,
        $email,
        $phone,
        $address,
        $logo,
        $favicon,
        $seo_title,
        $seo_description,
        $seo_keywords,
        $website_url,
        $logo_title

        );

        if($stmt->execute()){

            $success = "Paramètres enregistrés.";

            $result = $conn->query("SELECT * FROM settings WHERE id=1");
            $row = $result->fetch_assoc();

        }else{

            $error = "Erreur lors de l'enregistrement.";

        }

        $stmt->close();

    }

}
?>
<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Website Settings</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet" href="CSS/settingss.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>

<i class="fa-solid fa-gear"></i>

Website Settings

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

<form method="POST" enctype="multipart/form-data">

<div class="grid">

<div class="card">

<h2>Informations</h2>

<label>Nom</label>

<input
type="text"
name="fullname"
value="<?= htmlspecialchars($row["fullname"]) ?>"
required>

<label>Profession</label>

<input
type="text"
name="job"
value="<?= htmlspecialchars($row["job"]) ?>"
required>

<label>About</label>

<textarea
name="about"
rows="6"
required><?= htmlspecialchars($row["about"]) ?></textarea>

</div>

<div class="card">

<h2>Avatar</h2>

<img
src="imgs/<?= htmlspecialchars($row["avatar"]) ?>"
class="avatar-preview"
id="preview">

<input
type="file"
name="avatar"
id="avatar">

</div>

<div class="card">

<h2>Statistics</h2>

<label>Followers</label>

<input
type="text"
name="followers"
value="<?= htmlspecialchars($row["followers"]) ?>">

<label>Brands</label>

<input
type="text"
name="brands"
value="<?= htmlspecialchars($row["brands"]) ?>">

<label>Views</label>

<input
type="text"
name="views"
value="<?= htmlspecialchars($row["views"]) ?>">

</div>

<div class="card">

<h2>Social Media</h2>

<label>Instagram</label>

<input
type="url"
name="instagram"
value="<?= htmlspecialchars($row["instagram"]) ?>">

<label>TikTok</label>

<input
type="url"
name="tiktok"
value="<?= htmlspecialchars($row["tiktok"]) ?>">

<label>YouTube</label>

<input
type="url"
name="youtube"
value="<?= htmlspecialchars($row["youtube"]) ?>">

<label>Facebook</label>

<input
type="url"
name="facebook"
value="<?= htmlspecialchars($row["facebook"]) ?>">

</div>

<div class="card">

<h2>Contact</h2>

<label>Email</label>

<input
type="email"
name="email"
value="<?= htmlspecialchars($row["email"]) ?>">

<label>Téléphone</label>

<input
type="text"
name="phone"
value="<?= htmlspecialchars($row["phone"]) ?>">

<label>Adresse</label>

<input
type="text"
name="address"
value="<?= htmlspecialchars($row["address"]) ?>">

<label>Logo Title</label>

<input
type="text"
name="logo_title"
value="<?= htmlspecialchars($row["logo_title"]) ?>">

</div>

<div class="card">

<div class="form-group">

<label>📝 SEO Title</label>

<input
type="text"
name="seo_title"
value="<?= htmlspecialchars($row["seo_title"]) ?>">

</div>

<div class="form-group">

<label>📄 SEO Description</label>

<textarea
name="seo_description"
rows="4"><?= htmlspecialchars($row["seo_description"]) ?></textarea>

</div>

<div class="form-group">

<label>🔑 SEO Keywords</label>

<textarea
name="seo_keywords"
rows="3"><?= htmlspecialchars($row["seo_keywords"]) ?></textarea>

</div>

<div class="form-group">

<label>🌍 Website URL</label>

<input
type="url"
name="website_url"
value="<?= htmlspecialchars($row["website_url"]) ?>">

</div>
</div>
<div class="card">
<h2>Branding & SEO</h2>

<div class="form-group">

<label>📷 Logo</label>

<input
type="file"
name="logo"
accept="image/*">

<?php if(!empty($row["logo"])){ ?>

<div class="preview">

<img src="imgs/<?= htmlspecialchars($row["logo"]) ?>">

<br>

<a
href="delete_media.php?type=logo"
class="delete-file"
onclick="return confirm('Supprimer le logo ?')">

<i class="fas fa-trash"></i>

Supprimer

</a>

</div>

<?php } ?>

</div>

<div class="form-group">

<label>🌐 Favicon</label>

<input
type="file"
name="favicon"
accept=".ico,.png,.jpg,.jpeg,.svg">

<?php if(!empty($row["favicon"])){ ?>

<div class="preview">

<img src="imgs/<?= htmlspecialchars($row["favicon"]) ?>">

<br>

<a
href="delete_media.php?type=favicon"
class="delete-file"
onclick="return confirm('Supprimer le favicon?')">

<i class="fas fa-trash"></i>

Supprimer

</a>

</div>

<?php } ?>

</div>


<button
type="submit"
name="save"
class="save">

<i class="fa-solid fa-floppy-disk"></i>

Save Settings

</button>
</div>
</form>



<script src="Javascipt/settings.js"></script>

</body>

</html>