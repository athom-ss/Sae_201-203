<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];

    // Exemple de vérification simple
    if ($email === "etudiant@univ-eiffel.fr" && $mdp === "motdepasse") {
        $_SESSION["user"] = $email;
        header("Location: accueil.php");
        exit();
    } else {
        $message = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Université Gustave Eiffel</title>
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>"> <!--  POUR PAS DEVOIR REFAIRE UN CSS -->
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

        <?php if (!empty($message)) echo "<p class='error-message'>$message</p>"; ?>

        <input type="text" name="email" placeholder="Email :" required>
        <input type="password" name="mdp" placeholder="Mot de passe :" required>
        <button type="submit">Se connecter</button>

        <hr class="divider">

        <a href="#" class="register-link">Se créer un compte ?</a>
        <p class="small-text">Pour des raisons de sécurité, veuillez vous déconnecter et fermer votre navigateur lorsque vous avez fini d'accéder aux services authentifiés.</p>
    </form>
</div>

<footer class="footer">
    <div class="footer-column">
        <img src="../images/logo_univ_eiffel_blanc.png" 
        alt="Université Gustave Eiffel" class="logo-footer">
        <p>5 boulevard Descartes</p>
        <p>Champs-sur-Marne</p>
        <p>77454 Marne-la-Vallée cedex 2</p>
        <p>Téléphone : +33 1 60 95 75 00</p>
    </div>

    <div class="footer-column">
        <h4>Liens utiles</h4>
        <a href="#">Données personnelles</a>
        <a href="#">Accès aux document administratifs</a>
        <a href="#">Marchés publics</a>
        <a href="#">Mentions légales</a>
    </div>

    <div class="footer-column">
        <h4>Informations pratiques</h4>
        <a href="#">Annuair</a>
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
