<?php
session_start();

// Supprimer toutes les infos de session
$_SESSION = [];

// Détruire la session
session_destroy();

header("Location: ../connexion.php");
exit;
?>
