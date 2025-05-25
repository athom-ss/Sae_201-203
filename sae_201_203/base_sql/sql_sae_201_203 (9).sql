-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 25 mai 2025 à 02:55
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sql_sae_201_203`
--

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `annee_naissance` date DEFAULT NULL,
  `adresse_postale` varchar(50) DEFAULT NULL,
  `role_personne` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(250) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `statut` varchar(15) DEFAULT NULL,
  `groupe` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `mail`, `pseudo`, `nom`, `prenom`, `annee_naissance`, `adresse_postale`, `role_personne`, `mot_de_passe`, `num`, `statut`, `groupe`) VALUES
(36, 'andouardliam@gmail.com', 'lando*', 'and', 'li', '2006-08-20', 'dsfsdfsd4f56sd4', 'Etudiant', '12', 289689, 'attente', NULL),
(37, 'admin@gmail.com', 'sds4dsd6sd', 'ad', 'min', '2001-01-01', '0', 'Administrateur', '0', 0, 'Etudiant', 'MMI 1 TP2'),
(38, 'quyigfs@gmail.com', 'huggu', 'ghugygug', 'yguygyug', '4644-05-04', '4654', 'Etudiant', 'guytygu', 644454, 'attente', NULL),
(39, 'quyigfs@gmail.com', 'huggu', 'ghugygug', 'yguygyug', '4644-05-04', '4654', 'Etudiant', 'guytygu', 644454, 'attente', NULL),
(40, 'iosf@gmail.com', 'gyguyguy', 'gygyg', 'gyguguyg', '4888-06-04', '8464fd8fd', 'Enseignant', 'yufugui', 465488, 'attente', NULL),
(41, 'admin_test@gmail.com', 'admin', 'min', 'ad', '0001-01-01', 'maison', 'Administrateur', 'admin', 0, '', NULL),
(42, 'orofjhilhuig@gmail.xn--cp-pka', 'prof', 'of', 'pr', '2222-02-22', 'logement', 'Enseignant', 'prof', 1, 'attente', 'fsdsfsdfsdf'),
(43, 'etudiant@gmail.com', 'eleve', 'diant', 'etu', '3333-03-31', 'maison', 'Etudiant', 'etudiant', 2, 'attente', NULL),
(44, 'huguuh@gmaiL.com', 'jghghg', 'hghjgh', 'ghgjgj', '6444-05-04', '4564fdfdd', 'Etudiant', 'vghfytf', 456479, 'attente', 'Groupe 2'),
(45, 'scsc@fefef', 'scqc', 'cqcdvd', 'dvsvsv', '2025-05-09', 'effefe', 'Etudiant', 'feffeffe', 383833, 'attente', 'MMI 1 - TD2'),
(46, 'admin@gmail.com', 'admin', 'min', 'ad', '2000-05-02', 'maison', 'Administrateur', 'admin', 0, '', ''),
(47, 'andouardliam@gmail.com', 'toman', 'Andouard', 'Liam', '2006-08-20', '6 rue du montboulon, maisonsalmérie', 'Etudiant', 'LandM772008', 289689, 'valide', 'MMI 1 - TD2');

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

CREATE TABLE `materiel` (
  `id_materiel` int(11) DEFAULT NULL,
  `ref_materiel` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `image_materiel` blob DEFAULT NULL,
  `type_materiel` varchar(50) DEFAULT NULL,
  `date_achat` date DEFAULT NULL,
  `etat_materiel` varchar(50) DEFAULT NULL,
  `description_materiel` varchar(500) DEFAULT NULL,
  `disponibilite` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `ref_materiel`, `designation`, `image_materiel`, `type_materiel`, `date_achat`, `etat_materiel`, `description_materiel`, `disponibilite`, `image`) VALUES
(1, '0001', '0001', NULL, 'Micro', '2023-09-15', 'Très bonne état', 'Micro rouge', 'Disponible', 'uploads/materiel/20230505_100614.jpg'),
(2, '0002', '0002', NULL, 'Projecteur', '2023-09-15', 'Très bonne état', 'Video projecteur', 'Disponible', 'uploads/materiel/20230505_104109.jpg'),
(3, '0003', '0003', NULL, 'Manette', '2023-09-15', 'Très bonne état', 'Manette Xbox', 'Disponible', 'uploads/materiel/20230505_104425.jpg'),
(4, '0004', '0004', NULL, 'Casque', '2023-09-15', 'Très bonne état', 'Casque Steelseries arctis avec son de qualité', 'Disponible', 'uploads/materiel/20230505_105442.jpg'),
(5, '0005', '0005', NULL, 'Camera', '2023-09-15', 'Très bonne état', 'Caméra', 'Disponible', 'uploads/materiel/20230505_105700.jpg'),
(6, '0006', '0006', NULL, 'Trepied', '2023-09-15', 'Très bonne état', 'Trépied caméra', 'Disponible', 'uploads/materiel/20230505_110146.jpg'),
(7, '0007', '0007', NULL, 'Casque', '2023-09-15', 'Très bonne état', 'Casque virtuel blanc', 'Disponible', 'uploads/materiel/IMG_0007.JPG'),
(8, '0008', '0008', NULL, 'Drone', '2023-09-15', 'Très bonne état', 'Drone', 'Disponible', 'uploads/materiel/P1018442.JPG'),
(9, '0009', '0009', NULL, 'Trepied', '2023-09-15', 'Très bonne état', 'Trépied tous support', 'Disponible', 'uploads/materiel/P1018448.JPG'),
(10, '0010', '0010', NULL, 'Tablette', '2023-09-15', 'Très bonne état', 'Tablete de qualité multitache', 'Disponible', 'uploads/materiel/P1018469.JPG'),
(11, '0011', '0011', NULL, 'Camera', '2023-09-15', 'Très bonne état', 'Camera qui permet de filmer à 360 degrés', 'Disponible', 'uploads/materiel/P1018480.JPG'),
(12, '0012', '0012', NULL, 'Cable', '2023-09-15', 'Très bonne état', 'Cable permettant de relier le casque virtuel au pc', 'Disponible', 'uploads/materiel/P1018495.JPG'),
(13, '0013', '0013', NULL, 'Casque', '2023-09-15', 'Très bonne état', 'Casque virtuel noir', 'Disponible', 'uploads/materiel/P1018552.JPG'),
(32, 'casque', '', NULL, 'casque', '2025-05-31', 'Très bon', 'Lozdiifj fjeffefef', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `datetime_debut` datetime DEFAULT NULL,
  `datetime_fin` datetime DEFAULT NULL,
  `num_carte_reservation` int(11) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `commentaire` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations_materiel`
