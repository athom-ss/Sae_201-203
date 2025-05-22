<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de matériel</title>
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/reservation_materiel.css">
    <link rel="stylesheet" href="../css/style_formulaire.css">
    <link rel="stylesheet" href="../css/header_nav_footer.css">
</head>

<!-- En-tête avec logo et icône de compte -->
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
    <!-- Barre de navigation -->
    <nav class="navbar">
      <a href="reservation_materiel.php">Réservation de matériel</a>
      <a href="reservation_salle.php">Réservation de salle</a>
    </nav>

    <!-- Conteneur principal divisé en deux sections -->
    <div class="reservation-materiel-container">
        <!-- Section gauche : Formulaire de réservation -->
        <div class="formulaire-reservation">
            
            <form action="reservation_materiel.php" method="POST">
                <h2>Réservation</h2>
                <!-- Informations personnelles -->
                <input id="nom_reservation" type="text" name="nom_reservation" placeholder="Votre nom" required><br><br>

                <input id="prenom_reservation" type="text" name="prenom_reservation" placeholder="Votre prénom" required><br><br>

                <input id="num_carte_reservation" type="number" name="num_carte_reservation" placeholder="Votre numéro de carte" required><br><br>

                <!-- Section pour ajouter plusieurs matériels -->
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

                <!-- Boutons pour gérer les blocs de réservation -->
                <button type="button" onclick="ajouterBloc()">➕ Ajouter un autre matériel</button><br><br>
                <button type="button" onclick="retirerBloc()">➖ Retirer un matériel</button><br><br>
                <button type="submit" class="btn-valider">Valider</button>
            </form>
        </div>

        <!-- Section droite : Liste du matériel disponible -->
        <div class="materiel-disponible">
            <h2>Matériel disponible</h2>
            <?php
            require_once "connexion_base.php";

            try {
                // Requête pour récupérer uniquement le matériel disponible
                // WHERE etat_materiel = 'Disponible'
                $sql = "SELECT * FROM materiel ORDER BY type_materiel";
                $stmt = $pdo->query($sql);
                echo "<table>";
                echo "<thead>
                        <tr>
                            <th>ID Matériel</th>
                            <th>Référence</th>
                            <th>Désignation</th>
                            <th>Type de matériel</th>
                            <th>Etat</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                // Affichage de chaque matériel dans le tableau
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$row['id_materiel']}</td>
                            <td>{$row['ref_materiel']}</td>
                            <td>{$row['designation']}</td>
                            <td>{$row['type_materiel']}</td>
                            <td>{$row['etat_materiel']}</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } catch (PDOException $e) {
                die("❌ Erreur lors de la récupération des données : " . $e->getMessage());
            }
            ?>
        </div>
    </div>

    <script src="../js/ajout_materiel.js"></script>
</body>
</html>

<?php
require_once "connexion_base.php";

// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des informations personnelles
    $nom = $_POST["nom_reservation"] ?? '';
    $prenom = $_POST["prenom_reservation"] ?? '';
    $num_carte = $_POST["num_carte_reservation"] ?? '';

    // Récupération des informations de réservation (tableaux pour plusieurs matériels)
    $id_materiels = $_POST["id_materiel"] ?? [];
    $types = $_POST["type_materiel"] ?? [];
    $debut_res = $_POST["datetime_reservation"] ?? [];
    $fin_res = $_POST["datetime_reservation_fin"] ?? [];

    // Vérification des informations personnelles
    if (empty($nom) || empty($prenom) || empty($num_carte)) {
        echo "❌ Veuillez remplir vos informations personnelles.";
        exit;
    }

    try {
        // Tableau pour stocker les matériels non disponibles
        $indisponibles = [];
        // Traitement de chaque matériel réservé
        for ($i = 0; $i < count($id_materiels); $i++) {
            $id_materiel = $id_materiels[$i];
            $type = $types[$i];
            $debut = $debut_res[$i];
            $fin = $fin_res[$i];

            // Vérification des champs pour chaque matériel
            if (empty($id_materiel) || empty($type) || empty($debut) || empty($fin)) {
                echo "❌ Veuillez remplir tous les champs pour chaque matériel.";
                exit;
            }

            // Vérification de l'existence du matériel
            $verifMateriel = $pdo->prepare("SELECT * FROM materiel WHERE id_materiel = :id_materiel");
            $verifMateriel->execute([':id_materiel' => $id_materiel]);
            if (!$verifMateriel->fetch()) {
                echo "❌ Le matériel avec l'ID $id_materiel n'existe pas.";
                exit;
            }

            // Vérification des chevauchements de réservation et récupération des créneaux
            $verifReservation = $pdo->prepare("
                SELECT datetime_reservation, datetime_reservation_fin FROM reservations_materiel
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
            $chevauchements = $verifReservation->fetchAll(PDO::FETCH_ASSOC);

            if (count($chevauchements) > 0) {
                // On construit une chaîne avec les créneaux déjà réservés
                $creneaux = [];
                foreach ($chevauchements as $c) {
                    $debut_creneau = date('d/m/Y H:i', strtotime($c['datetime_reservation']));
                    $fin_creneau = date('d/m/Y H:i', strtotime($c['datetime_reservation_fin']));
                    $creneaux[] = "du $debut_creneau au $fin_creneau";
                }
                $indisponibles[] = "Matériel ID $id_materiel : déjà réservé " . implode(' et ', $creneaux);
                continue; // On ne fait pas de exit, on continue la boucle
            }

            // Insertion de la réservation dans la base de données
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

        // Affichage du résultat
        if (!empty($indisponibles)) {
            echo "<div style='background-color: #ffebee; padding: 15px; margin: 15px; border-radius: 5px; border: 1px solid #ffcdd2;'>";
            echo "<h3 style='color: #c62828; margin-top: 0;'>❌ Les matériels suivants n'ont pas pu être réservés :</h3>";
            echo "<ul style='margin: 0; padding-left: 20px;'>";
            foreach ($indisponibles as $indisponible) {
                echo "<li style='color: #b71c1c; margin-bottom: 5px;'>$indisponible</li>";
            }
            echo "</ul>";
            echo "</div>";
        } else {
            // Redirection vers la page d'accueil après succès
            header("Location: accueil.php");
            exit;
        }

    } catch (PDOException $e) {
        die("❌ Erreur : " . $e->getMessage());
    }
}
?>


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