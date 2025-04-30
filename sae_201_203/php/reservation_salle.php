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
      <a href="ajout_materiel.php">Ajout de matériel</a>
      <a href="ajout_salle.php">Ajout de salle</a>
      <a href="reservation_salle.php">Réservation de salle</a>
    </nav>
    <div class="conteneur-formulaire">
        <form action="reservation_salle.php" method="POST">

            <label for="nom_salle">Nom de la salle (sans espaces) :</label>
            <input id="nom_salle" type="text" name="nom_salle" placeholder="Nom de la salle"><br><br>

            <label for="date_reservation">Date de réservation :</label>
            <input id="date_reservation" type="date" name="date_reservation" placeholder="Date de réservation de la salle"><br><br>

            <label for="heure_reservation">Heure de réservatoon :</label>
            <select id="heure_reservation" name="heure_reservation">
                <option value="08:30 - 10:30">De 08:30 à 10:30</option>
                <option value="10:45 - 12:45">De 10:45 à 12:45</option>
                <option value="13:45 - 15:45">De 13:45 à 15:45</option>
                <option value="16:00 - 18:00">De 16:00 à 18:00</option>
            </select>
            <input type="submit" value="Valider"> <br><br>
        </form>
    </div>
</body>
</html>


<?php
require_once "connexion_base.php"; // Connexion PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_salle = $_POST["nom_salle"] ?? '';
    $date_reservation = $_POST["date_reservation"] ?? '';
    $heure_reservation = $_POST["heure_reservation"] ?? '';

    if (empty($nom_salle) || empty($date_reservation) || empty($heure_reservation)) {
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
                                           AND date_reservation = :date_reservation 
                                           AND heure_reservation = :heure_reservation");
        $verifReservation->execute([
            ':nom_salle' => $nom_salle,
            ':date_reservation' => $date_reservation,
            ':heure_reservation' => $heure_reservation
        ]);
        if ($verifReservation->fetchColumn() > 0) {
            echo "❌ Cette salle est déjà réservée à ce créneau.";
            exit;
        }

        // Insertion de la réservation
        $insert = $pdo->prepare("INSERT INTO reservations (nom_salle, date_reservation, heure_reservation) 
                                 VALUES (:nom_salle, :date_reservation, :heure_reservation)");
        $insert->execute([
            ':nom_salle' => $nom_salle,
            ':date_reservation' => $date_reservation,
            ':heure_reservation' => $heure_reservation
        ]);

        echo "✅ Réservation effectuée avec succès.";
        header("Location: accueil.php");
    } catch (PDOException $e) {
        die("❌ Erreur : " . $e->getMessage());
    }
}
?>
