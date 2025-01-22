<?php
session_start();

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas administrateur
    header('Location: connexion.php');
    exit();
}

// Configuration de la base de données
$host = '127.0.0.1';
$dbname = 'strikermaster';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Définir l'attribut pour gérer les erreurs
} catch (PDOException $e) {
    // En cas d'erreur de connexion, afficher le message d'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer tous les utilisateurs et leurs victoires
try {
    // Préparer la requête pour obtenir les informations des utilisateurs
    $stmt = $pdo->query("SELECT id, username, victoire_gala, victoire_tournois, victoire_match FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Exécuter la requête et récupérer les résultats sous forme de tableau associatif
} catch (PDOException $e) {
    // En cas d'erreur de récupération des utilisateurs, afficher le message d'erreur
    die("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
}

// Si le formulaire de modification est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['event_type'], $_POST['increment'], $_POST['operation'])) {
    $userId = $_POST['user_id']; // ID de l'utilisateur à modifier
    $eventType = $_POST['event_type']; // Type d'événement (match, gala, tournoi)
    $increment = (int)$_POST['increment']; // Nombre de victoires à ajouter ou à retirer
    $operation = $_POST['operation']; // L'opération à effectuer (incrémenter ou décrémenter)

    // Vérifier si l'opération est de décrémenter
    if ($operation === 'decrement') {
        $increment = -$increment;  // Si l'opération est "décrémenter", on rend l'incrémentation négative
    }

    // Mettre à jour le nombre de victoires en fonction du type d'événement
    try {
        if ($eventType === 'match') {
            // Mettre à jour les victoires en match
            $stmt = $pdo->prepare("UPDATE users SET victoire_match = victoire_match + :increment WHERE id = :user_id");
        } elseif ($eventType === 'gala') {
            // Mettre à jour les victoires en gala
            $stmt = $pdo->prepare("UPDATE users SET victoire_gala = victoire_gala + :increment WHERE id = :user_id");
        } elseif ($eventType === 'tournoi') {
            // Mettre à jour les victoires en tournoi
            $stmt = $pdo->prepare("UPDATE users SET victoire_tournois = victoire_tournois + :increment WHERE id = :user_id");
        }

        // Exécuter la mise à jour avec les paramètres
        $stmt->execute(['increment' => $increment, 'user_id' => $userId]);

        // Rediriger après la mise à jour réussie
        header('Location: modification_score.php?success=1');
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur lors de la mise à jour, afficher le message d'erreur
        die("Erreur lors de la mise à jour des victoires : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification des scores - StrikerMaster</title>
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
                <li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="deconnexion.php">Déconnexion</a>
                    <?php else: ?>
                        <a href="connexion.php">Connexion</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="score-modification-container">
            <h2>Modification des scores</h2>

            <?php if (isset($_GET['success'])): ?>
                <!-- Afficher un message de succès si la mise à jour a réussi -->
                <p class="success-message">Le score a été mis à jour avec succès !</p>
            <?php endif; ?>

            <!-- Formulaire pour modifier les scores -->
            <form action="modification_score.php" method="POST">
                <label for="user_id">Choisir un utilisateur :</label>
                <select name="user_id" id="user_id" required>
                    <!-- Liste des utilisateurs avec leurs scores actuels -->
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id']; ?>">
                            <?= htmlspecialchars($user['username']); ?> - 
                            Galas: <?= $user['victoire_gala']; ?>, 
                            Tournois: <?= $user['victoire_tournois']; ?>, 
                            Matchs: <?= $user['victoire_match']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="event_type">Type d'événement :</label>
                <select name="event_type" id="event_type" required>
                    <option value="match">Match</option>
                    <option value="gala">Gala</option>
                    <option value="tournoi">Tournoi</option>
                </select>

                <label for="operation">Choisir l'opération :</label>
                <select name="operation" id="operation" required>
                    <option value="increment">Incrémenter</option>
                    <option value="decrement">Décrémenter</option>
                </select>

                <label for="increment">Nombre de victoires à ajouter ou à retirer :</label>
                <input type="number" name="increment" id="increment" value="1" min="1" required>

                <button type="submit">Mettre à jour</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 StrikerMaster. Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>
</body>

</html>
