<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

$success="";
$error="";

if(isset($_POST["change"])){

    $old=trim($_POST["old_password"]);
    $new=trim($_POST["new_password"]);
    $confirm=trim($_POST["confirm_password"]);

    if($old=="" || $new=="" || $confirm==""){

        $error="Veuillez remplir tous les champs.";

    }elseif($new!=$confirm){

        $error="Les mots de passe ne correspondent pas.";

    }elseif(strlen($new)<6){

        $error="Le mot de passe doit contenir au moins 6 caractères.";

    }else{

        $admin=$_SESSION["admin"];

        $stmt=$conn->prepare("SELECT password FROM admins WHERE username=?");
        $stmt->bind_param("s",$admin);
        $stmt->execute();

        $result=$stmt->get_result();

        if($result->num_rows){

            $row=$result->fetch_assoc();

            if(password_verify($old,$row["password"])){

                $hash=password_hash($new,PASSWORD_DEFAULT);

                $update=$conn->prepare("
                UPDATE admins
                SET password=?
                WHERE username=?
                ");

                $update->bind_param("ss",$hash,$admin);

                if($update->execute()){

                    $success="Mot de passe modifié avec succès.";

                }else{

                    $error="Erreur lors de la modification.";

                }

            }else{

                $error="Ancien mot de passe incorrect.";

            }

        }

    }

}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width,initial-scale=1.0">

<title>Change Password</title>

<link rel="stylesheet" href="css/change_password.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="card">

<h1>

<i class="fas fa-lock"></i>

Changer le mot de passe

</h1>

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

<form method="POST">

<input
type="password"
name="old_password"
placeholder="Ancien mot de passe"
required>

<input
type="password"
name="new_password"
placeholder="Nouveau mot de passe"
required>

<input
type="password"
name="confirm_password"
placeholder="Confirmer le mot de passe"
required>

<button
type="submit"
name="change">

<i class="fas fa-save"></i>

Changer

</button>

</form>

<a href="admin.php" class="back">

<i class="fas fa-arrow-left"></i>

Retour au Dashboard

</a>

</div>

</div>

</body>

</html>