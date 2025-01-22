<?php
// Démarre la session pour gérer les données utilisateur
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Métadonnées de la page -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club de Bowling - StrikerMaster</title>
    <!-- Lien vers le fichier style.css -->
    <link rel="stylesheet" href="styles.css">
    <script>
        // Code JavaScript exécuté lorsque toute la page est chargé
        document.addEventListener('DOMContentLoaded', () => {
            // Création des éléments pour la boule et les quilles
            const ball = document.createElement('div');
            const pins = document.createElement('div');

            // Configure la boule de bowling
            ball.className = 'bowling-ball'; // Ajout de la classe CSS
            document.body.appendChild(ball); // Ajout au body de la page

            // Configure les quilles
            pins.className = 'bowling-pins'; // Ajout de la classe CSS
            document.body.appendChild(pins); // Ajout au DOM

            // Animation de la boule de bowling
            let ballPosition = 0; // Position initiale de la boule
            function animateBall() {
                if (ballPosition < window.innerWidth - 100) {
                    // Fait avancer la boule
                    ballPosition += 5;
                    ball.style.left = `${ballPosition}px`;
                    requestAnimationFrame(animateBall); // Continue l'animation
                } else {
                    // Fait "tomber" les quilles
                    pins.classList.add('fall');
                }
            }

            // Lance l'animation après 1 seconde
            setTimeout(() => animateBall(), 1000);
        });
    </script>
</head>

<body>
    <!-- En-tête de la page -->
    <header>
        <div class="logo">
            <!-- Logo et titre du site -->
            <img src="logo.png" alt="Logo StrikerMaster">
            <h1>StrikerMaster</h1>
        </div>
        <nav>
            <!-- Barre de navigation -->
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="about.php">À propos</a></li>
                <li><a href="events.php">Événements</a></li>
                <li><a href="classement.php">Classement</a></li>
                <li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- Affiche "Profil" et "Déconnexion" si l'utilisateur est connecté -->
                        <a href="profile.php">Profil</a>
                        <a href="deconnexion.php">Déconnexion</a>
                    <?php else: ?>
                        <!-- Affiche "Connexion" si l'utilisateur n'est pas connecté -->
                        <a href="connexion.php">Connexion</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Section principale de la page -->
        <section class="hero">
            <h2>Devenir un maître du bowling</h2>
            <p>Rejoignez-nous et progressez dans l'univers du bowling avec StrikerMaster !</p>

            <?php if (isset($_SESSION['username'])): ?>
            <!-- Message de bienvenue si l'utilisateur est connecté -->
            <section class="user-status">
                <p>Bienvenue  
                    <?= htmlspecialchars($_SESSION['username']); ?>.
                </p>
            </section>
        <?php endif; ?>
        </section>

        <section class="features">
            <!-- Section pour afficher des fonctionnalités à venir "carousel en js" -->
            <div class="feature">
            </div>
            <div class="feature">
            </div>
            <div class="feature">
            </div>
        </section>
    </main>

    <footer>
        <!-- Pied de page -->
        <p>&copy; 2024 StrikerMaster. Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>
</body>

</html>
