<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

// Vérification si un fichier a été soumis
if (isset($_POST['upload_photo']) && isset($_FILES['profile_photo'])) {
    $target_dir = "uploads/profile_photos/";
    $username = $_SESSION['username'];
    $file = $_FILES['profile_photo'];

    // Vérifier les erreurs d'upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Vérification de l'extension
        if (in_array($file_extension, $allowed_extensions)) {
            // Générer un nom unique pour le fichier
            $file_name = $username . '.' . $file_extension;
            $target_file = $target_dir . $file_name;

            // Déplacer le fichier dans le répertoire cible
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                // Sauvegarder le chemin de la photo dans la base de données
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=strikermaster', 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $pdo->prepare("UPDATE users SET profile_photo = :profile_photo WHERE username = :username");
                    $stmt->execute([
                        ':profile_photo' => $target_file,
                        ':username' => $username,
                    ]);

                    $_SESSION['profile_photo'] = $target_file;
                    header('Location: profil.php?upload_success=1');
                    exit();
                } catch (PDOException $e) {
                    die("Erreur : " . $e->getMessage());
                }
            } else {
                die("Erreur lors du téléchargement de la photo.");
            }
        } else {
            die("Extension non autorisée. Seuls les fichiers JPG, PNG et GIF sont acceptés.");
        }
    } else {
        die("Erreur lors de l'upload : " . $file['error']);
    }
} else {
    header('Location: profil.php');
    exit();
}
