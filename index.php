<?php
include "db.php";

$result = $conn->query("SELECT * FROM settings WHERE id=1");
$site = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($site["seo_title"]) ?></title>

<meta name="description"
content="<?= htmlspecialchars($site["seo_description"]) ?>">

<meta name="keywords"
content="<?= htmlspecialchars($site["seo_keywords"]) ?>">

<link rel="icon"
href="imgs/<?= htmlspecialchars($site["favicon"]) ?>">

<link rel="canonical"
href="<?= htmlspecialchars($site["website_url"]) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet" href="CSS/style.css">

<script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
  <meta property="og:title"
content="<?= htmlspecialchars($site["seo_title"]) ?>">

<meta property="og:description"
content="<?= htmlspecialchars($site["seo_description"]) ?>">

<meta property="og:image"
content="<?= htmlspecialchars($site["website_url"]) ?>/imgs/<?= htmlspecialchars($site["logo"]) ?>">

<meta property="og:url"
content="<?= htmlspecialchars($site["website_url"]) ?>">

<meta property="og:type"
content="website">
</head>

<body>
<!-- Loader -->

<div id="loader">

<div class="loader-circle"></div>

</div>

<!-- Cursor -->

<div class="cursor"></div>

<!-- Background -->

<div class="bg"></div>

<div id="tsparticles"></div>

<!-- Floating Icons -->

<div class="floating-icons">

<i class="fab fa-instagram"></i>

<i class="fab fa-tiktok"></i>

<i class="fab fa-youtube"></i>

<i class="fab fa-facebook"></i>

</div>

<!-- Header -->

<header>

<div class="logo">

<i class="fa-solid fa-crown"></i>

<?php if(!empty($site["logo"])){ ?>

<img
src="imgs/<?= htmlspecialchars($site["logo"]) ?>"
class="logo-img"
alt="Logo">

<?php }else{ ?>

<span><?= htmlspecialchars($site["logo_title"]) ?></span>

<?php } ?>

</div>

<nav>

<a href="#home">Accueil</a>

<a href="#about">À propos</a>

<a href="#socials">Réseaux</a>

<a href="#gallery">Galerie</a>

<a href="#contact">Contact</a>

</nav>

</header>

<!-- Hero -->
<section class="hero" id="home">

    <div class="hero-content">

        <div class="hero-image">
            <img src="imgs/<?= htmlspecialchars($site["avatar"]) ?>" class="avatar">
        </div>

        <div class="hero-info">

            <h1><?= htmlspecialchars($site["fullname"]) ?></h1>

            <h2><?= htmlspecialchars($site["job"]) ?></h2>
            <br><br>

<div class="hero-buttons">

    <!-- Contact -->
    <a href="#contact" class="btn-primary">
        <i class="fas fa-envelope"></i>
        Contact Me
    </a>

    <!-- Portfolio -->
    <a href="#gallery" class="btn-outline">
        <i class="fas fa-images"></i>
        Portfolio
    </a>

    <!-- Live Demo -->
    <a href="admin.php" class="btn-primary" target="_blank">
        <i class="fas fa-eye"></i>
        Live Demo
    </a>

    <!-- WhatsApp -->
    <a href="https://wa.me/212611146541"
       class="btn-outline"
       target="_blank"
       rel="noopener noreferrer">
        <i class="fab fa-whatsapp"></i>
        Buy This Template
    </a>

