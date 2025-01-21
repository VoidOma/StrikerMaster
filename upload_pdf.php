<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

if (isset($_POST['upload'])) {
    $target_dir = "uploads/"; // Le répertoire où les fichiers seront stockés
    $target_file = $target_dir . basename($_FILES["pdf_file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier si le fichier est un PDF
    if ($fileType != "pdf") {
        echo "Désolé, seul les fichiers PDF sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifier si le fichier existe déjà
    if (file_exists($target_file)) {
        echo "Désolé, ce fichier existe déjà.";
        $uploadOk = 0;
    }

    // Vérifier la taille du fichier (limite à 5MB)
    if ($_FILES["pdf_file"]["size"] > 5000000) {
        echo "Désolé, votre fichier est trop grand.";
        $uploadOk = 0;
    }

    // Vérifier si tout est ok pour uploader
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
            echo "Le fichier ". htmlspecialchars(basename($_FILES["pdf_file"]["name"])) . " a été téléchargé.";
        } else {
            echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
        }
    }
}
?>
