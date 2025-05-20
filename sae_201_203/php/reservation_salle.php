<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>"> <!--  POUR PAS DEVOIR REFAIRE UN CSS -->
    <title>Réservation de salle</title>
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
      <a href="reservation_salle.php">Réservation de salle</a>
    </nav>
    <div class="conteneur-formulaire">
        <form action="reservation_salle.php" method="POST">
            <label for="nom_salle">Nom de la salle (sans espaces) :</label>
            <input id="nom_salle" type="text" name="nom_salle" placeholder="Nom de la salle"><br><br>

            <label for="num_carte_reservation">Votre numéro de carte :</label>
            <input id="num_carte_reservation" type="number" name="num_carte_reservation" placeholder="Votre numéro de carte"><br><br>

            <label for="datetime_debut">Date et Heure de début :</label>
            <input id="datetime_debut" type="datetime-local" name="datetime_debut"><br><br>

            <label for="datetime_fin">Date et Heure de fin :</label>
            <input id="datetime_fin" type="datetime-local" name="datetime_fin"><br><br>

            <button type="submit" class="btn-valider">Valider</button> <br> <br>
        </form>
    </div>
</body>
</html>

<?php
require_once "connexion_base.php"; // Connexion PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_salle = $_POST["nom_salle"] ?? '';
    $num_carte_reservation = $_POST["num_carte_reservation"] ?? '';
    $datetime_debut = $_POST["datetime_debut"] ?? '';
    $datetime_fin = $_POST["datetime_fin"] ?? '';

    if (empty($nom_salle) || empty($datetime_debut) || empty($datetime_fin)) {
        echo "❌ Veuillez remplir tous les champs.";
        exit;
    }

    try {
        // Vérifier si la salle existe
        $verifSalle = $pdo->prepare("SELECT * FROM salles WHERE nom_salle = :nom_salle");
        $verifSalle->execute([':nom_salle' => $nom_salle]);
        $salle = $verifSalle->fetch(PDO::FETCH_ASSOC);

        if (!$salle) {
            echo "❌ Cette salle n'existe pas.";
            exit;
        }

        // Vérifier si une réservation existe déjà
        $verifReservation = $pdo->prepare("SELECT COUNT(*) FROM reservations 
                                           WHERE nom_salle = :nom_salle 
                                           AND datetime_debut < :datetime_fin 
                                           AND datetime_fin > :datetime_debut");
        $verifReservation->execute([
            ':nom_salle' => $nom_salle,
            ':datetime_debut' => $datetime_debut,
            ':datetime_fin' => $datetime_fin
        ]);
        if ($verifReservation->fetchColumn() > 0) {
            echo "❌ Cette salle est déjà réservée à ce créneau.";
            exit;
        }

        // Insertion de la réservation
        $insert = $pdo->prepare("INSERT INTO reservations (nom_salle, num_carte_reservation, datetime_debut, datetime_fin) 
                                 VALUES (:nom_salle, :num_carte_reservation,:datetime_debut, :datetime_fin)");
        $insert->execute([
            ':nom_salle' => $nom_salle,
            ':num_carte_reservation' => $num_carte_reservation,
            ':datetime_debut' => $datetime_debut,
            ':datetime_fin' => $datetime_fin
        ]);

        echo "✅ Réservation effectuée avec succès.";
        header("Location: accueil.php");
    } catch (PDOException $e) {
        die("❌ Erreur : " . $e->getMessage());
    }
}
?>
