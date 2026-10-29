<?php
session_start();

if(!isset($_SESSION["admin"])){
    http_response_code(403);
    exit();
}

include "db.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";

header("Content-Type: application/json");

$subject = trim($_POST["subject"] ?? "");
$message = trim($_POST["message"] ?? "");

$offset = intval($_POST["offset"] ?? 0);

$limit = 50;

if($subject=="" || $message==""){

    echo json_encode([
        "success"=>false,
        "message"=>"Subject or message is empty."
    ]);

    exit();

}

/* SMTP */

$config = $conn->query("
SELECT *
FROM smtp_settings
LIMIT 1
")->fetch_assoc();

if(!$config){

    echo json_encode([
        "success"=>false,
        "message"=>"SMTP settings not found."
    ]);

    exit();

}

/* Total */

$total = $conn->query("
SELECT COUNT(*) total
FROM newsletter
")->fetch_assoc()["total"];

/* Batch */

$result = $conn->query("
SELECT email
FROM newsletter
ORDER BY id
LIMIT $offset,$limit
");

$mail = new PHPMailer(true);

try{

    $mail->isSMTP();

    $mail->Host = $config["host"];

    $mail->SMTPAuth = true;

    $mail->Username = $config["username"];

    $mail->Password = $config["password"];

    if($config["encryption"]=="ssl"){

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

    }else{

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    }

    $mail->Port = $config["port"];

    $mail->CharSet = "UTF-8";

    $mail->setFrom(
        $config["from_email"],
        $config["from_name"]
    );

    $mail->isHTML(true);

    $sent = 0;
    $failed=0;

    while($row = $result->fetch_assoc()){

        $mail->clearAddresses();

        $mail->addAddress($row["email"]);

        $mail->Subject = $subject;

        $mail->Body = nl2br(htmlspecialchars($message));

       try{

if($mail->send()){

$sent++;

}else{

$failed++;

}

}catch(Exception $e){

$failed++;

}

    }

    $nextOffset = $offset + $limit;

    echo json_encode([

"success"=>true,

"sent"=>$sent,

"failed"=>$failed,

"offset"=>$nextOffset,

"total"=>$total,

"finished"=>$nextOffset >= $total

]);

}catch(Exception $e){

    echo json_encode([

        "success"=>false,

        "message"=>$mail->ErrorInfo

    ]);

}