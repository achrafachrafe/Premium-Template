<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Admin</title>
    <style>
   *{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{

background:linear-gradient(135deg,#0f172a,#1e293b);

min-height:100vh;

padding:50px;

color:#fff;

}

/*==========================
TITLE
==========================*/

h1{

text-align:center;

margin-bottom:40px;

font-size:38px;

font-weight:700;

}

/*==========================
MAIN CARDS
==========================*/

.cards{

display:grid;

grid-template-columns:repeat(auto-fit,minmax(260px,1fr));

gap:30px;

margin-bottom:60px;

}

.card{

background:rgba(255,255,255,.08);

backdrop-filter:blur(15px);

border:1px solid rgba(255,255,255,.1);

border-radius:22px;

padding:40px 20px;

text-decoration:none;

color:#fff;

text-align:center;

transition:.35s;

box-shadow:0 15px 35px rgba(0,0,0,.25);

}

.card:hover{

transform:translateY(-10px) scale(1.03);

border-color:#3b82f6;

box-shadow:0 20px 40px rgba(37,99,235,.3);

}

.card .emoji{

font-size:60px;

display:block;

margin-bottom:20px;

}

.card h3{

font-size:24px;

margin-top:10px;

}

.card p{

margin-top:10px;

color:#cbd5e1;

font-size:15px;

}

.logout{

background:linear-gradient(135deg,#dc2626,#b91c1c);

}

.logout:hover{

background:linear-gradient(135deg,#ef4444,#dc2626);

}

/*==========================
SETTINGS MENU
==========================*/

.settings-menu{

display:grid;

grid-template-columns:repeat(auto-fit,minmax(240px,1fr));

gap:25px;

}

.settings-menu a{

background:#111827;

border-radius:18px;

padding:30px;

text-decoration:none;

display:flex;

flex-direction:column;

align-items:center;

justify-content:center;

gap:18px;

color:white;

font-size:18px;

font-weight:600;

transition:.35s;

border:1px solid rgba(255,255,255,.08);

box-shadow:0 10px 30px rgba(0,0,0,.3);

}

.settings-menu a:hover{

transform:translateY(-8px);

background:#2563eb;

}

.settings-menu i{

font-size:50px;

color:#60a5fa;

transition:.35s;

}

.settings-menu a:hover i{

transform:rotate(8deg) scale(1.2);

color:#fff;

}

/*==========================
RESPONSIVE
==========================*/

@media(max-width:768px){

body{

padding:20px;

}

.cards{

grid-template-columns:1fr;

}

.settings-menu{

grid-template-columns:1fr;

}

.card{

padding:30px;

}

}
</style>
</head>
<body>
    <div class="cards">
        <h1>Admin Dashboard</h1>
        <a href="change_password.php" class="card">
<i class="fas fa-key emoji"></i>
<h3>Change Password</h3>
</a>

<a href="settings.php" class="card">

<span class="emoji">⚙️</span>

<h3>Website Settings</h3>

<p>Edit your website information.</p>

</a>

<a href="messages.php" class="card">

<span class="emoji">📩</span>

<h3>Messages</h3>

<p>Read contact messages.</p>

</a>

<a href="newsletter_admin.php" class="card">

<span class="emoji">📧</span>

<h3>Newsletter</h3>

<p>Manage subscribers.</p>

</a>

<a href="gallery.php" class="card">

<span class="emoji">🖼️</span>

<h3>Gallery</h3>

<p>Manage gallery images.</p>

</a>

<a href="stats.php" class="card">

<span class="emoji">📊</span>

<h3>Statistics</h3>

<p>Website analytics.</p>

</a>

<a href="logout.php" class="card logout">

<span class="emoji">🚪</span>

<h3>Logout</h3>

<p>Sign out safely.</p>

</a>

</div>
<div class="settings-menu">

<a href="socials.php">
<i class="fab fa-instagram"></i>
Social Media
</a>

<a href="services.php">
<i class="fas fa-briefcase"></i>
Services
</a>

<a href="collaborations.php">
<i class="fas fa-handshake"></i>
Collaborations / Présence professionnelle
</a>


<a href="timeline.php">
<i class="fas fa-road"></i>
Mon Parcours
</a>


<a href="smtp_settings.php" class="card">

<i class="fas fa-paper-plane"></i>

<h3>SMTP</h3>

</a>

</div>
</body>
</html>