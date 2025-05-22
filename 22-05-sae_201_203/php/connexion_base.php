<?php
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "";
$baseDeDonnees = "sql_sae_201_203";

try {
    // Connexion à MySQL avec PDO
    $pdo = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees;charset=utf8", $utilisateur, $motDePasse);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Connexion réussie à la base de données. A ENLEVER DANS DOC CONNEXION_BASE.PHP";
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}
?>
