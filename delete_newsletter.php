<?php

session_start();

if(!isset($_SESSION["admin"])){
header("Location:login.php");
exit();
}

include "db.php";

$id=(int)$_GET["id"];

$stmt=$conn->prepare(
"DELETE FROM newsletter WHERE id=?"
);

$stmt->bind_param("i",$id);

$stmt->execute();

header("Location:newsletter_admin.php");

exit();

?>