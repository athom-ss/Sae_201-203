-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 23 mai 2025 à 21:49
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

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
  `statut` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `mail`, `pseudo`, `nom`, `prenom`, `annee_naissance`, `adresse_postale`, `role_personne`, `mot_de_passe`, `num`, `statut`) VALUES
(31, '1@gmail.com', 'lando*', 'and', 'li', '2006-08-20', '7 rue ', 'Administrateur', '1', 289689, ''),
(32, 'test@gmail.co', 'liam', 'liam', 'liam', '2222-02-22', '222', 'Etudiant', '2222', 222222, 'valide'),
(33, 'jguyu@gmail.com', 'yuyugy', 'gygug', 'gyugyug', '0654-04-04', '4654', 'Administrateur', '45646fsffs', 56464, ''),
(34, 'fzfzf@grzgrz', 'zfzfzfrg', 'gzgzrgf', 'rgege', '2025-05-15', 'fezrf', 'Etudiant', 'feee', 123456, 'valide'),
(35, 'dzd@dzd', 'dzddd', 'zd', 'dz', '2025-05-08', 'rer', 'Etudiant', 'rerrerre', 123453, 'attente'),
(36, 'efef@fefefe', 'fefef', 'efef', 'efefe', '2025-05-05', 'efzgzgzg', 'Etudiant', 'gegegrn', 123456, 'attente'),
(37, 'ggegfefef@fefeff', 'grgger', 'fezfzef', 'fzfzfze', '2025-05-09', 'fefef', 'Etudiant', 'zdddddddddddddddd', 221344, 'attente');

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
  `description_materiel` varchar(255) DEFAULT NULL,
  `disponibilite` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `ref_materiel`, `designation`, `image_materiel`, `type_materiel`, `date_achat`, `etat_materiel`, `description_materiel`, `disponibilite`, `image`) VALUES
(1, '1', '1', NULL, 'Caméra', '1111-11-11', 'Très bon', '1', NULL, 'uploads/materiel/68305b6448372_20230505_105908.jpg'),
(2, '2', '2', NULL, 'Micro', '2222-02-22', 'Très bon', '2', NULL, 'uploads/materiel/68305b72d2c5d_20230505_100918.jpg'),
(3, '3', '3', NULL, 'Manette', '3333-03-31', 'Très bon', '3', NULL, 'uploads/materiel/68305b80bc366_20230505_104558.jpg'),
(4, '4', '4', NULL, 'Casque', '4444-04-04', 'Très bon', '4', NULL, 'uploads/materiel/68305b905118e_20230505_101540.jpg'),
(5, '5', '5', NULL, 'Tablette', '5555-05-05', 'Très bon', '5', NULL, 'uploads/materiel/P1018499.JPG'),
(6, '6', '6', NULL, 'Casque', '6666-06-06', 'Très bon', '6', NULL, 'uploads/materiel/P1018478.JPG'),
(7, '7', '7', NULL, 'Drone', '7777-07-07', 'Très bon', '7', NULL, 'uploads/materiel/P1018445.JPG'),
(8, '8', '8', NULL, 'Cable', '8888-08-08', 'Très bon', '8', NULL, 'uploads/materiel/P1018494.JPG'),
(9, '9', '9', NULL, 'Cable', '9999-09-09', 'Très bon', '9', NULL, 'uploads/materiel/P1018496.JPG'),
(10, '10', '10', NULL, 'Trépied', '1010-10-10', 'Très bon', '10', NULL, 'uploads/materiel/20230505_110146.jpg'),
(11, '11', '11', NULL, 'Caméra', '1101-11-11', 'Très bon', '11', NULL, 'uploads/materiel/camera_jpeg.jpeg'),
(12, '12', '12', NULL, 'Caméra', '1212-12-12', 'Très bon', '12', NULL, 'uploads/materiel/P1018480.JPG'),
(13, '13', '13', NULL, 'Trépied', '0000-00-00', 'Très bon', '13', NULL, 'uploads/materiel/P1018450.JPG'),
(14, '14', '14', NULL, 'Casque', '0000-00-00', 'Très bon', '14', NULL, 'uploads/materiel/P1018554.JPG'),
(15, '15', '15', NULL, 'Caméra', '0000-00-00', 'Très bon', '15', NULL, 'uploads/materiel/P1018490.JPG'),
(16, '16', '16', NULL, 'Casque', '0000-00-00', 'Très bon', '16', NULL, 'uploads/materiel/P1018522.JPG'),
(17, '17', '17', NULL, 'Vidéo projecteur', '0000-00-00', 'Très bon', '17', NULL, 'uploads/materiel/6830443d8499a_20230505_104109.jpg');

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
  `statut` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`nom_salle`, `id`, `datetime_debut`, `datetime_fin`, `num_carte_reservation`, `statut`) VALUES
