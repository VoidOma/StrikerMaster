<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Partenaires - StrikerMaster</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo StrikerMaster">
            <h1>StrikerMaster</h1>
        </div>
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

    <main>
        <section class="partners-container">
            <h2>Nos Partenaires</h2>

            <div class="partner">
                <h3>IUT Saint Die </h3>
                <div class="partner-images">
                    <img src="Instagram.png" alt="Image 1 Partenaire 1" class="partner-image">
                    <img src="univ.jpg" alt="Image 2 Partenaire 1" class="partner-image">
                </div>
                <div class="partner-links">
                    <a href="https://www.instagram.com/iut_saintdie/?hl=fr" target="_blank">Instagram</a>
                    <a href="https://iutsd.univ-lorraine.fr" target="_blank">IUT Saint Die</a>
                </div>
            </div>

            <div class="partner">
                <h3>Martin Mathis</h3>
                <div class="partner-images">
                    <img src="Instagram.png" alt="Image 1 Partenaire 2" class="partner-image">
                    <img src="git.jpg" alt="Image 2 Partenaire 2" class="partner-image">
                </div>
                <div class="partner-links">
                    <a href="https://www.instagram.com/mathhis__/?hl=fr " target="_blank">Instagram</a>
                    <a href="https://github.com/Eykime" target="_blank">GitHub</a>
                </div>
            </div>

            <div class="partner">
                <h3>Matejka Milan</h3>
                <div class="partner-images">
                    <img src="Instagram.png" alt="Image 1 Partenaire 3" class="partner-image">
                    <img src="git.jpg" alt="Image 2 Partenaire 3" class="partner-image">
                </div>
                <div class="partner-links">
                    <a href="https://www.instagram.com/milan.mtjka/?hl=fr" target="_blank">Instagram</a>
                    <a href="https://github.com/VoidOma" target="_blank">GitHub</a>
                </div>
            </div>

        </section>
    </main>

    <footer>
        <p>&copy; 2024 StrikerMaster. Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>

</body>

</html>
