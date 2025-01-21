<?php
session_start();

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

// Récupération des données des utilisateurs
try {
    $stmt = $pdo->prepare("
        SELECT username, victoire_match, victoire_gala, victoire_tournois
        FROM users
        ORDER BY (victoire_match + victoire_gala + victoire_tournois) DESC
    ");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement - StrikerMaster</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo StrikerMaster" width="100">
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
        <section class="ranking-container">
            <h2>Classement des joueurs</h2>

            <!-- Champ de recherche -->
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
                        $rank = 1;
                        foreach ($users as $user):
                            $totalVictories = $user['victoire_match'] + $user['victoire_gala'] + $user['victoire_tournois'];
                        ?>
                            <tr>
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
            var filter = this.value.toLowerCase();
            var rows = document.querySelectorAll('#rankingTable tbody tr');
            
            rows.forEach(function(row) {
                var cells = row.getElementsByTagName('td');
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
