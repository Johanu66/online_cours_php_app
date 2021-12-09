-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 28 août 2021 à 14:41
-- Version du serveur :  10.1.30-MariaDB
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cours_en_ligne`
--

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `id_classe` int(11) NOT NULL,
  `nom_classe` text NOT NULL,
  `desc_classe` text NOT NULL,
  `statut_classe` enum('Actif','Inactif') NOT NULL,
  `date_create_classe` datetime NOT NULL,
  `user_create_classe` text NOT NULL,
  `date_last_modif_classe` datetime NOT NULL,
  `user_last_modif_classe` text NOT NULL,
  `del_classe` enum('0','1') NOT NULL DEFAULT '0',
  `date_del_classe` datetime NOT NULL,
  `user_del_classe` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`id_classe`, `nom_classe`, `desc_classe`, `statut_classe`, `date_create_classe`, `user_create_classe`, `date_last_modif_classe`, `user_last_modif_classe`, `del_classe`, `date_del_classe`, `user_del_classe`) VALUES
(1, 'Licence3', 'Rien', 'Actif', '2021-08-19 14:27:50', 'GANDONOU Johanu', '2021-08-19 14:27:50', 'GANDONOU Johanu', '0', '2021-08-19 14:33:42', 'GANDONOU Johanu'),
(2, 'Licence2', 'qsdfghjkl', 'Actif', '2021-08-19 18:55:29', 'GANDONOU Johanu', '2021-08-19 18:55:29', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', ''),
(3, 'Licence2', 'hvhvhvhvhvh', 'Inactif', '2021-08-28 14:24:53', 'GANDONOU Johanu', '2021-08-28 14:25:41', 'GANDONOU Johanu', '1', '2021-08-28 14:25:54', 'GANDONOU Johanu');

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id_compte` int(11) NOT NULL,
  `mdp_compte` text NOT NULL,
  `statut_compte` enum('Actif','Inactif') NOT NULL,
  `date_create_compte` datetime NOT NULL,
  `user_create_compte` text NOT NULL,
  `date_last_modif_compte` datetime NOT NULL,
  `user_last_modif_compte` text NOT NULL,
  `del_compte` enum('0','1') NOT NULL DEFAULT '0',
  `date_del_compte` datetime NOT NULL,
  `user_del_compte` text NOT NULL,
  `id_personne_fk_compte` int(11) NOT NULL,
  `id_type_compte_fk_compte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id_compte`, `mdp_compte`, `statut_compte`, `date_create_compte`, `user_create_compte`, `date_last_modif_compte`, `user_last_modif_compte`, `del_compte`, `date_del_compte`, `user_del_compte`, `id_personne_fk_compte`, `id_type_compte_fk_compte`) VALUES
