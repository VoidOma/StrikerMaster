<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club de Bowling - StrikerMaster</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ball = document.createElement('div');
            const pins = document.createElement('div');

            // Configure the bowling ball
            ball.className = 'bowling-ball';
            document.body.appendChild(ball);

            // Configure the pins
            pins.className = 'bowling-pins';
            document.body.appendChild(pins);

            // Animation
            let ballPosition = 0;
            function animateBall() {
                if (ballPosition < window.innerWidth - 100) {
                    ballPosition += 5;
                    ball.style.left = `${ballPosition}px`;
                    requestAnimationFrame(animateBall);
                } else {
                    pins.classList.add('fall');
                }
            }

            setTimeout(() => animateBall(), 1000);
        });
    </script>

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
        <section class="hero">
            <h2>Devenir un maître du bowling</h2>
            <p>Rejoignez-nous et progressez dans l'univers du bowling avec StrikerMaster !</p>
            <?php if (isset($_SESSION['username'])): ?>
            <section class="user-status">
                <p>Bienvenue  
                    <?= htmlspecialchars($_SESSION['username']); ?>.
                </p>
            </section>
        <?php endif; ?>
        </section>

        <section class="features">
            <div class="feature">
            </div>
            <div class="feature">
            </div>
            <div class="feature">
            </div>
        </section>


    </main>

    <footer>
        <p>&copy; 2024 StrikerMaster. Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>
</body>

</html>