('1', 9, '2025-05-10 19:58:00', '2025-05-30 17:58:00', 123456, 'En attente de validation'),
('1', 10, '2025-05-05 17:59:00', '2025-05-06 17:59:00', 123467, 'En attente de validation'),
('1234', 11, '2025-05-05 17:59:00', '2025-05-06 17:59:00', 123456, 'En attente de validation'),
('123', 12, '2025-05-16 18:01:00', '2025-05-11 18:01:00', 123456, 'En attente de validation'),
('B202', 13, '2025-05-09 18:52:00', '2025-05-20 18:52:00', 111111, NULL),
('86787', 14, '2025-05-24 18:56:00', '2025-05-25 18:56:00', 123456, NULL);

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
  `nom` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations_materiel`
--

INSERT INTO `reservations_materiel` (`id_materiel`, `ref_materiel`, `designation`, `type_materiel`, `id`, `num_carte_reservation`, `datetime_reservation`, `datetime_reservation_fin`, `nom_reservation`, `prenom_reservation`, `statut`, `image`, `prenom`, `nom`) VALUES
(1, NULL, NULL, 'camera', 26, '222222', '2001-01-01 10:10:00', '2200-02-02 02:02:00', 'liam', 'liam', 'En attente de validation', NULL, NULL, NULL),
(2, NULL, NULL, 'micro', 27, '222222', '2001-01-01 10:10:00', '2200-02-02 02:02:00', 'liam', 'liam', 'En attente de validation', NULL, NULL, NULL),
(3, NULL, NULL, 'manette', 28, '222222', '2001-01-01 10:10:00', '2200-02-02 02:02:00', 'liam', 'liam', 'En attente de validation', NULL, NULL, NULL),
(4, NULL, NULL, 'casque', 29, '222222', '2001-01-01 10:10:00', '2200-02-02 02:02:00', 'liam', 'liam', 'En attente de validation', NULL, NULL, NULL),
(1, NULL, NULL, 'camera', 30, '56464', '0511-11-05 22:05:00', '0511-11-06 05:59:00', 'gygug', 'gyugyug', 'En attente de validation', NULL, NULL, NULL),
(2, NULL, NULL, 'micro', 31, '56464', '0511-11-05 22:05:00', '0511-11-06 05:59:00', 'gygug', 'gyugyug', 'En attente de validation', NULL, NULL, NULL),
(3, NULL, NULL, 'manette', 32, '56464', '0511-11-05 22:05:00', '0511-11-06 05:59:00', 'gygug', 'gyugyug', 'En attente de validation', NULL, NULL, NULL),
(4, NULL, NULL, 'casque', 33, '56464', '0511-11-05 22:05:00', '0511-11-06 05:59:00', 'gygug', 'gyugyug', 'En attente de validation', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `type_salle` varchar(50) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`nom_salle`, `type_salle`, `Image`) VALUES
('1234', 'Salle gaming', NULL),
('B202', 'Salle informati', NULL),
('1', 'Salle de classe', NULL),
('123', 'Salle de classe', NULL),
('86787', 'Salle de classe', NULL),
('212', 'Salle gaming', 'uploads/materiel/Salle212.jpg'),
('138', 'Salle gaming', 'uploads/materiel/Salle138.JPG');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `reservations_materiel`
--
ALTER TABLE `reservations_materiel`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `reservations_materiel`
--
ALTER TABLE `reservations_materiel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
