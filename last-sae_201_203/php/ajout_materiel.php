<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">  <!--  POUR PAS DEVOIR REFAIRE UN CSS -->
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_formulaire.css?v=<?= time(); ?>">
    <title>Ajout du matériel</title>
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
        <form action="traitement_ajout_materiel.php" method="POST" enctype="multipart/form-data">
            <h1>Ajout de matériel</h1><br>
            <div id="formulaires-ajout-materiel">
                <div class="bloc-ajout-materiel">
                    <input id="id_materiel" type="number" name="id_materiel[]" placeholder="ID du matériel"><br><br>

                    <input id="ref_materiel" type="text" name="ref_materiel[]" placeholder="Référence du matériel"><br><br>

                    <input id="designation" type="text" name="designation[]" placeholder="Désignation">

                    <br><label for="type_materiel">Type de matériel en liste :</label>
                    <input id="type_materiel" type="text" name="type_materiel[]" placeholder="Type de matériel"><br>

                    <label for="date_achat">Date d'achat :</label>
                    <input id="date_achat" type="date" name="date_achat[]" placeholder="Date d'achat"><br>

                    <label for="etat_materiel">État du matériel:</label>
                    <select id="etat_materiel" name="etat_materiel[]">
                        <option value="Très bon">Très bon</option>
                        <option value="Bon">Bon</option>
                        <option value="Moyen">Moyen</option>
                        <option value="En panne">En panne</option>
                        <option value="En réparation">En réparation</option>
                        <option value="Hors service">Hors service</option>
                        <option value="Neuf">Neuf</option>
                        <option value="Autre">Autre</option>
                    </select>
                    <br><br>
                    <textarea id="description_materiel" name="description_materiel[]" rows="4" cols="40" 
                    placeholder="Ajoutez des détails sur l'état du matériel..."></textarea> <br><br>

                    <div class="form-group">
                        <label for="image">Image du matériel</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                        <small>Formats acceptés : JPG, PNG, GIF. Taille maximale : 5MB</small>
                    </div>
                </div>
            </div>
            <!-- Boutons pour gérer les blocs d'ajout -->
            <!--<button type="button" onclick="ajouterBlocAjout()">➕ Ajouter un autre matériel</button><br><br>
            <button type="button" onclick="retirerBlocAjout()">➖ Retirer un matériel</button><br><br>-->
            <button type="submit" class="btn-valider">Valider</button> <br>
        </form>
    </div>
    <script src="plus_materiel_ajout.js"></script>

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
    // On récupère les tableaux de champs envoyés par le formulaire (un tableau par champ)
    $id_materiels = $_POST["id_materiel"] ?? [];
    $ref_materiels = $_POST["ref_materiel"] ?? [];
    $designations = $_POST["designation"] ?? [];
    $type_materiels = $_POST["type_materiel"] ?? [];
    $date_achats = $_POST["date_achat"] ?? [];
    $etat_materiels = $_POST["etat_materiel"] ?? [];
    $description_materiels = $_POST["description_materiel"] ?? [];
    $image_materiels = $_POST["image_materiel"] ?? []; // si tu ajoutes l'image plus tard

    $nb = count($id_materiels); // Nombre de matériels à ajouter

    try {
        // On boucle sur chaque matériel à ajouter
        for ($i = 0; $i < $nb; $i++) {
            $sql = "INSERT INTO materiel (id_materiel, ref_materiel, designation, image_materiel, type_materiel, date_achat, etat_materiel, description_materiel) 
                    VALUES (:id_materiel, :ref_materiel, :designation, :image_materiel, :type_materiel, :date_achat, :etat_materiel, :description_materiel)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_materiel' => $id_materiels[$i],
                ':ref_materiel' => $ref_materiels[$i],
                ':designation' => $designations[$i],
                ':image_materiel' => $image_materiels[$i] ?? '', // champ image optionnel
                ':type_materiel' => $type_materiels[$i],
                ':date_achat' => $date_achats[$i],
                ':etat_materiel' => $etat_materiels[$i],
                ':description_materiel' => $description_materiels[$i]
            ]);
        }
        // Redirection après succès
        header("Location: accueil.php");
        exit;
    } catch (PDOException $e) {
        die("❌ Erreur lors de l'ajout : " . $e->getMessage());
    }
}

?>