--

CREATE TABLE `reservations_materiel` (
  `id_materiel` int(11) DEFAULT NULL,
  `ref_materiel` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `type_materiel` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `num_carte_reservation` varchar(255) DEFAULT NULL,
  `datetime_reservation` datetime DEFAULT NULL,
  `datetime_reservation_fin` datetime DEFAULT NULL,
  `nom_reservation` varchar(50) DEFAULT NULL,
  `prenom_reservation` varchar(50) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `image` blob DEFAULT NULL,
  `prenom` varchar(15) DEFAULT NULL,
  `nom` varchar(15) DEFAULT NULL,
  `commentaire` varchar(500) DEFAULT NULL,
  `eleves` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations_materiel`
--

INSERT INTO `reservations_materiel` (`id_materiel`, `ref_materiel`, `designation`, `type_materiel`, `id`, `num_carte_reservation`, `datetime_reservation`, `datetime_reservation_fin`, `nom_reservation`, `prenom_reservation`, `statut`, `image`, `prenom`, `nom`, `commentaire`, `eleves`) VALUES
(4544, NULL, NULL, '456465465', 42, '222222', '2025-05-01 23:53:00', '2025-05-07 23:53:00', '', '', 'En attente de validation', NULL, NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `type_salle` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `image_salle` blob DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `informations` varchar(500) DEFAULT NULL,
  `description_salle` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`nom_salle`, `type_salle`, `id`, `image_salle`, `image`, `informations`, `description_salle`) VALUES
('212', 'Salle gaming', 1, NULL, 'uploads/materiel/Salle212.jpg', NULL, 'La salle 212 est une salle de gaming qui permet de faire de la 3d ou de l’hébergement de site'),
('138', 'Salle gaming', 2, NULL, 'uploads/materiel/Salle138.JPG', NULL, 'La salle 138 est une salle de gaming qui permet de faire de la 3d ou de l’hébergement de site'),
('salle 344', 'Salle informatique', 30, NULL, NULL, NULL, NULL),
('22333', 'Salle de classe', 31, NULL, NULL, NULL, NULL),
('zez', 'Salle informatique', 32, NULL, NULL, NULL, NULL),
('zz', 'Salle informatique', 33, NULL, '', NULL, 'dzdzd'),
('jhjkhh', 'Salle informatique', 0, NULL, 'images/salles/1748134252_th.jpg', NULL, 'segdsgsgdsg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
