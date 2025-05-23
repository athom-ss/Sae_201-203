-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 21 mai 2025 à 23:04
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
(25, 'ho_yfaga@hmajoi.com', 'nonioo', 'uihuihuh', 'huhih', '6455-05-04', '5464f', 'Etudiant', 'fqsqf', 454468, 'attente'),
(26, 'ffsfs@gmail.com', 'fsdfdf', 'dfsfsdf', 'sdffsdf', '2556-12-11', 'qeffsqff 7 dqdsd', 'Etudiant', 'sffsqfsf', 123456, 'attente'),
(27, 'test@gmail.co', 'toman*', 'and', 'lia', '2001-01-01', 'jufheuhfu', 'Etudiant', 'sgdsgsdgsdg', 123456, 'attente'),
(28, 'admin@admin', 'admin', 'admin', 'admin', '1111-11-11', 'admin', 'Administrateur', 'admin', 111111, ''),
(29, 'fsdss@gf.com', 'sdfsdfds', 'fdsf', 'sdfsdf', '0545-06-04', '456465fq', 'Administrateur', 'qfesdsfsd', 4654, ''),
(30, 'sfsdff@gmail.com', 'jjioji', 'jij', 'ijj', '9778-08-07', '87987sff', 'Etudiant', 'fsdsfd', 998897, 'attente');

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
  `disponibilite` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `ref_materiel`, `designation`, `image_materiel`, `type_materiel`, `date_achat`, `etat_materiel`, `description_materiel`, `disponibilite`) VALUES
(123456789, '123456789', '123456789', '', '123456789', '4567-03-12', 'Bon', '123456789', 'utilise'),
(0, 'Array', 'Array', '', 'Array', '0000-00-00', 'Array', 'Array', NULL),
(1111111, '1111111', 'designation', '', 'camera', '0550-02-01', 'Moyen', 'ceci est une camera', NULL),
(22222222, '2222222', 'desi_2', '', 'micro', '6544-05-02', 'Hors service', 'fsfdsfsdfsf', NULL),
(1234, '1234', '1234', '', 'cam', '0004-03-12', 'Très bon', '1234', NULL),
(5678, '5678', '5678', '', 'mic', '0078-06-05', 'Bon', '5678', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `datetime_debut` datetime DEFAULT NULL,
  `datetime_fin` datetime DEFAULT NULL,
  `num_carte_reservation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`nom_salle`, `id`, `datetime_debut`, `datetime_fin`, `num_carte_reservation`) VALUES
('123', 6, '2001-01-01 02:20:00', '2001-01-01 03:40:00', 123);

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
  `prenom_reservation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations_materiel`
--

INSERT INTO `reservations_materiel` (`id_materiel`, `ref_materiel`, `designation`, `type_materiel`, `id`, `num_carte_reservation`, `datetime_reservation`, `datetime_reservation_fin`, `nom_reservation`, `prenom_reservation`) VALUES
(123456789, NULL, NULL, '123456789', 4, '1111111', '2001-01-01 08:20:00', '2001-01-01 10:20:00', 'and', 'lia');

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `type_salle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`nom_salle`, `type_salle`) VALUES
('1234', 'Salle gaming'),
('B202', 'Salle informati'),
('1', 'Salle de classe'),
('123', 'Salle de classe'),
('86787', 'Salle de classe');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reservations_materiel`
--
ALTER TABLE `reservations_materiel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