(1, '1234', 'Actif', '2021-08-28 00:00:00', '', '2021-08-28 00:00:00', '', '0', '0000-00-00 00:00:00', '', 1, 1),
(2, '1234', 'Actif', '2021-08-28 11:25:41', '', '2021-08-28 11:25:41', '', '0', '0000-00-00 00:00:00', '', 2, 3),
(3, '1234', 'Actif', '2021-08-28 11:34:56', 'GANDONOU Johanu', '2021-08-28 11:34:56', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', '', 3, 2),
(4, '1234', 'Actif', '2021-08-28 11:55:40', 'GANDONOU Johanu', '2021-08-28 11:55:40', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', '', 4, 2),
(5, '1234', 'Actif', '2021-08-28 11:59:25', 'GANDONOU Johanu', '2021-08-28 11:59:25', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', '', 5, 3),
(6, '1234', 'Actif', '2021-08-28 12:03:21', '', '2021-08-28 12:03:21', '', '0', '0000-00-00 00:00:00', '', 6, 3),
(7, '1234', 'Actif', '2021-08-28 12:12:43', '', '2021-08-28 12:12:43', '', '0', '0000-00-00 00:00:00', '', 7, 3),
(8, '1234', 'Actif', '2021-08-28 12:14:57', '', '2021-08-28 12:14:57', '', '0', '0000-00-00 00:00:00', '', 8, 3),
(9, '1234', 'Actif', '2021-08-28 12:45:36', '', '2021-08-28 12:45:36', '', '0', '0000-00-00 00:00:00', '', 9, 3),
(10, '1234', 'Actif', '2021-08-28 13:05:00', '', '2021-08-28 13:05:00', '', '0', '0000-00-00 00:00:00', '', 10, 3),
(11, '1234', 'Actif', '2021-08-28 14:06:25', '', '2021-08-28 14:06:25', '', '0', '0000-00-00 00:00:00', '', 11, 3),
(12, '1234', 'Actif', '2021-08-28 14:20:08', 'GANDONOU Johanu', '2021-08-28 14:20:08', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', '', 12, 2),
(13, '1234', 'Actif', '2021-08-28 14:22:38', 'GANDONOU Johanu', '2021-08-28 14:22:38', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', '', 13, 3);

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id_cours` int(11) NOT NULL,
  `intitule_cours` text NOT NULL,
  `date_debut_cours` datetime NOT NULL,
  `date_fin_cours` datetime DEFAULT NULL,
  `fichier_1_cours` text NOT NULL,
  `fichier_2_cours` text NOT NULL,
  `fichier_3_cours` text NOT NULL,
  `fichier_4_cours` text NOT NULL,
  `notes_cours` text NOT NULL,
  `statut_cours` enum('Actif','Inactif') NOT NULL,
  `date_create_cours` datetime NOT NULL,
  `user_create_cours` text NOT NULL,
  `date_last_modif_cours` datetime NOT NULL,
  `user_last_modif_cours` text NOT NULL,
  `del_cours` enum('0','1') NOT NULL,
  `date_del_cours` datetime NOT NULL,
  `user_del_cours` text NOT NULL,
  `id_matiere_fk_cours` int(11) NOT NULL,
  `id_classe_fk_cours` int(11) NOT NULL,
  `id_professeur_fk_cours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id_cours`, `intitule_cours`, `date_debut_cours`, `date_fin_cours`, `fichier_1_cours`, `fichier_2_cours`, `fichier_3_cours`, `fichier_4_cours`, `notes_cours`, `statut_cours`, `date_create_cours`, `user_create_cours`, `date_last_modif_cours`, `user_last_modif_cours`, `del_cours`, `date_del_cours`, `user_del_cours`, `id_matiere_fk_cours`, `id_classe_fk_cours`, `id_professeur_fk_cours`) VALUES
(1, 'aaaaaaaa', '2021-07-27 10:51:00', NULL, 'document.pdf', 'polyAnaNum.pdf', '', '452-fonds-decran-hd-voiture-de-sport.jpg', '', 'Actif', '2021-08-28 11:53:28', 'GANDONOU Johanu', '2021-08-28 11:54:20', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', '', 1, 2, 1),
(2, 'bbbbbbbb', '2021-08-03 10:56:00', NULL, 'Web 1920 – 1.pdf', '', '', '', '', 'Actif', '2021-08-28 11:57:05', 'GANDONOU Johanu', '2021-08-28 11:57:42', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', '', 2, 2, 2),
(3, 'ccccccccc', '2021-08-04 11:01:00', '2021-09-04 11:01:00', 'Web 1920 – 1.pdf', '', '', '', '', 'Inactif', '2021-08-28 12:01:54', 'Johanu1 GANDONOU', '2021-08-28 12:01:54', 'Johanu1 GANDONOU', '0', '0000-00-00 00:00:00', '', 2, 1, 1),
(4, 'ddddddd', '2021-08-11 13:07:00', NULL, '', '', '', '', '', 'Inactif', '2021-08-28 14:07:39', 'GANDONOU Johanu', '2021-08-28 14:07:39', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', '', 1, 1, 1),
(5, 'wexrctvybun255', '2021-07-28 13:16:00', '2021-07-27 13:16:00', '2.jpg', '', '', '', '', 'Inactif', '2021-08-28 14:16:43', 'GANDONOU Johanu', '2021-08-28 14:17:28', 'GANDONOU Johanu', '1', '2021-08-28 14:18:52', 'GANDONOU Johanu', 2, 1, 2),
(6, 'tttttttt', '2021-08-04 13:30:00', NULL, '', '', '', '', '', 'Actif', '2021-08-28 14:30:26', 'Johanu1 GANDONOU', '2021-08-28 14:30:26', 'Johanu1 GANDONOU', '0', '0000-00-00 00:00:00', '', 2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id_etudiant` int(11) NOT NULL,
  `matricule_etudiant` text NOT NULL,
  `notes_etudiant` text NOT NULL,
  `id_classe_fk_etudiant` int(11) NOT NULL,
  `id_personne_fk_etudiant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etudiant`, `matricule_etudiant`, `notes_etudiant`, `id_classe_fk_etudiant`, `id_personne_fk_etudiant`) VALUES
(1, '13871820', '', 2, 2),
(2, '555555', '', 2, 5),
(3, '22222222', '', 2, 6),
(4, '444444', '', 2, 7),
(5, '555555', '', 1, 8),
(6, '00000', '', 2, 9),
(7, '138718209', '', 2, 10),
(8, '55555555555555', '', 2, 11),
(9, '555555551', '', 1, 13);

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id_matiere` int(11) NOT NULL,
  `nom_matiere` text NOT NULL,
  `desc_matiere` text NOT NULL,
  `statut_matiere` enum('Actif','Inactif') NOT NULL,
  `date_create_matiere` datetime NOT NULL,
  `user_create_matiere` text NOT NULL,
  `date_last_modif_matiere` datetime NOT NULL,
  `user_last_modif_matiere` text NOT NULL,
  `del_matiere` enum('0','1') NOT NULL DEFAULT '0',
  `date_del_matiere` datetime NOT NULL,
  `user_del_matiere` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`id_matiere`, `nom_matiere`, `desc_matiere`, `statut_matiere`, `date_create_matiere`, `user_create_matiere`, `date_last_modif_matiere`, `user_last_modif_matiere`, `del_matiere`, `date_del_matiere`, `user_del_matiere`) VALUES
(1, 'Anglais', 'Rien', 'Actif', '2021-08-16 00:00:00', '', '2021-08-16 00:00:00', '', '0', '2021-08-18 19:14:15', 'GANDONOU Johanu'),
(2, 'SVT', 'azertyuio111', 'Inactif', '2021-08-18 18:35:03', 'GANDONOU Johanu', '2021-08-18 19:28:16', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', ''),
(3, 'Histoire Géographie ', 'zertyuio1212', 'Actif', '2021-08-19 18:54:40', 'GANDONOU Johanu', '2021-08-19 18:54:59', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', ''),
(4, 'jvjvjvv', 'wxcvklkjhgfd', 'Actif', '2021-08-28 14:26:23', 'GANDONOU Johanu', '2021-08-28 14:26:45', 'GANDONOU Johanu', '1', '2021-08-28 14:26:52', 'GANDONOU Johanu');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `id_personne` int(11) NOT NULL,
  `nom_personne` text NOT NULL,
  `prenom_personne` text NOT NULL,
  `email_personne` text NOT NULL,
  `tel_personne` text NOT NULL,
  `adresse_personne` text NOT NULL,
  `sexe_personne` enum('-','M','F') NOT NULL,
  `date_naissance_personne` date NOT NULL,
  `photo_personne` text NOT NULL,
  `statut_personne` enum('Actif','Inactif','En attente') NOT NULL,
  `date_create_personne` datetime NOT NULL,
  `user_create_personne` text NOT NULL,
  `date_last_modif_personne` datetime NOT NULL,
  `user_last_modif_personne` text NOT NULL,
  `del_personne` enum('0','1') NOT NULL DEFAULT '0',
  `date_del_personne` datetime NOT NULL,
  `user_del_personne` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`id_personne`, `nom_personne`, `prenom_personne`, `email_personne`, `tel_personne`, `adresse_personne`, `sexe_personne`, `date_naissance_personne`, `photo_personne`, `statut_personne`, `date_create_personne`, `user_create_personne`, `date_last_modif_personne`, `user_last_modif_personne`, `del_personne`, `date_del_personne`, `user_del_personne`) VALUES
(1, 'GANDONOU', 'Johanu', 'admin@gmail.com', '64978512', 'Calavi', 'M', '2021-08-01', 'default.jpg', 'Actif', '2021-08-28 00:00:00', '', '2021-08-28 00:00:00', '', '0', '0000-00-00 00:00:00', ''),
(2, 'Johanu', 'GANDONOU', 'etudiant@gmail.com', '61149072', '', 'M', '2021-08-18', 'default.jpg', 'Actif', '2021-08-28 11:25:41', '', '2021-08-28 11:25:41', '', '0', '0000-00-00 00:00:00', ''),
(3, 'Johanu1', 'GANDONOU', 'prof@gmail.com', '61149072', '', 'F', '0000-00-00', 'default.jpg', 'Actif', '2021-08-28 11:34:56', 'GANDONOU Johanu', '2021-08-28 11:34:56', 'GANDONOU Johanu', '0', '2021-08-28 11:35:22', 'GANDONOU Johanu'),
(4, 'Johanu2', 'GANDONOU', 'prof2@gmail.com', '61149072', '', 'M', '0000-00-00', 'default.jpg', 'Actif', '2021-08-28 11:55:40', 'GANDONOU Johanu', '2021-08-28 11:55:40', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', ''),
(5, 'Johanu', 'GANDONOU', 'etudiant1@gmail.com', '61149072', '', 'M', '2021-08-12', '1.jpg', 'Actif', '2021-08-28 11:59:25', 'GANDONOU Johanu', '2021-08-28 11:59:25', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', ''),
(6, 'Johanu', 'GANDONOU', 'etudiant2@gmail.com', '61149072', '', 'M', '2021-08-09', 'default.jpg', 'En attente', '2021-08-28 12:03:21', '', '2021-08-28 12:03:21', '', '0', '0000-00-00 00:00:00', ''),
(7, 'Johanu4', 'GANDONOU', 'etudiant3@gmail.com', '464649413', '', 'M', '2021-08-18', 'default.jpg', 'En attente', '2021-08-28 12:12:43', '', '2021-08-28 12:12:43', '', '0', '0000-00-00 00:00:00', ''),
(8, 'Delphine', 'TOVIEGBE', 'etudiant4@gmail.com', '7461636', '', 'M', '2021-07-26', 'default.jpg', 'En attente', '2021-08-28 12:14:57', '', '2021-08-28 12:14:57', '', '1', '2021-08-28 14:21:26', 'GANDONOU Johanu'),
(9, 'Johanu5', 'GANDONOU', 'etudiant0@gmail.com', '61149072', '', 'F', '2021-08-17', 'default.jpg', 'Actif', '2021-08-28 12:45:36', '', '2021-08-28 12:45:36', '', '0', '0000-00-00 00:00:00', ''),
(10, 'Johanu', 'GANDONOU', 'johanugandonou@gmail.com', '61149072', '', 'F', '2021-08-18', 'default.jpg', 'En attente', '2021-08-28 13:05:00', '', '2021-08-28 13:05:00', '', '0', '0000-00-00 00:00:00', ''),
(11, 'Johanu', 'GANDONOU', 'etu@gmail.com', '61149072', '', 'M', '2021-08-17', 'default.jpg', 'En attente', '2021-08-28 14:06:25', '', '2021-08-28 14:06:25', '', '0', '0000-00-00 00:00:00', ''),
(12, 'GANDONOU2', 'Johanu', 'abc@gmail.com', '61149072', '', 'M', '0000-00-00', '4.jpg', 'Actif', '2021-08-28 14:20:08', 'GANDONOU Johanu', '2021-08-28 14:20:41', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', ''),
(13, 'Johanu', 'GANDONOU', 'hvvhvh@gmail.com', '61149072', '', 'M', '2021-08-04', 'default.jpg', 'Inactif', '2021-08-28 14:22:38', 'GANDONOU Johanu', '2021-08-28 14:23:05', 'GANDONOU Johanu', '0', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE `professeur` (
  `id_professeur` int(11) NOT NULL,
  `notes_professeur` text NOT NULL,
  `id_personne_fk_professeur` int(11) NOT NULL,
  `id_matiere_fk_professeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`id_professeur`, `notes_professeur`, `id_personne_fk_professeur`, `id_matiere_fk_professeur`) VALUES
(1, '', 3, 3),
(2, '', 4, 2),
(3, '', 12, 2);

-- --------------------------------------------------------

--
-- Structure de la table `signale`
--

CREATE TABLE `signale` (
  `id_signale` int(11) NOT NULL,
  `motif_signale` text NOT NULL,
  `statut_signale` enum('Non lu','Lu') NOT NULL,
  `date_create_signale` datetime NOT NULL,
  `user_create_signale` text NOT NULL,
  `date_last_modif_signale` datetime NOT NULL,
  `user_last_modif_signale` text NOT NULL,
  `del_signale` enum('0','1') NOT NULL,
  `date_del_signale` datetime NOT NULL,
  `user_del_signale` text NOT NULL,
  `id_etudiant_fk_signale` int(11) NOT NULL,
  `id_professeur_fk_signale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `signale`
--

INSERT INTO `signale` (`id_signale`, `motif_signale`, `statut_signale`, `date_create_signale`, `user_create_signale`, `date_last_modif_signale`, `user_last_modif_signale`, `del_signale`, `date_del_signale`, `user_del_signale`, `id_etudiant_fk_signale`, `id_professeur_fk_signale`) VALUES
(1, 'xcfghjklmpoiuy', 'Non lu', '2021-08-28 14:31:06', 'Johanu1 GANDONOU', '2021-08-28 14:31:06', 'Johanu1 GANDONOU', '0', '0000-00-00 00:00:00', '', 9, 1),
(2, 'hjbkbbk', 'Non lu', '2021-08-28 14:33:52', 'Johanu1 GANDONOU', '2021-08-28 14:33:52', 'Johanu1 GANDONOU', '0', '0000-00-00 00:00:00', '', 9, 1),
(3, 'kpkpkkp', 'Non lu', '2021-08-28 14:36:19', 'Johanu1 GANDONOU', '2021-08-28 14:36:19', 'Johanu1 GANDONOU', '0', '0000-00-00 00:00:00', '', 9, 1);

-- --------------------------------------------------------

--
-- Structure de la table `type_compte`
--

CREATE TABLE `type_compte` (
  `id_type_compte` int(11) NOT NULL,
  `lib_type_compte` text NOT NULL,
  `statut_type_compte` enum('Actif','Inactif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type_compte`
--

INSERT INTO `type_compte` (`id_type_compte`, `lib_type_compte`, `statut_type_compte`) VALUES
(1, 'admin', 'Actif'),
(2, 'professeur', 'Actif'),
(3, 'étudiant', 'Actif');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id_classe`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id_compte`),
  ADD KEY `id_personne_fk_compte` (`id_personne_fk_compte`),
  ADD KEY `id_type_compte_fk_compte` (`id_type_compte_fk_compte`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id_cours`),
  ADD KEY `id_professeur_fk_cours` (`id_professeur_fk_cours`),
  ADD KEY `id_classe_fk_cours` (`id_classe_fk_cours`),
  ADD KEY `id_matiere_fk_cours` (`id_matiere_fk_cours`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id_etudiant`),
  ADD KEY `id_classe_fk_etudiant` (`id_classe_fk_etudiant`),
  ADD KEY `id_personne_fk_etudiant` (`id_personne_fk_etudiant`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id_matiere`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`id_personne`);

--
-- Index pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD PRIMARY KEY (`id_professeur`),
  ADD KEY `id_personne_fk_professeur` (`id_personne_fk_professeur`),
  ADD KEY `id_matiere_fk_professeur` (`id_matiere_fk_professeur`);

--
-- Index pour la table `signale`
--
ALTER TABLE `signale`
  ADD PRIMARY KEY (`id_signale`),
  ADD KEY `id_etudiant_fk_signale` (`id_etudiant_fk_signale`),
  ADD KEY `id_professeur_fk_signale` (`id_professeur_fk_signale`);

--
-- Index pour la table `type_compte`
--
ALTER TABLE `type_compte`
  ADD PRIMARY KEY (`id_type_compte`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `id_classe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `id_compte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id_cours` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id_etudiant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id_matiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `id_personne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `professeur`
--
ALTER TABLE `professeur`
  MODIFY `id_professeur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `signale`
--
ALTER TABLE `signale`
  MODIFY `id_signale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `type_compte`
--
ALTER TABLE `type_compte`
  MODIFY `id_type_compte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `id_personne_fk_compte` FOREIGN KEY (`id_personne_fk_compte`) REFERENCES `personne` (`id_personne`),
  ADD CONSTRAINT `id_type_compte_fk_compte` FOREIGN KEY (`id_type_compte_fk_compte`) REFERENCES `type_compte` (`id_type_compte`);

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `cours_ibfk_1` FOREIGN KEY (`id_classe_fk_cours`) REFERENCES `classe` (`id_classe`),
  ADD CONSTRAINT `cours_ibfk_2` FOREIGN KEY (`id_matiere_fk_cours`) REFERENCES `matiere` (`id_matiere`),
  ADD CONSTRAINT `cours_ibfk_3` FOREIGN KEY (`id_professeur_fk_cours`) REFERENCES `professeur` (`id_professeur`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`id_personne_fk_etudiant`) REFERENCES `personne` (`id_personne`),
  ADD CONSTRAINT `etudiant_ibfk_2` FOREIGN KEY (`id_classe_fk_etudiant`) REFERENCES `classe` (`id_classe`);

--
-- Contraintes pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD CONSTRAINT `professeur_ibfk_1` FOREIGN KEY (`id_matiere_fk_professeur`) REFERENCES `matiere` (`id_matiere`),
  ADD CONSTRAINT `professeur_ibfk_2` FOREIGN KEY (`id_personne_fk_professeur`) REFERENCES `personne` (`id_personne`);

--
-- Contraintes pour la table `signale`
--
ALTER TABLE `signale`
  ADD CONSTRAINT `signale_ibfk_1` FOREIGN KEY (`id_etudiant_fk_signale`) REFERENCES `etudiant` (`id_etudiant`),
  ADD CONSTRAINT `signale_ibfk_2` FOREIGN KEY (`id_professeur_fk_signale`) REFERENCES `professeur` (`id_professeur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
