<?php
session_start();

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
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

// Récupérer tous les utilisateurs et leurs victoires
try {
    $stmt = $pdo->query("SELECT id, username, victoire_gala, victoire_tournois, victoire_match FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
}

// Si le formulaire de modification est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['event_type'], $_POST['increment'], $_POST['operation'])) {
    $userId = $_POST['user_id'];
    $eventType = $_POST['event_type'];
    $increment = (int)$_POST['increment'];
    $operation = $_POST['operation'];

    // Vérifier si l'opération est d'incrémenter ou de décrémenter
    if ($operation === 'decrement') {
        $increment = -$increment;  // Changer l'incrémentation en une décrémentation
    }

    // Mettre à jour le nombre de victoires en fonction du type d'événement
    try {
        if ($eventType === 'match') {
            $stmt = $pdo->prepare("UPDATE users SET victoire_match = victoire_match + :increment WHERE id = :user_id");
        } elseif ($eventType === 'gala') {
            $stmt = $pdo->prepare("UPDATE users SET victoire_gala = victoire_gala + :increment WHERE id = :user_id");
        } elseif ($eventType === 'tournoi') {
            $stmt = $pdo->prepare("UPDATE users SET victoire_tournois = victoire_tournois + :increment WHERE id = :user_id");
        }

        $stmt->execute(['increment' => $increment, 'user_id' => $userId]);

        // Rediriger après la mise à jour
        header('Location: modification_score.php?success=1');
        exit();
    } catch (PDOException $e) {
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
                <p class="success-message">Le score a été mis à jour avec succès !</p>
            <?php endif; ?>

            <form action="modification_score.php" method="POST">
                <label for="user_id">Choisir un utilisateur :</label>
                <select name="user_id" id="user_id" required>
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
