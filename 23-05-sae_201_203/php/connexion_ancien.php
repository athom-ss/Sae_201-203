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
                'num' => $utilisateur['num']
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <title>Connexion</title>
</head>

<header>
    <div class="images-header">
        <a href="accueil.php" class="logo_univ">
            <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
        </a>
    </div>
</header>
<body>
    <br><br>
    <div class="conteneur-formulaire">
        <form action="connexion.php" method="POST">

            <?php if ($erreur): ?>
                <p style="color: red;"><?= htmlspecialchars($erreur) ?></p>
            <?php endif; ?>

            <label for="mail_connexion">Mail Universitaire :</label>
            <input id="mail_connexion" type="text" name="mail_connexion" placeholder="Mail Universitaire" required><br><br>

            <label for="mdp">Mot de passe :</label><br>
            <input id="mdp" type="password" name="mdp" placeholder="Mot de passe" required><br><br>

            <button type="submit" class="btn-valider">Valider</button><br><br>
            <h5>Vous n'avez pas encore de compte ?</h5><br>
            <a href="../php/inscription.php">Inscrivez-vous</a>
        </form>
    </div>
</body>
</html>
