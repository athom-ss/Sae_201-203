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
    $statut = ($role_personne !== 'Administrateur') ? 'attente' : '';

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
            } elseif ($utilisateur['role_personne'] === 'Agent') {
                header("Location: acceuil_agent.php");
            } else {
                header("Location: accueil.php");
            }
            exit;
        } else {
            $erreur = "❌ Une erreur est survenue lors de la connexion automatique.";
        }

    } catch (PDOException $e) {
        $erreur = "❌ Erreur lors de l'inscription : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style_insc_connex.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_formulaire.css?v=<?= time(); ?>">
    
    <title>Inscription - Université Gustave Eiffel</title>
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
                    <?php if (!empty($erreur)) echo "<p class='error-message text-danger'>$erreur</p>"; ?>
                    <form action="inscription.php" method="POST">
                        <div class="mb-3">
                            <label for="mail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="mail" name="mail" placeholder="Email :" required>
                        </div>
                        <div class="mb-3">
                            <label for="pseudo" class="form-label">Pseudo</label>
                            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo :" required>
                        </div>
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom :" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom :" required>
                        </div>
                        <div class="mb-3">
                            <label for="num" class="form-label">Numéro professionnel</label>
                            <input type="number" class="form-control" id="num" name="num" placeholder="Numéro professionnel :" required>
                        </div>
                        <div class="mb-3">
                            <label for="naissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="naissance" name="naissance" required>
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse postale</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse postale :" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_personne" class="form-label">Rôle</label>
                            <select class="form-select" id="role_personne" name="role_personne" required>
                                <option value="">Sélectionnez un rôle</option>
                                <option value="Administrateur">Administrateur</option>
                                <option value="Enseignant">Enseignant</option>
                                <option value="Etudiant">Etudiant</option>
                                <option value="Agent">Agent</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="mdp" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe :" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg text-white">Valider</button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-2">Vous avez déjà un compte ?</p>
                            <a href="../php/connexion.php" class="btn btn-primary text-white">Connectez-vous</a>
                        </div>
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

<!-- Bootstrap JS et Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
