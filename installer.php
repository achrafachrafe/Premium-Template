<?php

if(file_exists("installed.lock")){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"]!="POST"){
    header("Location: install.php");
    exit();
}

$db_host = trim($_POST["db_host"]);
$db_name = trim($_POST["db_name"]);
$db_user = trim($_POST["db_user"]);
$db_pass = trim($_POST["db_pass"]);

/* Connexion MySQL */

$conn = @new mysqli($db_host,$db_user,$db_pass);

if($conn->connect_error){
    die("Connexion impossible : ".$conn->connect_error);
}

/* Création Base */

$conn->query("
CREATE DATABASE IF NOT EXISTS `$db_name`
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci
");

/* Sélection */

if(!$conn->select_db($db_name)){
    die("Impossible de sélectionner la base de données.");
}

/* Création db.php */

$config = "<?php

\$host='$db_host';
\$user='$db_user';
\$pass='$db_pass';
\$db='$db_name';

\$conn=new mysqli(\$host,\$user,\$pass,\$db);

if(\$conn->connect_error){
    die('Connexion échouée');
}

\$conn->set_charset('utf8mb4');

?>";

file_put_contents("db.php",$config);

/* Création table admin */

if(!file_exists("database.sql")){
    die("Le fichier database.sql est introuvable.");
}

$sql = file_get_contents("database.sql");

if($sql === false){
    die("Impossible de lire database.sql");
}

if($sql === false){
    die("Impossible de lire database.sql");
}

if($conn->multi_query($sql)){

    do{
        if($result = $conn->store_result()){
            $result->free();
        }
    }while($conn->next_result());

}else{

    die("Erreur SQL : ".$conn->error);

}

/* Données par défaut */
$conn->query("
INSERT INTO settings(
id,
fullname,
job,
about,
followers,
brands,
views,
logo_title,
seo_title
)
VALUES(
1,
'Influencer',
'Content Creator',
'Bienvenue sur votre nouveau site.',
'0',
'0',
'0',
'Influencer',
'Influencer Website'
)
");

$conn->close();
header("Location: admin_install.php");
exit();

?>