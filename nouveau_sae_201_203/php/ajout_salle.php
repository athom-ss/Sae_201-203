<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">  <!--  POUR PAS DEVOIR REFAIRE UN CSS -->
    <title>Ajout de salle</title>
</head>
<header>
  <div class="images-header">
    <a href="accueil_admin.php" class="logo_univ">
      <img src="../images/logo_universite.png" alt="logo_header">
    </a>
    <a href="compte_admin.php" class="img_compte">
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
        <form action="ajout_salle.php" method="POST">
            <label for="nom_salle">Nom de la salle :</label>
            <input id="nom_salle" type="text" name="nom_salle" placeholder="Nom de la salle"><br><br>

            <label for="type_salle">Type de salle :</label>
            <select id="type_salle" name="type_salle">
                <option value="Salle de classe">Salle de classe</option>
                <option value="Salle informatique">Salle informatique</option>
                <option value="Salle gaming">Salle gaming</option>
                <option value="Salle de repos">Salle de repos</option>
            </select>
            <button type="submit" class="btn-valider">Valider</button> <br> <br>
        </form>
    </div>
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