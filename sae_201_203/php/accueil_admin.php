<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_accueil.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_admin.css?v=<?= time(); ?>">
    <title>Accueil du site</title>
</head>

<header>
  <div class="images-header">
    <a href="accueil_admin.php" class="logo_univ">
      <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
    </a>
    <div class="header-actions">
      <a href="deconnexion.php" class="btn-deconnexion">Se déconnecter</a>
      <a href="compte_admin.php" class="img_compte">
        <img src="../images/compte.png" alt="mon_compte">
      </a>
    </div>
  </div>
</header>
<body>
    <section class="main-banner">
        <div class="text">
            <h1>
                Espace Administrateur.<br>
                Accédez à toutes les fonctionnalités de la plateforme.
            </h1>
            <p>
                Bienvenue sur la plateforme dédiée aux étudiants et personnels de l'IUT.
                Gérez les salles, le matériel et les réservations.            
            </p>
        </div>
    </section>
    <div class="admin-accueil-container">
        <div class="admin-links">
            <a href="ajout_materiel.php" class="admin-link gestion-materiel">
                <span>Gestion du Matériel</span>
                <p>Ajoutez et gérez le matériel numérique disponible pour les étudiants</p>
            </a>
            <a href="ajout_salle.php" class="admin-link gestion-salles">
                <span>Gestion des Salles</span>
                <p>Configurez et gérez les salles de travail et leurs équipements</p>
            </a>
            <a href="eleves_attente.php" class="admin-link gestion-comptes">
                <span>Gestion des Élèves</span>
                <p>Validez les inscriptions et gérez les comptes étudiants</p>
            </a>
            <a href="afficher_tout.php" class="admin-link gestion-comptes">
                <span>Afficher toute les informations</span>
                <p>Accédez à toutes les informations (étudiants, salles, matériel, réservations)</p>
            </a>
            <a href="validation_reservations.php" class="admin-link gestion-comptes">
                <span>Valider les réservations</span>
                <p>Validez les réservations des étudiants</p>
            </a>
            <a href="statistiques.php" class="admin-link gestion-comptes">
                <span>Statistiques</span>
                <p>Accédez aux statistiques des réservations</p>
            </a>
        </div>
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
<script src="../js/acceuil.js?v=<?= time(); ?>"></script>
</html>