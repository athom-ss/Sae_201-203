<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <title>Inscription</title>
</head>
<header>
    <div class="images-header">
        <a href="accueil.php" class="logo_univ">
            <img src="../images/logo_universite.png" alt="logo_header">
        </a>
    </div>
</header>
<body>
    <div class="conteneur-formulaire">
        <form action="inscription.php" method="POST">
            <label for="mail">Mail :</label>
            <input id="mail" type="text" name="mail" placeholder="Mail"><br><br>

            <label for="pseudo">Pseudo :</label>
            <input id="pseudo" type="text" name="pseudo" placeholder="Pseudo"><br><br>

            <label for="nom">Nom :</label>
            <input id="nom" type="text" name="nom" placeholder="Nom"><br><br>

            <label for="prenom">Prénom :</label>
            <input id="prenom" type="text" name="prenom" placeholder="Prénom"><br><br>

            <label for="num">Votre numéro de carte :</label>
            <input id="num" type="number" name="num" placeholder="Numéro professionnel"><br><br>

            <label for="naissance">Date de naissance :</label>
            <input id="naissance" type="date" name="naissance" placeholder="Date de naissance"><br><br>

            <label for="adresse">Adresse postale :</label>
            <input id="adresse" type="text" name="adresse" placeholder="Adresse postale"><br><br>

            <label for="role_personne">Rôle :</label> <br>
            <select id="role_personne" name="role_personne">
                <option value="Administrateur">Administrateur</option>
                <option value="Enseignant">Enseignant</option>
                <option value="Etudiant">Etudiant</option>
                <option value="Agent">Agent</option>
            </select>

            <br><br><label for="mdp">Mot de passe :</label> <br>
            <input id="mdp" type="password" name="mdp" placeholder="Mot de passe"><br><br>

            <button type="submit" class="btn-valider">Valider</button> <br> <br>
            <h5>Vous avez déjà un compte ?</h5> <br>
            <a href="../php/connexion.php">Connectez-vous</a>
        </form>
    </div>
    <br><br>
</body>
</html>

<?php
require_once "connexion_base.php"; // Inclusion de la connexion

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérification de l'existence des clés POST
    $mail = $_POST["mail"] ?? '';
    $pseudo = $_POST["pseudo"] ?? '';
    $nom = $_POST["nom"] ?? '';
    $prenom = $_POST["prenom"] ?? '';
    $num = $_POST["num"] ?? '';
    $annee_naissance = $_POST["naissance"] ?? '';
    $adresse = $_POST["adresse"] ?? '';
    $role_personne = $_POST["role_personne"] ?? '';
    $mdp = $_POST["mdp"] ?? '';

    try {
        $sql = "INSERT INTO inscription (mail, pseudo, nom, prenom, annee_naissance, adresse_postale, role_personne, mot_de_passe, num) 
                VALUES (:mail, :pseudo, :nom, :prenom, :annee_naissance, :adresse, :role_personne, :mdp, :num)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':mail' => $mail,
            ':pseudo' => $pseudo,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':num' => $num,
            ':annee_naissance' => $annee_naissance,
            ':adresse' => $adresse,
            ':role_personne' => $role_personne,
            ':mdp' => $mdp
        ]);
        echo "✅ Utilisateur ajouté avec succès !";
        header("Location: accueil.php");

        // PARTIE POUR GARDER LES INFORMATIONS POUR LA PAGE COMPTE
        //--------------------------------------------------------
        session_start();
        $erreur = '';
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
                    // Création de la session et récupération des informations saisies
                    $_SESSION['user'] = [
                        'id' => $utilisateur['id'], // Important pour compte.php
                        'mail' => $utilisateur['mail'],
                        'pseudo' => $utilisateur['pseudo'],
                        'role' => $utilisateur['role_personne'],
                        'prenom' => $utilisateur['prenom'], // Utile pour l'affichage
                        'num' => $utilisateur['num']
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
        //--------------------------------------------------------
        // FIN DE LA PARTIE POUR GARDER LES INFORMATIONS POUR LA PAGE COMPTE

    } catch (PDOException $e) {
        die("❌ Erreur lors de l'insertion : " . $e->getMessage());
    }
}
?>