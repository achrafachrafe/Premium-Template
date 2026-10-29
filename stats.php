<?php
session_start();

if(!isset($_SESSION["admin"])){
    header("Location: login.php");
    exit();
}

include "db.php";

/* Total Messages */
$msg = $conn->query("SELECT COUNT(*) AS total FROM contacts");
$totalMessages = $msg->fetch_assoc()["total"];

/* Newsletter */
$news = $conn->query("SELECT COUNT(*) AS total FROM newsletter");
$totalNewsletter = $news->fetch_assoc()["total"];

/* Gallery */
$gallery = $conn->query("SELECT COUNT(*) AS total FROM gallery");
$totalGallery = $gallery->fetch_assoc()["total"];

/* Admin */
$admin = $conn->query("SELECT username FROM admins LIMIT 1");
$adminName = $admin->fetch_assoc()["username"];

/* Last Message */
$last = $conn->query("SELECT * FROM contacts ORDER BY id DESC LIMIT 1");
$lastMessage = $last->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Statistics</title>

<link rel="stylesheet" href="CSS/statss.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="container">

<div class="header">

<h1>Dashboard Statistics</h1>

<a href="admin.php" class="back">Dashboard</a>

</div>

<div class="cards">

<div class="card blue">

<i class="fas fa-envelope"></i>

<h2><?= $totalMessages ?></h2>

<p>Messages</p>

</div>

<div class="card green">

<i class="fas fa-paper-plane"></i>

<h2><?= $totalNewsletter ?></h2>

<p>Newsletter</p>

</div>

<div class="card orange">

<i class="fas fa-image"></i>

<h2><?= $totalGallery ?></h2>

<p>Gallery</p>

</div>

<div class="card purple">

<i class="fas fa-user"></i>

<h2><?= htmlspecialchars($adminName) ?></h2>

<p>Admin</p>

</div>

</div>

<?php if($lastMessage){ ?>

<div class="last">

<h2>Last Message</h2>

<p><b>Name :</b> <?= htmlspecialchars($lastMessage["name"]) ?></p>

<p><b>Email :</b> <?= htmlspecialchars($lastMessage["email"]) ?></p>

<p><b>Subject :</b> <?= htmlspecialchars($lastMessage["subject"]) ?></p>

<p><b>Date :</b> <?= htmlspecialchars($lastMessage["created_at"]) ?></p>

</div>

<?php } ?>

</div>
<div class="charts">

<div class="chart-card">

<h2>Website Statistics</h2>

<canvas id="statsChart"></canvas>

</div>

<div class="chart-card">

<h2>Website Overview</h2>

<canvas id="pieChart"></canvas>

</div>

</div>
<script>

const ctx=document.getElementById("statsChart");

new Chart(ctx,{

type:"bar",

data:{

labels:["Messages","Newsletter","Gallery"],

datasets:[{

label:"Statistics",

data:[
<?= $totalMessages ?>,
<?= $totalNewsletter ?>,
<?= $totalGallery ?>
],

borderWidth:2

}]

},

options:{

responsive:true,

plugins:{

legend:{
display:false
}

},

scales:{

y:{
beginAtZero:true
}

}

}

});

const pie=document.getElementById("pieChart");

new Chart(pie,{

type:"doughnut",

data:{

labels:["Messages","Newsletter","Gallery"],

datasets:[{

data:[
<?= $totalMessages ?>,
<?= $totalNewsletter ?>,
<?= $totalGallery ?>
]

}]

},

options:{

responsive:true

}

});

</script>
</body>

</html>