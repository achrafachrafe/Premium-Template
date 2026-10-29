<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

if(!isset($_POST["id"])){
    header("Location: admin.php");
    exit();
}

$id = intval($_POST["id"]);

if($id <= 0){
    header("Location: admin.php");
    exit();
}

$stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");

$stmt->bind_param("i",$id);

if($stmt->execute()){

    if(isset($_SERVER['HTTP_REFERER'])){
    header("Location: ".$_SERVER['HTTP_REFERER']);
}else{
    header("Location: admin.php");
}
exit();

}else{

    echo "Erreur lors de la suppression.";

}

$stmt->close();
$conn->close();
?>