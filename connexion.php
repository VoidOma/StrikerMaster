<?php
// Configuration de la base de données
$host = '127.0.0.1';
$dbname = 'strikermaster';
$username = 'root';
$password = '';

session_start();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Initialisation du message
$message = '';

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $user = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    // Vérifier que tous les champs sont remplis
    if (empty($user) || empty($email) || empty($pass)) {
        $message = "<p class='error'>Tous les champs doivent être remplis !</p>";
    } else {
        // Vérification de l'existence de l'utilisateur ou de l'email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $user, 'email' => $email]);
        if ($stmt->fetch()) {
            $message = "<p class='error'>Le nom d'utilisateur ou l'email est déjà utilisé.</p>";
        } else {
            // Hachage du mot de passe
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

            // Insertion dans la base de données
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
            $result = $stmt->execute(['username' => $user, 'password' => $hashedPassword, 'email' => $email]);

            $message = $result
                ? "<p class='success'>Inscription réussie ! Vous pouvez maintenant vous connecter.</p>"
                : "<p class='error'>Une erreur s'est produite lors de l'inscription.</p>";
        }
    }
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    if (empty($user) || empty($pass)) {
        $message = "<p class='error'>Tous les champs doivent être remplis !</p>";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $user]);
        $userData = $stmt->fetch();

        if ($userData) {
            // Vérification du mot de passe haché
            if (password_verify($pass, $userData['password'])) {
                $_SESSION['username'] = $userData['username'];
                $_SESSION['email'] = $userData['email']; 
                $_SESSION['role'] = $userData['role'] ?? 'membre';
                $_SESSION['user_id'] = $userData['id'];
                header('Location: index.php');
                exit();
            } else {
                $message = "<p class='error'>Mot de passe incorrect.</p>";
            }
        } else {
            $message = "<p class='error'>Nom d'utilisateur incorrect.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion ou Inscription</title>
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
        <section class="form-section">
            <h2>Connexion ou Inscription</h2>

            <?= isset($message) ? $message : '' ?>

            <!-- Formulaire de connexion -->
            <form action="connexion.php" method="POST" class="login-form">
                <h3>Se connecter</h3>
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" placeholder="Votre nom d'utilisateur" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>

                <button type="submit" name="login">Se connecter</button>
            </form>

            <!-- Formulaire d'inscription -->
            <form action="connexion.php" method="POST" class="register-form">
                <h3>S'inscrire</h3>
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" placeholder="Choisissez un nom" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Choisissez un mot de passe" required>

                <button type="submit" name="register">S'inscrire</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 StrikerMaster. Tous droits réservés.</p>
        <p><a href="partenaire.php">Nos Partenaires</a></p>
    </footer>
</body>

</html>
