<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location:login.php");
    exit();
}

include "db.php";

$type=$_GET["type"] ?? "";

$allowed=[
    "logo",
    "favicon"
];

if(!in_array($type,$allowed)){
    header("Location:settings.php");
    exit();
}

$row=$conn->query("SELECT $type FROM settings WHERE id=1")->fetch_assoc();

$file=$row[$type];

if($file!=""){

    $path="imgs/".$file;

    if(file_exists($path)){
        unlink($path);
    }

    $conn->query("UPDATE settings SET $type=NULL WHERE id=1");

}

header("Location:settings.php");
exit();