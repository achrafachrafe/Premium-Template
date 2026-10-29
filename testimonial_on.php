<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location:login.php");
    exit();
}

include "db.php";

$id=(int)$_GET["id"];

$conn->query("UPDATE contacts SET is_testimonial=1 WHERE id=$id");

header("Location:messages.php");