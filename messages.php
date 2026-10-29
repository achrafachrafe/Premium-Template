<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$result = $conn->query("SELECT * FROM contacts ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins,sans-serif;
}

body{

background:#0f172a;

color:#fff;

padding:40px;

}

.container{

max-width:1300px;

margin:auto;

}

.header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:30px;

}

.header h1{

font-size:30px;

}

.logout{

background:#ef4444;

color:#fff;

padding:12px 22px;

text-decoration:none;

border-radius:10px;

}

.logout:hover{

background:#dc2626;

}

.table-box{

overflow:auto;

background:#111827;

border-radius:15px;

padding:20px;

}

table{

width:100%;

border-collapse:collapse;

}

th{

background:#2563eb;

padding:15px;

}

td{

padding:15px;

border-bottom:1px solid #333;

text-align:center;

}

tr:hover{

background:#1f2937;

}

.action{

display:flex;

justify-content:center;

gap:10px;

}

.edit{

background:#16a34a;

padding:8px 14px;

border-radius:8px;

color:white;

text-decoration:none;

}

.delete{

background:#dc2626;

padding:8px 14px;

border-radius:8px;

color:white;

text-decoration:none;

}

.email{

color:#60a5fa;

}
.btn{
    background-color: #d80b0b;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}
a{
    color: white;
    text-decoration: none;
}
</style>

</head>

<body>
    <button class="btn">
<a href="newsletter_admin.php">

Newsletter

</a>
    </button>
<div class="container">

<div class="header">

<h1>

<i class="fa-solid fa-chart-line"></i>

Admin Dashboard

</h1>

<a href="admin.php" class="logout">

Back to Dashboard

</a>

</div>

<div class="table-box">

<table>

<tr>

<th>ID</th>

<th>Nom</th>

<th>Email</th>

<th>Sujet</th>

<th>Message</th>

<th>Date</th>

<th>Action</th>

<th>Témoignage</th>

</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>

<td><?= $row["id"] ?></td>

<td><?= htmlspecialchars($row["name"]) ?></td>

<td class="email">

<?= htmlspecialchars($row["email"]) ?>

</td>

<td><?= htmlspecialchars($row["subject"]) ?></td>

<td>

<?= nl2br(htmlspecialchars($row["message"])) ?>

</td>

<td><?= $row["created_at"] ?></td>

<td>

<div class="action">

<a
class="edit"
href="edit.php?id=<?= $row["id"] ?>">

Edit

</a>

<form action="delete.php" method="POST"
onsubmit="return confirm('Supprimer ce message ?');">

<input type="hidden"
name="id"
value="<?= $row["id"] ?>">

<button class="delete" type="submit">

Delete

</button>

</form>

</div>

</td>
<td>

<?php if($row["is_testimonial"]==1){ ?>

<a href="testimonial_off.php?id=<?= $row["id"] ?>" class="delete">

Retirer

</a>

<?php }else{ ?>

<a href="testimonial_on.php?id=<?= $row["id"] ?>" class="edit">

Publier

</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>