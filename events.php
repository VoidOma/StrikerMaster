<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo">
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
        <section class="hero">
            <h2>Découvrez Nos Activités</h2>
            <p>Restez informé des derniers matchs, tournois et galas.</p>
            <div class="hero-links">
                <a href="calendrier.php" class="btn">Voir le calendrier</a>
                <a href="galerie.php" class="btn">Voir la galerie</a>
            </div>
        </section>

        <section class="events-container">
            <article class="event">
                <img src="matchs.jpg" alt="Matchs" class="event-image">
                <h3>Matchs</h3>
                <p class="event-description">Venez assister à des matchs palpitants où les meilleurs joueurs s'affrontent. Ne manquez pas l’action !</p>
            </article>
            <article class="event">
                <img src="tournois.jpg" alt="Tournois" class="event-image">
                <h3>Tournois</h3>
                <p class="event-description">Participez ou assistez à nos tournois passionnants qui mettent au défi les meilleures équipes et individus.</p>
            </article>
            <article class="event">
                <img src="galas.jpg" alt="Galas" class="event-image">
                <h3>Galas</h3>
                <p class="event-description">Célébrez la passion du jeu lors de nos galas exclusifs avec des invités spéciaux et des animations.</p>
            </article>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Votre Site. Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>
</body>
</html>
