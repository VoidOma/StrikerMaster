<?php
// Démarrage de la session pour gérer les informations utilisateur
session_start();

// Configuration des paramètres de connexion à la base de données
$host = '127.0.0.1'; // Adresse du serveur de base de données
$dbname = 'strikermaster'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur de la base de données
$password = ''; // Mot de passe pour la base de données

// Connexion à la base de données avec gestion des erreurs
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activation des exceptions pour les erreurs PDO
} catch (PDOException $e) {
    // Arrête l'exécution en cas d'erreur de connexion et affiche un message d'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupération des données des utilisateurs depuis la base de données
try {
    $stmt = $pdo->prepare("
        SELECT username, victoire_match, victoire_gala, victoire_tournois
        FROM users
        ORDER BY (victoire_match + victoire_gala + victoire_tournois) DESC
    ");
    $stmt->execute(); // Exécution de la requête SQL
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupération des résultats sous forme de tableau associatif
} catch (PDOException $e) {
    // Arrête l'exécution en cas d'erreur de requête SQL et affiche un message d'erreur
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Métadonnées et lien vers la feuille de style -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement - StrikerMaster</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- En-tête contenant le logo et la navigation -->
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo StrikerMaster" width="100">
            <h1>StrikerMaster</h1>
        </div>
        <nav>
            <ul>
                <!-- Liens de navigation -->
                <li><a href="index.php">Accueil</a></li>
                <li><a href="about.php">À propos</a></li>
                <li><a href="events.php">Événements</a></li>
                <li><a href="classement.php">Classement</a></li>
                <li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- Affiche 'Profil' et 'Déconnexion' si l'utilisateur est connecté -->
                        <a href="profile.php">Profil</a>
                        <a href="deconnexion.php">Déconnexion</a>
                    <?php else: ?>
                        <!-- Sinon affiche 'Connexion' -->
                        <a href="connexion.php">Connexion</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="ranking-container">
            <h2>Classement des joueurs</h2>

            <!-- Champ de recherche pour filtrer le tableau -->
            <input type="text" id="searchInput" placeholder="Rechercher un joueur...">

            <?php if (count($users) > 0): ?>
                <table id="rankingTable">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Nom d'utilisateur</th>
                            <th>Victoires (Matchs)</th>
                            <th>Victoires (Galas)</th>
                            <th>Victoires (Tournois)</th>
                            <th>Total des Victoires</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rank = 1; // Initialisation du rang des joueurs
                        foreach ($users as $user):
                            $totalVictories = $user['victoire_match'] + $user['victoire_gala'] + $user['victoire_tournois'];
                        ?>
                            <tr>
                                <!-- Affichage des informations utilisateur -->
                                <td><?= $rank++; ?></td>
                                <td><?= htmlspecialchars($user['username']); ?></td>
                                <td><?= htmlspecialchars($user['victoire_match']); ?></td>
                                <td><?= htmlspecialchars($user['victoire_gala']); ?></td>
                                <td><?= htmlspecialchars($user['victoire_tournois']); ?></td>
                                <td><strong><?= $totalVictories; ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <!-- Message si aucun utilisateur n'est trouvé -->
                <p>Aucun utilisateur trouvé.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 StrikerMaster. Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>

    <script>
        // Fonction de recherche dans le tableau
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var filter = this.value.toLowerCase(); // Texte saisi en minuscule
            var rows = document.querySelectorAll('#rankingTable tbody tr'); // Sélection des lignes du tableau
            
            rows.forEach(function(row) {
                var cells = row.getElementsByTagName('td'); // Cellules de chaque ligne
                var matchFound = false;

                // Vérifie chaque cellule du tableau
                for (var i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().indexOf(filter) > -1) {
                        matchFound = true;
                        break;
                    }
                }

                // Affiche ou masque la ligne en fonction du filtre
                row.style.display = matchFound ? '' : 'none';
            });
        });
    </script>

</body>

</html>
