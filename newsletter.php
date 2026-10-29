<?php

include "db.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$email=trim($_POST["email"]);

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

die("Email invalide.");

}

$stmt=$conn->prepare(
"INSERT IGNORE INTO newsletter(email)
VALUES(?)"
);

$stmt->bind_param("s",$email);

$stmt->execute();

header("Location:index.php?newsletter=1");

exit();

}
?>