<?php   // METTRE PHP AVANT POUR RECUPERER LES INFORMATIONS UTILISATEUR
session_start();
require_once "connexion_base.php"; // Cette ligne doit absolument être présente

// Debug
error_log("Accès à compte.php. Session: ".print_r($_SESSION, true));

// Vérification plus complète de la session
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    error_log("Redirection vers connexion.php - Session user ou ID non trouvé");
    $_SESSION['erreur'] = "Session expirée ou invalide";
    header("Location: ../connexion.php");
    exit;
}

// Récupération des infos de l'utilisateur depuis la table inscription
$id = $_SESSION['user']['id'];

try {
    // Vérification que $pdo est bien disponible
    if (!isset($pdo)) {
        throw new PDOException("La connexion à la base de données n'est pas disponible");
    }

    $sql = "SELECT * FROM inscription WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['erreur'] = "❌ Utilisateur non trouvé";
        header("Location: ../connexion.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['erreur'] = "❌ Erreur de base de données : " . $e->getMessage();
    error_log("Erreur PDO dans compte.php: " . $e->getMessage());
    header("Location: ../connexion.php");
    exit;
}



// Récupération des infos de l'utilisateur depuis la table reservation_materiel
$id = $_SESSION['user']['id'];

try {
    // Vérification que $pdo est bien disponible
    if (!isset($pdo)) {
        throw new PDOException("La connexion à la base de données n'est pas disponible");
    }

    $sql = "SELECT * FROM inscription WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['erreur'] = "❌ Utilisateur non trouvé";
        header("Location: ../connexion.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['erreur'] = "❌ Erreur de base de données : " . $e->getMessage();
    error_log("Erreur PDO dans compte.php: " . $e->getMessage());
    header("Location: ../connexion.php");
    exit;
}
?>

<!DOCTYPE html>  <!--  APRES LE PHP POUR D'ABORD RECUPERER LES INFORMATIONS UTILISATEUR -->
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_compte.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <title>Mon compte</title>
</head>

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
<body>
<nav class="navbar">
        <a href="ajout_materiel.php">Ajout de matériel</a>
        <a href="ajout_salle.php">Ajout de salle</a>
        <a href="eleves_attente.php">Gestion des élèves</a>
        <a href="validation_reservations.php">Valider les réservations</a>
        <a href="statistiques.php">Statistiques</a>
        <a href="afficher_tout.php">Afficher toutes les informations</a>
    </nav>

    <div class="conteneur-compte">
        <br><h1>Bienvenue <?= htmlspecialchars($user['prenom']) ?> !</h1>

        <div class="compte-wrapper">
            <!-- Profil sur la gauche -->
            <div class="card-profil">
                <div class="avatar">👤</div>
                <div class="pseudo"><?= htmlspecialchars($user['pseudo']) ?></div>
                <div class="id">Votre ID : <?= htmlspecialchars($user['id']) ?></div>
                <div class="role">Statut : <?= htmlspecialchars($user['role_personne']) ?></div>
                <br><br><a href="../connexion.php" class="btn bouton-deconnexion">Se déconnecter</a>
            </div>
            <!-- Partie détaillée avec toutes les informations de l'utilisateur sur la droite -->
            <div class="fiche-details">
                <div class="detail-row">
                    <strong>Prénom :</strong> <span><?= htmlspecialchars($user['prenom']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Nom :</strong> <span><?= htmlspecialchars($user['nom']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Numéro de carte :</strong> <span><?= htmlspecialchars($user['num']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Date de naissance :</strong> <span><?= htmlspecialchars($user['annee_naissance']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Email :</strong> <span><?= htmlspecialchars($user['mail']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Adresse postale :</strong> <span><?= htmlspecialchars($user['adresse_postale']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Mot de passe :</strong> <span>*********</span>
                </div>
                <a href="modifier_compte.php" class="btn btn-primary">Modifier mon profil</a>
            </div>
    </div>

</body>
</html>
