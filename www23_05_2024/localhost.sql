-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 23 mai 2024 à 20:01
-- Version du serveur : 10.5.20-MariaDB
-- Version de PHP : 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `id22077870_siteweb`
--
CREATE DATABASE IF NOT EXISTS `id22077870_siteweb` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `id22077870_siteweb`;

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `id` int(11) NOT NULL,
  `datedefin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `activites`
--

CREATE TABLE `activites` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `activites`
--

INSERT INTO `activites` (`id`, `nom`) VALUES
(1, 'Course à pieds'),
(2, 'Cinéma'),
(3, 'Lecture'),
(4, 'Voyages'),
(5, 'Jeux vidéo'),
(6, 'Natation'),
(7, 'Judo'),
(8, 'Basket'),
(9, 'Foot'),
(10, 'Velo');

-- --------------------------------------------------------

--
-- Structure de la table `ban`
--

CREATE TABLE `ban` (
  `emailban` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ban`
--

INSERT INTO `ban` (`emailban`) VALUES
('biwa.nakime@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

CREATE TABLE `consultation` (
  `id` varchar(255) NOT NULL,
  `consult` int(11) NOT NULL,
  `jour` date NOT NULL,
  `idvew` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `consultation`
--

INSERT INTO `consultation` (`id`, `consult`, `jour`, `idvew`) VALUES
('3', 9, '2024-05-17', '3'),
('2', 2, '2024-05-17', '3'),
('3', 24, '2024-05-18', '3'),
('3', 1, '2024-05-18', '2'),
('3', 41, '2024-05-19', '3'),
('3', 3, '2024-05-19', '2'),
('6', 4, '2024-05-19', '6'),
('6', 1, '2024-05-19', '2'),
('6', 1, '2024-05-19', '3'),
('6', 1, '2024-05-19', '1'),
('6', 1, '2024-05-19', '5'),
('6', 1, '2024-05-19', '4'),
('3', 1, '2024-05-19', '6'),
('3', 3, '2024-05-20', '6'),
('3', 5, '2024-05-20', '3'),
('3', 2, '2024-05-20', '2'),
('3', 32, '2024-05-21', '3'),
('3', 1, '2024-05-21', '6'),
('3', 27, '2024-05-21', '5'),
('3', 6, '2024-05-22', '3'),
('3', 1, '2024-05-22', '6'),
('4', 1, '2024-05-22', '4'),
('4', 2, '2024-05-22', '1'),
('4', 1, '2024-05-23', '4'),
('3', 1, '2024-05-23', '3');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `idconversation` int(11) NOT NULL,
  `ordre` int(11) NOT NULL,
  `contenue` text NOT NULL,
  `idtalker` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messagerie`
--

CREATE TABLE `messagerie` (
  `idconversation` int(11) NOT NULL,
  `id1` varchar(255) NOT NULL,
  `id2` varchar(255) NOT NULL,
  `blocage` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `messagerie`
--

INSERT INTO `messagerie` (`idconversation`, `id1`, `id2`, `blocage`) VALUES
(1, '3', '6', 0),
(2, '3', '1', 1),
(3, '3', '4', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Signalement`
--

CREATE TABLE `Signalement` (
  `ident` int(11) NOT NULL,
  `idée` int(11) NOT NULL,
  `raison` text NOT NULL,
  `traité` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `Signalement`
--

INSERT INTO `Signalement` (`ident`, `idée`, `raison`, `traité`) VALUES
(3, 0, 'Pas cool', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `vua` int(2) NOT NULL DEFAULT 0,
  `des` text DEFAULT NULL,
  `acts` text DEFAULT NULL,
  `gif1` varchar(255) DEFAULT NULL,
  `gif2` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `photo1` varchar(255) DEFAULT NULL,
  `photo2` varchar(255) DEFAULT NULL,
  `photo3` varchar(255) DEFAULT NULL,
  `photo4` varchar(255) DEFAULT NULL,
  `photo5` varchar(255) DEFAULT NULL,
  `photo6` varchar(255) DEFAULT NULL,
  `photo7` varchar(255) DEFAULT NULL,
  `langage` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `Nom`, `Prenom`, `age`, `mail`, `password`, `vua`, `des`, `acts`, `gif1`, `gif2`, `photo`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`, `photo6`, `photo7`, `langage`) VALUES
(3, 'Bluteau', 'Corentin', 14, 'bluteaucor@cy-tech.fr', '$2y$10$EFr1tU9ygu3c6ybiR.xigughADz8ozjzGc/JgL5o4JyCaYzSTHSDC', 2, 'Bonjour j\'adore la vie', '1', '2.gif', '2.gif', 'img/3_photo.jpg', 'img/3_photo1.jpg', 'img/3_photo2.jpg', 'img/3_photo3.jpg', 'img/3_photo4.jpg', 'img/3_photo5.jpg', 'img/3_photo6.jpg', 'img/3_photo7.jpg', 'C'),
(6, 'laute', 'matis', 19, 'dr.jilanor@gmail.com', '$2y$10$6Q6w/bJgSNjjr3haj8MQt.D3Cet5S7qFsOe2c62inrFo7MpGaGyzW', 0, 'J\'aime le JavaScript car j\'aime soufrir', '5', NULL, NULL, 'img/6_photo.jpg', 'img/6_photo1.jpg', 'img/6_photo2.jpg', NULL, NULL, NULL, NULL, NULL, 'JavaScript'),
(8, 'Andrianavalona', 'Timothé', 20, 'tim.andria@gmail.com', '$2y$10$iRGtLfFgT2JyUdHJYqsR0e66PUGKkuf2F21uVwLzyC99D97xdVbsC', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activites`
--
ALTER TABLE `activites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messagerie`
--
ALTER TABLE `messagerie`
  ADD PRIMARY KEY (`idconversation`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activites`
--
ALTER TABLE `activites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `messagerie`
--
ALTER TABLE `messagerie`
  MODIFY `idconversation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
