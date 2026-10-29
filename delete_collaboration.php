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

/* Récupérer le logo */

$stmt = $conn->prepare("SELECT logo FROM collaborations WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==0){

    header("Location: collaborations.php");
    exit();

}

$row = $result->fetch_assoc();

$logo = "imgs/brands/".$row["logo"];

/* Supprimer de la base */

$delete = $conn->prepare("DELETE FROM collaborations WHERE id=?");
$delete->bind_param("i",$id);

if($delete->execute()){

    if(file_exists($logo)){

        unlink($logo);

    }

    header("Location: collaborations.php?success=deleted");

}else{

    header("Location: collaborations.php?error=delete");

}

exit();
?>