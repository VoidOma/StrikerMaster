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

    <div class="about-container">
        <h1>À propos de StrikeMaster</h1>

        <section class="history">
            <h2>Notre histoire</h2>
            <p>
                L'association StrikeMaster a été fondée en 2023 avec pour objectif principal de promouvoir le bowling auprès de tous les publics. 
                Depuis ses débuts, elle s'est agrandie et compte aujourd'hui 342 membres passionnés.
            </p>
            <p>
                De petits tournois entre amis aux grandes compétitions locales, notre association a toujours su mettre en avant les valeurs de convivialité, 
                de respect et de passion pour ce sport si captivant.
            </p>
        </section>

        <section class="milestones">
            <h2>Événements marquants</h2>
            <ul>
                <li><strong>2023</strong> : Organisation du premier tournoi régional, avec plus de 150 participants.</li>
                <li><strong>2024</strong> : Inauguration de notre propre salle de bowling pour les entraînements et compétitions.</li>
                <li><strong>2025</strong> : Lancement de notre site web pour faciliter la gestion des compétitions et inscriptions.</li>
            </ul>
        </section>

        <section class="mission">
            <h2>Notre mission</h2>
            <p>
                StrikeMaster a pour mission de rassembler les amateurs de bowling de tous horizons et de tous niveaux. Nous souhaitons créer une 
                communauté où chacun peut partager sa passion, progresser, et participer à des événements stimulants. Nos objectifs incluent :
            </p>
            <ul>
                <li>Promouvoir le bowling comme une activité sportive et ludique accessible à tous.</li>
                <li>Offrir un cadre professionnel pour les compétitions et les entraînements.</li>
                <li>Soutenir les jeunes talents en les accompagnant dans leur progression.</li>
            </ul>
        </section>

        <section class="contact">
            <h2>Contactez-nous</h2>
            <p>
                Vous souhaitez en savoir plus sur StrikeMaster, nos tournois, ou devenir membre de notre association ? 
                N'hésitez pas à <a href="contact.php">nous contacter</a> ou à venir nous rendre visite lors de nos prochains événements !
            </p>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 StrikerMaster. Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>
</body>

</html>
