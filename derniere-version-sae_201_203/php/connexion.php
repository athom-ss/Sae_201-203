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
    <link rel="stylesheet" href="../css/style_insc_connex.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_formulaire.css?v=<?= time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="header">
    <img src="../images/logo_univ_eiffel_blanc.png"
         alt="Université Gustave Eiffel" class="logo-header">
</header>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="d-flex justify-content-center">
            <div class="card shadow w-100" style="max-width: 500px;">
                <div class="card-header py-3" style="background-color: #BBEFF4; border-bottom: none; padding-bottom: 0.75rem;">
                    <div class="d-flex align-items-center">
                        <img src="../images/logo_univ_blanc.png" alt="logo" class="me-3" style="width: 38px; height: 38px;">
                        <span class="fw-bold fs-5" style="color: #222;">Service central d'authentification</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <?php if (!empty($erreur)) echo "<p class='error-message text-danger'>$erreur</p>"; ?>
                        <div class="mb-3">
                            <label for="mail_connexion" class="form-label">Email</label>
                            <input type="email" class="form-control" id="mail_connexion" name="mail_connexion" placeholder="Email :" required>
                        </div>
                        <div class="mb-4">
                            <label for="mdp" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe :" required>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg text-white">Se connecter</button>
                        </div>
                        <div class="text-center mt-4">
                            <a href="../php/inscription.php" class="btn btn-primary text-white">Se créer un compte ?</a>
                        </div>
                        <p class="small-text text-center mt-3">Pour des raisons de sécurité, veuillez vous déconnecter et fermer votre navigateur lorsque vous avez fini d'accéder aux services authentifiés.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
