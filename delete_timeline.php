<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

if(!isset($_GET["id"])){
    header("Location: timeline.php");
    exit();
}

$id = (int)$_GET["id"];

/* Vérifier si l'étape existe */

$stmt = $conn->prepare("SELECT id FROM timeline WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==0){
    header("Location: timeline.php");
    exit();
}

/* Supprimer */

$delete = $conn->prepare("DELETE FROM timeline WHERE id=?");
$delete->bind_param("i",$id);

if($delete->execute()){

    header("Location: timeline.php?success=deleted");

}else{

    header("Location: timeline.php?error=delete");

}

exit();
?>