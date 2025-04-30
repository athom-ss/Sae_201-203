<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>"> <!--  POUR PAS DEVOIR REFAIRE UN CSS -->
    <title>Connexion</title>
</head>

<header>
    <div class="images-header">
        <a href="accueil.php" class="logo_univ">
            <img src="../images/logo_universite.png" alt="logo_header">
        </a>
    </div>
</header>
<body>
    <br><br><br><br>
    <div class="conteneur-formulaire">
        <form action="connexion.php" method="POST">

            <label for="mail_connexion">Mail Universitaire :</label>
            <input id="mail_connexion" type="text" name="mail_connexion" placeholder="Mail Universitaire"><br><br>

            <label for="mdp">Mot de passe :</label> <br>
            <input id="mdp" type="password" name="mdp" placeholder="Mot de passe"><br><br>

            <button type="submit" class="btn-valider">Valider</button> <br> <br>
            <h5>Vous n'avez pas encore de compte ?</h5> <br>
            <a href="../php/inscription.php">Inscrivez-vous</a>
        </form>
    </div>
</body>
</html>

<?php
require_once "connexion_base.php"; // Connexion à la base

// Initialisation de la session et des variables
session_start();
$erreur = '';

// Si l'utilisateur est déjà connecté, redirection vers l'accueil
if (isset($_SESSION['user'])) {
    header("Location: accueil.php");
    exit;
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Nettoyage des inputs
    $mail = trim($_POST["mail_connexion"] ?? '');
    $mdp = $_POST["mdp"] ?? '';

    // Validation des champs
    if (empty($mail) || empty($mdp)) {
        $erreur = "❌ Veuillez remplir tous les champs.";
    } else {
        try {
            // Recherche de l'utilisateur
            $sql = "SELECT * FROM inscription WHERE mail = :mail";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':mail' => $mail]);
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification des identifiants
            if ($utilisateur) {
                // Comparaison directe du mot de passe (à remplacer par password_verify si vous hashiez les mdp)
                if ($utilisateur['mot_de_passe'] === $mdp) {
                    // Création de la session
                    $_SESSION['user'] = [
                        'id' => $utilisateur['id'], // Important pour compte.php
                        'mail' => $utilisateur['mail'],
                        'pseudo' => $utilisateur['pseudo'],
                        'role' => $utilisateur['role_personne'],
                        'prenom' => $utilisateur['prenom'] // Utile pour l'affichage
                    ];
                    
                    // Redirection vers l'accueil
                    header("Location: accueil.php");
                    exit;
                } else {
                    $erreur = "❌ Mot de passe incorrect.";
                }
            } else {
                $erreur = "❌ Aucun compte trouvé avec cet email.";
            }
            
        } catch (PDOException $e) {
            $erreur = "❌ Erreur technique : Veuillez réessayer plus tard.";
            error_log("Erreur connexion: " . $e->getMessage()); // Log pour le débogage
        }
    }
}
?>