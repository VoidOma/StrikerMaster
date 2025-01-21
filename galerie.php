<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Galerie d'Images</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="about.php">À propos</a></li>
                <li><a href="events.php">Événements</a></li>
                <li><a href="classement.php">Classement</a></li>
                <li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="profile.php">Profil</a>
                        <a href="deconnexion.php">Déconnexion</a>
                        
                    <?php else: ?>
                        <a href="connexion.php">Connexion</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <section class="gallery">
        <h2>Nos Images</h2>
        <div class="image-grid">
            <div class="image-item">
                <img src="image1.jpg" alt="Image 1">
            </div>
            <div class="image-item">
                <img src="image2.jpg" alt="Image 2">
            </div>
            <div class="image-item">
                <img src="image3.jpg" alt="Image 3">
            </div>
            <div class="image-item">
                <img src="image4.jpg" alt="Image 4">
            </div>
            <div class="image-item">
                <img src="image5.jpg" alt="Image 5">
            </div>
            <div class="image-item">
                <img src="image6.jpg" alt="Image 6">
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>
</body>
</html>
