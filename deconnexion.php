<?php
// Démarre la session
session_start();

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil après la déconnexion
header('Location: index.php');
exit();
?>
