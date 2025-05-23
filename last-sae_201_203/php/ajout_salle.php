<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">  <!--  POUR PAS DEVOIR REFAIRE UN CSS -->
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_formulaire.css?v=<?= time(); ?>">
    <title>Ajout de salle</title>
</head>
<body>
    <header>
      <div class="images-header">
        <a href="accueil_admin.php" class="logo_univ">
          <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
        </a>
        <a href="compte_admin.php" class="img_compte">
          <img src="../images/compte.png" alt="mon_compte">
        </a>
      </div>
    </header>
    <nav class="navbar">
      <a href="ajout_materiel.php">Ajout de matériel</a>
      <a href="ajout_salle.php">Ajout de salle</a>
      <a href="eleves_attente.php">Gestion des élèves</a>
      <a href="statistiques.php">Statistiques</a>
    </nav>
    <div class="conteneur-formulaire">
        <form action="ajout_salle.php" method="POST">
            <h1>Ajout de salle</h1><br>
            <input id="nom_salle" type="text" name="nom_salle" placeholder="Nom de la salle"><br><br>

            <select id="type_salle" name="type_salle">
                <option value="Salle de classe">Salle de classe</option>
                <option value="Salle informatique">Salle informatique</option>
                <option value="Salle gaming">Salle gaming</option>
                <option value="Salle de repos">Salle de repos</option>
            </select>
            <br><br><button type="submit" class="btn-valider">Valider</button> <br>
        </form>
    </div>

    <footer>
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
        <a href="https://www.instagram.com/universitegustaveeiffel/" target="_blank"><img src="../images/logo_instagram.png" alt="Instagram"></a>
        <a href="https://www.linkedin.com/school/universit%C3%A9-gustave-eiffel/posts/?feedView=all" target="_blank"><img src="../images/logo_linkedin.png" alt="Linkedin"></a>
        <a href="https://www.facebook.com/UniversiteGustaveEiffel/" target="_blank"><img src="../images/logo_facebook.png" alt="Facebook"></a>
        <a href="https://www.youtube.com/channel/UCNMF04xs6lEAeFZ8TO6s2dw" target="_blank"><img src="../images/logo_youtube.png" alt="Youtube"></a>
        <a href="https://x.com/UGustaveEiffel" target="_blank"><img src="../images/twitter.png" alt="Twitter"></a>
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
    </footer>

</body>
</html>

<?php
require_once "connexion_base.php"; // Inclusion de la connexion

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérification de l'existence des clés POST
    $nom_salle = $_POST["nom_salle"] ?? '';
    $type_salle = $_POST["type_salle"] ?? '';

    try {
        $sql = "INSERT INTO salles (nom_salle, type_salle) 
                VALUES (:nom_salle, :type_salle)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom_salle' => $nom_salle,
            ':type_salle' => $type_salle ]);

        echo "✅ Salle ajoutée avec succès !";
        header("Location: accueil.php");
    } catch (PDOException $e) {
        die("❌ Erreur lors de l'ajout de la salle: " . $e->getMessage());
    }
}

?>