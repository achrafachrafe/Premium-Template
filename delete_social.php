<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

if(!isset($_GET["id"])){
    header("Location: socials.php");
    exit();
}

$id = (int)$_GET["id"];

$stmt = $conn->prepare("DELETE FROM socials WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){

    header("Location: socials.php?success=deleted");

}else{

    header("Location: socials.php?error=delete");

}

exit();
?>