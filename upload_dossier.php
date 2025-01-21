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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['dossier'])) {
    // Vérification si un fichier a été téléchargé
    if ($_FILES['dossier']['error'] == 0) {
        $dossierTemp = $_FILES['dossier']['tmp_name'];
        $dossierName = $_FILES['dossier']['name'];
        $dossierSize = $_FILES['dossier']['size'];

        // Extension du fichier
        $fileExtension = strtolower(pathinfo($dossierName, PATHINFO_EXTENSION));

        // Vérifier les types de fichiers autorisés
        $allowedExtensions = ['pdf', 'odt'];

        if (!in_array($fileExtension, $allowedExtensions)) {
            die("Seuls les fichiers PDF et ODT sont autorisés.");
        }

        // Dossier où le fichier sera téléchargé
        $uploadDir = 'uploads/dossiers/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Créer le dossier s'il n'existe pas
        }

        // Définir le chemin du fichier final
        $dossierPath = $uploadDir . basename($dossierName);

        // Déplacer le fichier vers le dossier final
        if (move_uploaded_file($dossierTemp, $dossierPath)) {
            // Mettre à jour la base de données avec le chemin du fichier
            $user_id = $_SESSION['user_id'];

            try {
                $stmt = $pdo->prepare("UPDATE users SET dossier = :dossier WHERE id = :user_id");
                $stmt->execute(['dossier' => $dossierPath, 'user_id' => $user_id]);

                // Rediriger après le succès
                header('Location: profil.php');
                exit();
            } catch (PDOException $e) {
                die("Erreur lors de la mise à jour du dossier : " . $e->getMessage());
            }
        } else {
            die("Erreur lors du téléchargement du fichier.");
        }
    } else {
        die("Le nom du fichier doit contenir: Dossier d'Inscription - Club StrikerMaster_USERNAME");
    }
}
?>
