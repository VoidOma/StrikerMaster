<?php
// Démarre la session pour gérer l'état de connexion de l'utilisateur
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers la feuille de style pour le design -->
</head>
<body>
    <!-- En-tête de la page -->
    <header>
        <h1>Galerie d'Images</h1> <!-- Titre principal de la page -->
        <nav>
            <ul>
                <!-- Liens de navigation vers d'autres pages -->
                <li><a href="index.php">Accueil</a></li>
                <li><a href="about.php">À propos</a></li>
                <li><a href="events.php">Événements</a></li>
                <li><a href="classement.php">Classement</a></li>
                <li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- Si l'utilisateur est connecté, afficher le lien vers le profil et la déconnexion -->
                        <a href="profile.php">Profil</a>
                        <a href="deconnexion.php">Déconnexion</a>
                    <?php else: ?>
                        <!-- Si l'utilisateur n'est pas connecté, afficher le lien vers la page de connexion -->
                        <a href="connexion.php">Connexion</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Section principale pour afficher la galerie d'images -->
    <section class="gallery">
        <h2>Nos Images</h2> <!-- Sous-titre de la galerie -->
        <div class="image-grid">
            <!-- Chaque image de la galerie est placée dans une div avec la classe "image-item" -->
            <div class="image-item">
                <img src="image1.jpg" alt="Image 1"> <!-- Première image -->
            </div>
            <div class="image-item">
                <img src="image2.jpg" alt="Image 2"> <!-- Deuxième image -->
            </div>
            <div class="image-item">
                <img src="image3.jpg" alt="Image 3"> <!-- Troisième image -->
            </div>
            <div class="image-item">
                <img src="image4.jpg" alt="Image 4"> <!-- Quatrième image -->
            </div>
            <div class="image-item">
                <img src="image5.jpg" alt="Image 5"> <!-- Cinquième image -->
            </div>
            <div class="image-item">
                <img src="image6.jpg" alt="Image 6"> <!-- Sixième image -->
            </div>
        </div>
    </section>

    <!-- Pied de page -->
    <footer>
        <p>&copy; 2025 Tous droits réservés.</p> <!-- Mention de copyright -->
        <p><a href="partenaire.php">Nos Partenaires</a></p> <!-- Lien vers la page des partenaires -->
    </footer>
</body>
</html>
