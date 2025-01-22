<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
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

// Récupération de l'utilisateur connecté
$user_id = $_SESSION['user_id']; 
$user_role = $_SESSION['role']; // Le rôle doit être défini lors de la connexion

// Traitement de l'inscription à un événement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']);

    try {
        // Vérifie si l'utilisateur est déjà inscrit
        $checkStmt = $pdo->prepare("SELECT * FROM inscriptions WHERE user_id = :user_id AND event_id = :event_id");
        $checkStmt->execute(['user_id' => $user_id, 'event_id' => $event_id]);

        if ($checkStmt->fetch()) {
            $message = "<p class='error'>Vous êtes déjà inscrit à cet événement.</p>";
        } else {
            // Inscrire l'utilisateur à l'événement
            $stmt = $pdo->prepare("INSERT INTO inscriptions (user_id, event_id) VALUES (:user_id, :event_id)");
            $stmt->execute(['user_id' => $user_id, 'event_id' => $event_id]);
            $message = "<p class='success'>Inscription réussie à l'événement !</p>";
        }
    } catch (PDOException $e) {
        $message = "<p class='error'>Erreur lors de l'inscription : " . $e->getMessage() . "</p>";
    }
}

// Traitement de l'ajout d'un événement par un administrateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_event']) && $user_role === 'admin') {
    $nom_event = htmlspecialchars(trim($_POST['nom_event']));
    $type_event = htmlspecialchars(trim($_POST['type_event']));
    $date_event = htmlspecialchars(trim($_POST['date_event']));

    if (!empty($nom_event) && !empty($type_event) && !empty($date_event)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO calendrier (nom_event, type_event, date_event) VALUES (:nom_event, :type_event, :date_event)");
            $stmt->execute([
                'nom_event' => $nom_event,
                'type_event' => $type_event,
                'date_event' => $date_event
            ]);
            $message = "<p class='success'>Événement ajouté avec succès !</p>";
        } catch (PDOException $e) {
            $message = "<p class='error'>Erreur lors de l'ajout de l'événement : " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p class='error'>Tous les champs doivent être remplis.</p>";
    }
}

// Traitement de la suppression d'un événement par un administrateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event']) && isset($_POST['delete_event_id']) && $user_role === 'admin') {
    $event_id = intval($_POST['delete_event_id']);

    try {
        // Suppression de l'événement
        $stmt = $pdo->prepare("DELETE FROM calendrier WHERE id = :event_id");
        $stmt->execute(['event_id' => $event_id]);
        $message = "<p class='success'>Événement supprimé avec succès !</p>";
    } catch (PDOException $e) {
        $message = "<p class='error'>Erreur lors de la suppression de l'événement : " . $e->getMessage() . "</p>";
    }
}

// Récupère les événements de la table calendrier
try {
    $stmt = $pdo->query("SELECT id, nom_event, type_event, DATE_FORMAT(date_event, '%d/%m/%Y') AS date_event_formatted FROM calendrier ORDER BY date_event ASC");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des événements : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier des événements</title>
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
        <h2>Calendrier des événements</h2>

        <?= isset($message) ? $message : '' ?>

        <?php if ($user_role === 'admin'): ?>
            <section class="add-event">
                <h3>Ajouter un nouvel événement</h3>
                <form action="calendrier.php" method="POST">
                    <label for="nom_event">Nom de l'événement :</label>
                    <input type="text" name="nom_event" id="nom_event" required>

                    <label for="type_event">Type d'événement :</label>
                    <select name="type_event" id="type_event" required>
                        <option value="tournois">Tournois</option>
                        <option value="galas">Galas</option>
                        <option value="match">Match</option>
                    </select>

                    <label for="date_event">Date de l'événement :</label>
                    <input type="date" name="date_event" id="date_event" required>

                    <button type="submit" name="add_event">Ajouter l'événement</button>
                </form>
            </section>
        <?php endif; ?>

        <?php if (count($events) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom de l'événement</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['nom_event']); ?></td>
                            <td><?= htmlspecialchars($event['type_event']); ?></td>
                            <td><?= htmlspecialchars($event['date_event_formatted']); ?></td>
                            <td>
                                <form action="calendrier.php" method="POST">
                                    <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
                                    <button type="submit">S'inscrire</button>
                                </form>

                                <?php if ($user_role === 'admin'): ?>
                                    <form action="calendrier.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_event_id" value="<?= $event['id']; ?>">
                                        <button type="submit" name="delete_event">Supprimer</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun événement à afficher pour le moment.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 StrikerMaster. Tous droits réservés.</p>
    </footer>
</body>

</html>
