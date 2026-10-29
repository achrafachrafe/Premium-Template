<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=newsletter_".date("Y-m-d_H-i-s").".csv");

$output = fopen("php://output","w");

/* UTF-8 BOM for Excel */
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

/* Header */

fputcsv($output,[
    "ID",
    "Email",
    "Date"
]);

$result = $conn->query("
SELECT
id,
email,
created_at
FROM newsletter
ORDER BY id DESC
");

while($row = $result->fetch_assoc()){

    fputcsv($output,[
        $row["id"],
        $row["email"],
        $row["created_at"]
    ]);

}

fclose($output);
exit();
?>