<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">  <!--  POUR PAS DEVOIR REFAIRE UN CSS -->
    <title>Ajout du matériel</title>
</head>
<header>
  <div class="images-header">
    <a href="accueil.php" class="logo_univ">
      <img src="../images/logo_universite.png" alt="logo_header">
    </a>
    <a href="compte.php" class="img_compte">
      <img src="../images/compte.png" alt="mon_compte">
    </a>
  </div>
</header>
<body>
    <nav class="navbar">
      <a href="reservation_materiel.php">Réservation de matériel</a>
      <a href="ajout_materiel.php">Ajout de matériel</a>
      <a href="ajout_salle.php">Ajout de salle</a>
      <a href="reservation_salle.php">Réservation de salle</a>
    </nav>
    <div class="conteneur-formulaire">
        <form action="ajout_materiel.php" method="POST">

            <label for="id_materiel">ID du matériel :</label>
            <input id="id_materiel" type="number" name="id_materiel" placeholder="ID du matériel"><br><br>

            <label for="ref_materiel">Référence du matériel :</label>
            <input id="ref_materiel" type="text" name="ref_materiel" placeholder="Référence du matériel"><br><br>

            <label for="designation">Désignation :</label>
            <input id="designation" type="text" name="designation" placeholder="Désignation">

            <br><br><label for="type_materiel">Type de matériel en liste :</label>
            <input id="type_materiel" type="text" name="type_materiel" placeholder="Type de matériel"><br><br>

            <label for="date_achat">Date d'achat :</label>
            <input id="date_achat" type="date" name="date_achat" placeholder="Date d'achat"><br><br>

            <label for="etat_materiel">État du matériel:</label>
            <select id="etat_materiel" name="etat_materiel">
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
            <label for="description_materiel">Description :</label>
            <textarea id="description_materiel" name="description_materiel" rows="4" cols="40" 
            placeholder="Ajoutez des détails sur l'état du matériel..."></textarea> <br><br>

            <input type="submit" value="Valider">
        </form>
    </div>
</body>
</html>

<?php
require_once "connexion_base.php"; // Inclusion de la connexion

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérification de l'existence des clés POST
    $id_materiel = $_POST["id_materiel"] ?? '';
    $ref_materiel = $_POST["ref_materiel"] ?? '';
    $designation = $_POST["designation"] ?? '';
    $image_materiel = $_POST["image_materiel"] ?? '';
    $type_materiel = $_POST["type_materiel"] ?? '';
    $date_achat = $_POST["date_achat"] ?? '';
    $etat_materiel = $_POST["etat_materiel"] ?? '';
    $description_materiel = $_POST["description_materiel"] ?? '';

    try {
        $sql = "INSERT INTO materiel (id_materiel, ref_materiel, designation, image_materiel, type_materiel, date_achat, etat_materiel, description_materiel) 
                VALUES (:id_materiel, :ref_materiel, :designation, :image_materiel, :type_materiel, :date_achat, :etat_materiel, :description_materiel)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_materiel' => $id_materiel,
            ':ref_materiel' => $ref_materiel,
            ':designation' => $designation,
            ':image_materiel' => $image_materiel,
            ':type_materiel' => $type_materiel,
            ':date_achat' => $date_achat,
            ':etat_materiel' => $etat_materiel,
            ':description_materiel' => $description_materiel
        ]);

        echo "✅ Matériel ajouté avec succès !";
        header("Location: accueil.php");
    } catch (PDOException $e) {
        die("❌ Erreur lors de l'ajout : " . $e->getMessage());
    }
}

?>