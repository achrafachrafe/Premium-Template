<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

if(!isset($_GET["id"])){
    header("Location: services.php");
    exit();
}

$id = (int)$_GET["id"];

$stmt = $conn->prepare("DELETE FROM services WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){

    header("Location: services.php?success=deleted");

}else{

    header("Location: services.php?error=delete");

}

$stmt->close();
$conn->close();

exit();
?>