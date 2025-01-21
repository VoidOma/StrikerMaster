<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

// Configuration de la base de données
$host = '127.0.0.1';
$dbname = 'strikermaster';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// ID de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Récupération des événements auxquels l'utilisateur est inscrit
try {
    $stmt = $pdo->prepare("
        SELECT c.nom_event, c.type_event, DATE_FORMAT(c.date_event, '%d/%m/%Y') AS date_event_formatted 
        FROM inscriptions i
        JOIN calendrier c ON i.event_id = c.id
        WHERE i.user_id = :user_id
        ORDER BY c.date_event ASC
    ");
    $stmt->execute(['user_id' => $user_id]);
    $userEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des événements : " . $e->getMessage());
}

// Récupération du nombre de victoires depuis la table `users`
try {
    $stmtVictories = $pdo->prepare("
        SELECT victoire_match, victoire_gala, victoire_tournois
        FROM users
        WHERE id = :user_id
    ");
    $stmtVictories->execute(['user_id' => $user_id]);
    $victories = $stmtVictories->fetch(PDO::FETCH_ASSOC);

    $matchVictories = $victories['victoire_match'];
    $galaVictories = $victories['victoire_gala'];
    $tournoiVictories = $victories['victoire_tournois'];
} catch (PDOException $e) {
    die("Erreur lors de la récupération des victoires : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - StrikerMaster</title>
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
        <section class="profile-container">
            <h2>Bienvenue, <?= htmlspecialchars($_SESSION['username']); ?> !</h2>

            <div class="profile-details">
                <div class="profile-info">
                    <h3>Informations de votre profil :</h3>
                    <img 
                        src="<?= isset($_SESSION['profile_photo']) ? htmlspecialchars($_SESSION['profile_photo']) : 'default_profile.png'; ?>" 
                        alt="Photo de profil" 
                        class="profile-photo"
                    >
                    <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($_SESSION['username']); ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($_SESSION['email']); ?></p>
                    <p><strong>Rôle :</strong> <?= htmlspecialchars($_SESSION['role'] === 'admin' ? 'Administrateur' : 'Membre'); ?></p>
                    
                    <!-- Lien vers la page de modification des scores pour les admins -->
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <p><a href="modification_score.php">Accéder à la gestion des scores</a></p>
                    <?php endif; ?>
                </div>

                <!-- Section de téléchargement du dossier d'inscription -->
                <section class="download-section">
                    <h3>Télécharger le dossier d'inscription :</h3>
                    <p><a href="Dossier d'Inscription - Club StrikerMaster" download>Dossier_d'Inscription-Club StrikerMaster</a></p>
                </section>
                <section class="upload-dossier">
                    <h3>Déposer votre dossier d'inscription :</h3>
                    <form action="upload_dossier.php" method="POST" enctype="multipart/form-data">
                        <label for="dossier-upload">Choisir un fichier :</label>
                        <input type="file" name="dossier" id="dossier-upload" accept=".pdf, .odt" required>
                        <button type="submit" name="upload_dossier">Télécharger</button>
                    </form>
                </section>
            </div>

            <div class="upload-section">
                <h3>Déposer une photo de profil :</h3>
                <form action="upload_photo.php" method="POST" enctype="multipart/form-data">
                    <label for="photo-upload">Choisir une photo :</label>
                    <input type="file" name="profile_photo" id="photo-upload" accept="image/*" required>
                    <button type="submit" name="upload_photo">Télécharger</button>
                </form>
            </div>
        </section>
        <section class="user-victories">
            <h3>Vos victoires :</h3>
            <div class="victory-counters">
                <div class="victory-counter">
                    <h4>Matchs</h4>
                    <p><strong><?= $matchVictories; ?></strong> victoire(s)</p>
                </div>
                <div class="victory-counter">
                    <h4>Galas</h4>
                    <p><strong><?= $galaVictories; ?></strong> victoire(s)</p>
                </div>
                <div class="victory-counter">
                    <h4>Tournois</h4>
                    <p><strong><?= $tournoiVictories; ?></strong> victoire(s)</p>
                </div>
            </div>
        </section>

        <section class="user-events">
            <h3>Événements auxquels vous êtes inscrit :</h3>

            <?php if (count($userEvents) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom de l'événement</th>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userEvents as $event): ?>
                            <tr>
                                <td><?= htmlspecialchars($event['nom_event']); ?></td>
                                <td><?= htmlspecialchars($event['type_event']); ?></td>
                                <td><?= htmlspecialchars($event['date_event_formatted']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Vous n'êtes inscrit à aucun événement pour le moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 StrikerMaster. Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>
</body>

</html>
