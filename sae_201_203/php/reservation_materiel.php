<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de matériel</title>
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
</head>

<header>
  <div class="images-header">
    <a href="accueil.php" class="logo_univ">
      <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
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
        <form action="reservation_materiel.php" method="POST">
            <input id="nom_reservation" type="text" name="nom_reservation" placeholder="Votre nom" required><br><br>

            <input id="prenom_reservation" type="text" name="prenom_reservation" placeholder="Votre prénom" required><br><br>

            <input id="num_carte_reservation" type="number" name="num_carte_reservation" placeholder="Votre numéro de carte" required><br><br>

            <div id="formulaires-materiel">
                <div class="bloc-reservation">
                    <input type="number" name="id_materiel[]" placeholder="ID du matériel" required><br><br>

                    <input type="text" name="type_materiel[]" placeholder="Type de matériel" required><br><br>

                    <label for="datetime_reservation[]">Début de la réservation :</label>
                    <input type="datetime-local" name="datetime_reservation[]" required><br><br>

                    <label for="datetime_reservation_fin[]">Fin de la réservation :</label>
                    <input type="datetime-local" name="datetime_reservation_fin[]" required><br><br>
                </div>
            </div>

            <button type="button" onclick="ajouterBloc()">➕ Ajouter un autre matériel</button><br><br>
            <button type="button" onclick="retirer  Bloc()">➖ Ajouter un autre matériel</button><br><br>
            <button type="submit" class="btn-valider">Valider</button>
        </form>
    </div>

    <script src="../js/ajout_materiel.js"></script>
</body>
</html>

<?php
require_once "connexion_base.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom_reservation"] ?? '';
    $prenom = $_POST["prenom_reservation"] ?? '';
    $num_carte = $_POST["num_carte_reservation"] ?? '';

    $id_materiels = $_POST["id_materiel"] ?? [];
    $types = $_POST["type_materiel"] ?? [];
    $debut_res = $_POST["datetime_reservation"] ?? [];
    $fin_res = $_POST["datetime_reservation_fin"] ?? [];

    if (empty($nom) || empty($prenom) || empty($num_carte)) {
        echo "❌ Veuillez remplir vos informations personnelles.";
        exit;
    }

    try {
        for ($i = 0; $i < count($id_materiels); $i++) {
            $id_materiel = $id_materiels[$i];
            $type = $types[$i];
            $debut = $debut_res[$i];
            $fin = $fin_res[$i];

            if (empty($id_materiel) || empty($type) || empty($debut) || empty($fin)) {
                echo "❌ Veuillez remplir tous les champs pour chaque matériel.";
                exit;
            }

            // Vérifier si le matériel existe
            $verifMateriel = $pdo->prepare("SELECT * FROM materiel WHERE id_materiel = :id_materiel");
            $verifMateriel->execute([':id_materiel' => $id_materiel]);
            if (!$verifMateriel->fetch()) {
                echo "❌ Le matériel avec l'ID $id_materiel n'existe pas.";
                exit;
            }

            // Vérifier chevauchement de réservation
            $verifReservation = $pdo->prepare("
                SELECT COUNT(*) FROM reservations_materiel
                WHERE id_materiel = :id_materiel
                AND (
                    (datetime_reservation <= :fin 
                    AND datetime_reservation_fin >= :debut)
                )
            ");
            $verifReservation->execute([
                ':id_materiel' => $id_materiel,
                ':debut' => $debut,
                ':fin' => $fin
            ]);

            if ($verifReservation->fetchColumn() > 0) {
                echo "❌ Le matériel $id_materiel est déjà réservé entre $debut et $fin.";
                exit;
            }

            // Insertion dans la base
            $insert = $pdo->prepare("
                INSERT INTO reservations_materiel (
                    id_materiel, type_materiel, datetime_reservation,
                    nom_reservation, prenom_reservation, num_carte_reservation,
                    datetime_reservation_fin
                ) VALUES (
                    :id_materiel, :type_materiel, :datetime_reservation,
                    :nom, :prenom, :num_carte, :datetime_reservation_fin
                )
            ");

            $insert->execute([
                ':id_materiel' => $id_materiel,
                ':type_materiel' => $type,
                ':datetime_reservation' => $debut,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':num_carte' => $num_carte,
                ':datetime_reservation_fin' => $fin
            ]);
        }

        header("Location: accueil.php");
        exit;

    } catch (PDOException $e) {
        die("❌ Erreur : " . $e->getMessage());
    }
}
?>
