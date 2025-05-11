<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_eth.css?v=<?= time(); ?>">
    <title>Inscription - Université Gustave Eiffel</title>
</head>
<body>

<header class="header">
    <img src="../images/logo_univ_eiffel_blanc.png"
         alt="Université Gustave Eiffel" class="logo-header">
</header>
<br><br><br><br><br>
<div class="login-wrapper">
    <form class="login-box" action="inscription.php" method="POST">
        <div class="login-header">
            <img src="../images/logo_univ_blanc.png" alt="logo" class="logo-header">
            <strong>Formulaire d'inscription</strong>
        </div>
        <input id="mail" type="email" name="mail" placeholder="Mail" required><br><br>

        <input id="pseudo" type="text" name="pseudo" placeholder="Pseudo" required><br><br>

        <input id="nom" type="text" name="nom" placeholder="Nom" required><br><br>

        <input id="prenom" type="text" name="prenom" placeholder="Prénom" required><br><br>

        <input id="num" type="number" name="num" placeholder="Numéro professionnel" required><br><br>

        <input id="naissance" type="date" name="naissance" required><br><br>

        <input id="adresse" type="text" name="adresse" placeholder="Adresse postale" required><br><br>

        <select id="role_personne" name="role_personne" required>
            <option value="Administrateur">Administrateur</option>
            <option value="Enseignant">Enseignant</option>
            <option value="Etudiant">Etudiant</option>
            <option value="Agent">Agent</option>
        </select><br><br>

        <input id="mdp" type="password" name="mdp" placeholder="Mot de passe" required><br><br>
        <button type="submit" class="btn-valider">Valider</button><br><br>

        <h5>Vous avez déjà un compte ?</h5><br>
        <a href="../php/connexion.php" class="register-link">Connectez-vous</a>
    </form>
</div>
<br><br><br><br><br>

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

<?php
require_once "connexion_base.php"; // Connexion à la base

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $mail = $_POST["mail"] ?? '';
    $pseudo = $_POST["pseudo"] ?? '';
    $nom = $_POST["nom"] ?? '';
    $prenom = $_POST["prenom"] ?? '';
    $num = $_POST["num"] ?? '';
    $annee_naissance = $_POST["naissance"] ?? '';
    $adresse = $_POST["adresse"] ?? '';
    $role_personne = $_POST["role_personne"] ?? '';
    $mdp = $_POST["mdp"] ?? '';
    $statut = ($role_personne !== 'Administrateur') ? 'attente' : ''; // 'attente' si le rôle est différent de 'Administrateur', sinon reste vide


    try {
        // Insertion dans la base de données
        $sql = "INSERT INTO inscription (mail, pseudo, nom, prenom, annee_naissance, adresse_postale, role_personne, mot_de_passe, num, statut) 
                VALUES (:mail, :pseudo, :nom, :prenom, :annee_naissance, :adresse, :role_personne, :mdp, :num, :statut)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':mail' => $mail,
            ':pseudo' => $pseudo,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':annee_naissance' => $annee_naissance,
            ':adresse' => $adresse,
            ':role_personne' => $role_personne,
            ':mdp' => $mdp,
            ':num' => $num,
            ':statut' => $statut
        ]);

        // Récupération de l'utilisateur après insertion
        $stmt = $pdo->prepare("SELECT * FROM inscription WHERE mail = :mail");
        $stmt->execute([':mail' => $mail]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && $utilisateur['mot_de_passe'] === $mdp) {
            // Création de la session
            $_SESSION['user'] = [
                'id' => $utilisateur['id'],
                'mail' => $utilisateur['mail'],
                'pseudo' => $utilisateur['pseudo'],
                'role' => $utilisateur['role_personne'],
                'prenom' => $utilisateur['prenom'],
                'num' => $utilisateur['num']
            ];

            // Redirection selon le rôle
            if ($utilisateur['role_personne'] === 'Administrateur') {
                header("Location: accueil_admin.php");
            } else {
                header("Location: accueil.php");
            }
            exit;
        } else {
            echo "❌ Une erreur est survenue lors de la connexion automatique.";
        }

    } catch (PDOException $e) {
        die("❌ Erreur lors de l'inscription : " . $e->getMessage());
    }
}
?>
