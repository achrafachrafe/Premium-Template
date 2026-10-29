<?php
session_start();

if(!isset($_SESSION["admin"])){
header("Location:login.php");
exit();
}

include "db.php";
$count = $conn->query("SELECT COUNT(*) AS total FROM newsletter");
$total = $count->fetch_assoc();
$result=$conn->query("SELECT * FROM newsletter ORDER BY id DESC");
?>

<!DOCTYPE html>

<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Newsletter</title>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
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
margin-bottom:40px;

}

.header h1{

font-size:32px;
font-weight:700;

}

.card{

display:inline-block;

min-width:280px;

background:linear-gradient(135deg,#2563eb,#1d4ed8);

padding:30px;

border-radius:20px;

margin-bottom:30px;

box-shadow:0 15px 40px rgba(0,0,0,.35);

}

.card:hover{

transform:translateY(-6px);

}

.card h2{

font-size:55px;

margin-bottom:10px;

}

.card p{

font-size:18px;

opacity:.9;

}

.table-box{

background:#111827;

border-radius:20px;

overflow:hidden;

box-shadow:0 15px 35px rgba(0,0,0,.35);

overflow-x:auto;

}

table{

width:100%;

border-collapse:collapse;

min-width:850px;

}

th{

background:#2563eb;

padding:18px;

text-align:left;

}

td{

padding:18px;

border-bottom:1px solid rgba(255,255,255,.08);

}

tr:hover{

background:#1f2937;

}

.email{

color:#60a5fa;

font-weight:600;

}

.delete{

display:inline-flex;

align-items:center;

justify-content:center;

padding:10px 16px;

border-radius:10px;

font-weight:bold;

background:#dc2626;

transition:.3s;

}

.delete:hover{

background:#b91c1c;

transform:scale(1.05);

}

.back{

display:inline-flex;

align-items:center;

justify-content:center;

gap:8px;

padding:14px 22px;

border-radius:12px;

background:#2563eb;

color:#fff;

text-decoration:none;

font-weight:600;

transition:.3s;

}

.back:hover{

transform:translateY(-3px);

background:#1d4ed8;

}

@media(max-width:768px){

body{

padding:20px;

}

.card{

width:100%;

}

.table-box{

overflow-x:auto;

}

table{

min-width:700px;

}

.header{

flex-direction:column;

align-items:flex-start;

gap:20px;

}

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

.search{

width:100%;

padding:15px 20px;

background:#1f2937;

border:1px solid #374151;

border-radius:12px;

color:#fff;

font-size:16px;

margin-bottom:25px;

}

.search:focus{

border-color:#3b82f6;

box-shadow:0 0 0 3px rgba(59,130,246,.25);

}

.actions{

display:flex;

gap:15px;

flex-wrap:wrap;

margin-bottom:20px;

}

.success{

background:#16a34a;

color:#fff;

padding:15px;

border-radius:10px;

margin-bottom:20px;

text-align:center;

font-weight:bold;

}

</style>

</head>

<body>
    <?php

$count = $conn->query("SELECT COUNT(*) AS total FROM newsletter");
$total = $count->fetch_assoc();

?>
<?php if(isset($_GET["sent"])){ ?>

<div class="success">

✅ <?= intval($_GET["sent"]) ?> email(s) sent successfully.

</div>

<?php } ?>

<?php if(isset($_GET["smtp_error"])){ ?>

<div class="error">

❌ SMTP Error. Please check your SMTP settings.

</div>

<?php } ?>

<div class="card">

<h2><?= $total["total"] ?></h2>

<p>Newsletter Subscribers</p>

</div>
<br>
<div style="margin-top:30px">

<a href="admin.php" class="back">

← Back to Dashboard

</a>

</div>

<div class="container">

<div class="header">

<h1>Newsletter Subscribers</h1>

<div class="actions">

<a href="send_newsletter.php" class="back">

📧 Send Newsletter

</a>

<a href="export_newsletter.php" class="back">

📥 Export CSV

</a>

<button
type="submit"
class="delete"
onclick="return confirm('Delete selected emails?')">

🗑 Delete Selected

</button>

</div>

</div>
<div class="table-box">
<input
type="text"
id="search"
placeholder="🔍 Search email..."
class="search">
<br><br>

<form
method="post"
action="delete_selected_newsletter.php">

<table>

<thead>

<tr>

<th>

<input type="checkbox" id="checkAll">

</th>

<th>ID</th>

<th>Email</th>

<th>Date</th>

<th>Delete</th>

</tr>

</thead>

<tbody id="newsletterTable">

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td>

<input
type="checkbox"
name="ids[]"
value="<?= $row["id"] ?>">

</td>

<td><?= $row["id"] ?></td>

<td><?= htmlspecialchars($row["email"]) ?></td>

<td><?= $row["created_at"] ?></td>

<td>

<a class="delete"
href="delete_newsletter.php?id=<?= $row["id"] ?>"
onclick="return confirm('Supprimer cet email ?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<br>


</form>
</div>
</div>

<script>

const search=document.getElementById("search");

search.addEventListener("keyup",function(){

let value=this.value.toLowerCase();

document.querySelectorAll("#newsletterTable tr").forEach(row=>{

row.style.display=
row.innerText.toLowerCase().includes(value)
?"":"none";

});

});

document.getElementById("checkAll").onclick=function(){

document.querySelectorAll("input[name='ids[]']").forEach(box=>{

box.checked=this.checked;

});

};

</script>
</body>

</html>