<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">  <!--  POUR PAS DEVOIR REFAIRE UN CSS -->
    <link rel="stylesheet" href="../css/header_nav_footer.css">
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
      <a href="reservation_materiel.php">Réservation de matériel</a>
      <a href="ajout_materiel.php">Ajout de matériel</a>
      <a href="ajout_salle.php">Ajout de salle</a>
      <a href="reservation_salle.php">Réservation de salle</a>
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
                        <input type="file" id="image" name="image" accept="image/*">
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
    $image_materiels = $_POST["image"] ?? [];

    $nb = count($id_materiels); // Nombre de matériels à ajouter

    try {
        // On boucle sur chaque matériel à ajouter
        for ($i = 0; $i < $nb; $i++) {
            $sql = "INSERT INTO materiel (id_materiel, ref_materiel, designation, image_materiel, type_materiel, date_achat, 
            etat_materiel, description_materiel) 
                    VALUES (:id_materiel, :ref_materiel, :designation, :image_materiel, :type_materiel, :date_achat, :etat_materiel, 
                    :description_materiel)";
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

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    // Traitement de l'image du matériel
}

?>