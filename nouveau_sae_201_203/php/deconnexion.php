<?php
session_start();

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion (ou autre page d’accueil)
header("Location: connexion.php");
exit;
?>
