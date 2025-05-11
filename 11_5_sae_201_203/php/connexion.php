<?php
session_start();
require_once "connexion_base.php";

$erreur = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mail = $_POST['mail_connexion'] ?? '';
    $mdp = $_POST['mdp'] ?? '';

    try {
        $sql = "SELECT * FROM inscription WHERE mail = :mail AND mot_de_passe = :mdp";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':mail' => $mail,
            ':mdp' => $mdp
        ]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur) {
            $_SESSION['user'] = [
                'id' => $utilisateur['id'],
                'mail' => $utilisateur['mail'],
                'pseudo' => $utilisateur['pseudo'],
                'role' => $utilisateur['role_personne'],
                'prenom' => $utilisateur['prenom'],
                'num' => $utilisateur['num'],
                ':statut' => $utilisateur['statut']
            ];

            if ($utilisateur['role_personne'] === 'Administrateur') {
                header("Location: accueil_admin.php");
            } else {
                header("Location: accueil.php");
            }
            exit;
        } else {
            $erreur = "❌ Mail ou mot de passe incorrect.";
        }

    } catch (PDOException $e) {
        $erreur = "❌ Erreur technique : veuillez réessayer plus tard.";
        error_log("Erreur connexion: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Université Gustave Eiffel</title>
    <link rel="stylesheet" href="../css/style_eth.css?v=<?= time(); ?>">
</head>
<body>

<header class="header">
    <img src="../images/logo_univ_eiffel_blanc.png"
         alt="Université Gustave Eiffel" class="logo-header">
</header>

<div class="login-wrapper">
    <form class="login-box" method="POST" action="">
        <div class="login-header">
            <img src="../images/logo_univ_blanc.png" alt="logo">
            <strong>Service central d’authentification</strong>
        </div>

        <?php if (!empty($erreur)) echo "<p class='error-message'>$erreur</p>"; ?>

        <input type="email" name="mail_connexion" placeholder="Email :" required>
        <input type="password" name="mdp" placeholder="Mot de passe :" required>
        <button type="submit">Se connecter</button>

        <hr class="divider">

        <a href="../php/inscription.php" class="register-link">Se créer un compte ?</a>
        <p class="small-text">Pour des raisons de sécurité, 
            veuillez vous déconnecter et fermer votre navigateur 
            lorsque vous avez fini d'accéder aux services authentifiés.</p>
    </form>
</div>

<footer class="footer">
    <div class="footer-column">
        <img src="../images/logo_univ_eiffel_blanc.png" alt="Université Gustave Eiffel" class="logo-footer">
        <p>5 boulevard Descartes</p>
        <p>Champs-sur-Marne</p>
        <p>77454 Marne-la-Vallée cedex 2</p>
        <p>Téléphone : +33 1 60 95 75 00</p>
    </div>

    <div class="footer-column">
        <h4>Liens utiles</h4>
        <a href="#">Données personnelles</a>
        <a href="#">Accès aux documents administratifs</a>
        <a href="#">Marchés publics</a>
        <a href="#">Mentions légales</a>
    </div>

    <div class="footer-column">
        <h4>Informations pratiques</h4>
        <a href="#">Annuaire</a>
        <a href="#">Plan d'accès</a>
        <a href="#">Espace presse</a>
        <a href="#">Restauration</a>
    </div>

    <div class="footer-column">
        <h4>Réseaux sociaux</h4>
        <a href="#"><img src="../images/logo_instagram.png" alt="Instagram"></a>
        <a href="#"><img src="../images/logo_linkedin.png" alt="Linkedin"></a>
        <a href="#"><img src="../images/logo_facebook.png" alt="Facebook"></a>
        <a href="#"><img src="../images/logo_youtube.png" alt="Youtube"></a>
        <a href="#"><img src="../images/logo_bluesky.png" alt="Bluesky"></a>
    </div>
</footer>

<div class="footer-bottom">
    <div class="footer-bottom-links">
        <a href="#">Mentions légales</a>
        <span>|</span>
        <a href="#">Politique cookies</a>
        <span>|</span>
        <a href="#">Contact</a>
    </div>
</div>

</body>
</html>