</div>
```


            <div class="stats glass">

                <div class="stat">
                    <h2 id="followers">
                        <?= htmlspecialchars($site["followers"]) ?>
                    </h2>
                    <p>Followers</p>
                </div>

                <div class="stat">
                    <h2 id="brands">
                        <?= htmlspecialchars($site["brands"]) ?>
                    </h2>
                    <p>Brands</p>
                </div>

                <div class="stat">
                    <h2 id="views">
                        <?= htmlspecialchars($site["views"]) ?>
                    </h2>
                    <p>Views</p>
                </div>

            </div>

        </div>

    </div>

</section>

<!-- About -->

<section class="section reveal" id="about">

<h2>About Me</h2>

<div class="about-card glass">

<h3>Qui suis-je ?</h3>

Bienvenue sur mon portfolio.
<br>

<p>

<?= nl2br(htmlspecialchars($site["about"])) ?>

</p>

</div>

</section>

<!-- Socials -->

<section class="section reveal" id="socials">

<h2>Social Media</h2>

<div class="social-grid">

<?php

$socials = $conn->query("SELECT * FROM socials ORDER BY id ASC");

while($social = $socials->fetch_assoc()){

?>

<a
href="<?= htmlspecialchars($social["url"]) ?>"
target="_blank"
rel="noopener noreferrer"
class="social-card glass">

<i class="<?= htmlspecialchars($social["icon"]) ?>"></i>

<h3>

<?= htmlspecialchars($social["platform"]) ?>

</h3>

<p>

<?= htmlspecialchars($social["followers"]) ?>

</p>

</a>

<?php } ?>

</div>

</section>
<!-- ===================== -->
<!-- Gallery -->
<!-- ===================== -->

<?php
$gallery = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
?>

<section class="section reveal" id="gallery">

<h2>Galerie</h2>

<div class="gallery">

<?php while($img = $gallery->fetch_assoc()){ ?>

<div class="gallery-item glass">

<img
src="imgs/<?= htmlspecialchars($img["image"]) ?>"
alt="<?= htmlspecialchars($img["title"]) ?>">

</div>

<?php } ?>

</div>

</section>

<!-- ===================== -->
<!-- Services -->
<!-- ===================== -->

<section class="section reveal" id="services">

<h2>Services</h2>

<div class="services-grid">

<?php

$services = $conn->query("SELECT * FROM services ORDER BY id ASC");

while($service = $services->fetch_assoc()){

?>

<div class="service-card glass">

<i class="<?= htmlspecialchars($service["icon"]) ?>"></i>

<h3>

<?= htmlspecialchars($service["title"]) ?>

</h3>

<p>

<?= nl2br(htmlspecialchars($service["description"])) ?>

</p>

</div>

<?php } ?>

</div>

</section>

<!-- ===================== -->
<!-- Brands -->
<!-- ===================== -->

<section class="section reveal" id="brands-section">

<h2>Collaborations / Présence professionnelle</h2>

<div class="brands-grid">

<?php

$brands = $conn->query("SELECT * FROM collaborations ORDER BY id ASC");

while($brand = $brands->fetch_assoc()){

?>

<a
href="<?= htmlspecialchars($brand["website"]) ?>"
target="_blank"
class="brand glass">

<div class="brand-image">

<img
src="imgs/brands/<?= htmlspecialchars($brand["logo"]) ?>"
alt="<?= htmlspecialchars($brand["brand_name"]) ?>">

</div>

<h3>

<?= htmlspecialchars($brand["brand_name"]) ?>

</h3>

</a>

<?php } ?>

</div>

</section>

<!-- ===================== -->
<!-- Testimonials -->
<!-- ===================== -->

<section class="section reveal">

<h2>Témoignages</h2>

<div class="testimonial-grid">

<?php

$testimonials = $conn->query("
SELECT name,message
FROM contacts
WHERE is_testimonial=1
ORDER BY id DESC
");

while($row=$testimonials->fetch_assoc()){

?>

<div class="testimonial glass">

<p>

"
<?= nl2br(htmlspecialchars($row["message"])) ?>
"

</p>

<h4>

— <?= htmlspecialchars($row["name"]) ?>

</h4>

</div>

<?php } ?>

</div>

</section>

<!-- ===================== -->
<!-- Timeline -->
<!-- ===================== -->

<section class="section reveal" id="timeline">

<h2>Mon Parcours</h2>

<div class="timeline">

<?php

$timeline = $conn->query("
SELECT *
FROM timeline
ORDER BY year ASC
");

while($item = $timeline->fetch_assoc()){

?>

<div class="timeline-item glass">

<h3>

<?= htmlspecialchars($item["year"]) ?>

</h3>

<h4>

<?= htmlspecialchars($item["title"]) ?>

</h4>

<p>

<?= nl2br(htmlspecialchars($item["description"])) ?>

</p>

</div>

<?php } ?>

</div>

</section>

<!-- ===================== -->
<!-- Contact -->
<!-- ===================== -->
 
<section class="section reveal" id="contact">

<h2>Contact</h2>

<div class="contact glass">

<form action="contact.php" method="POST">

<input
type="text"
name="name"
placeholder="Votre nom"
required>

<input
type="email"
name="email"
placeholder="Votre email"
required>

<input
type="text"
name="subject"
placeholder="Sujet"
required>

<textarea
name="message"
rows="6"
placeholder="Votre message"
required></textarea>

<button type="submit" class="btn">

Envoyer

</button>

</form>

</div>

</section>
<!-- ===================== -->
<!-- Scroll To Top -->
<!-- ===================== -->

<button id="scrollTop">

<i class="fas fa-arrow-up"></i>

</button>
<!-- ===================== -->
<!-- Newsletter -->
<!-- ===================== -->
<section class="section reveal" id="newsletter">

<h2>Newsletter</h2>

<div class="newsletter glass">

<p>
Recevez les dernières nouveautés,
conseils et collaborations directement
dans votre boîte mail.
</p>

<form action="newsletter.php" method="POST">

<input
type="email"
name="email"
placeholder="Votre email"
required>

<button type="submit">

S'abonner

</button>

</form>

</div>

</section>
<!-- ===================== -->
<!-- Footer -->
<!-- ===================== -->
<footer>

<div class="footer-container">

<div class="footer-logo">

<h2>

<i class="fa-solid fa-crown"></i>


<p><?= htmlspecialchars($site["fullname"]) ?></p>

</h2>

<p>
<?= htmlspecialchars($site["job"]) ?>
</p>

</div>

<div class="footer-links">

<h3>Navigation</h3>

<a href="#home">Accueil</a>
<a href="#about">À propos</a>
<a href="#socials">Social Media</a>
<a href="#gallery">Galerie</a>
<a href="#contact">Contact</a>

</div>
<div class="footer-contact">

<h3>Contact</h3>

<p>
<i class="fas fa-envelope"></i>
<?= htmlspecialchars($site["email"]) ?>
</p>

<p>
<i class="fas fa-phone"></i>
<?= htmlspecialchars($site["phone"]) ?>
</p>

<p>
<i class="fas fa-location-dot"></i>
<?= nl2br(htmlspecialchars($site["address"])) ?>
</p>

</div>
<div class="footer-social">

<h3>Follow Me</h3>

<div class="social-icons">

<a href="<?= htmlspecialchars($site["instagram"]) ?>"><i class="fab fa-instagram"></i></a>

<a href="<?= htmlspecialchars($site["tiktok"]) ?>"><i class="fab fa-tiktok"></i></a>

<a href="<?= htmlspecialchars($site["youtube"]) ?>"><i class="fab fa-youtube"></i></a>

<a href="<?= htmlspecialchars($site["facebook"]) ?>"><i class="fab fa-facebook"></i></a>

</div>

</div>

<hr>

<p class="copyright">
© 2026 <?= htmlspecialchars($site["fullname"]) ?>.
Tous droits réservés.
</p>

</footer>
<script src="Javascript/scr.js"></script>
</body>
</html>