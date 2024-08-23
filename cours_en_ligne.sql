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
(1, 'Licence Informatique', 'Formation en informatique et programmation', 'Actif', '2024-08-01 10:00:00', 'Alice Dupont', '2024-08-01 10:00:00', 'Alice Dupont', '0', '2024-08-01 10:00:00', 'Alice Dupont'),
(2, 'Master Data Science', 'Programme avancé en science des données', 'Actif', '2024-08-02 11:30:00', 'Bob Martin', '2024-08-02 11:30:00', 'Bob Martin', '0', '0000-00-00 00:00:00', ''),
(3, 'Licence Gestion', "Formation en gestion d'entreprise", 'Inactif', '2024-08-03 14:15:00', 'Claire Bernard', '2024-08-03 14:30:00', 'Claire Bernard', '1', '2024-08-03 14:45:00', 'Claire Bernard');

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
(1, 'password123', 'Actif', '2024-08-01 09:00:00', 'Alice Dupont', '2024-08-01 09:00:00', 'Alice Dupont', '0', '0000-00-00 00:00:00', '', 1, 1),
(2, 'mypassword', 'Actif', '2024-08-02 10:00:00', 'Bob Martin', '2024-08-02 10:00:00', 'Bob Martin', '0', '0000-00-00 00:00:00', '', 2, 2),
(3, 'securepass', 'Actif', '2024-08-03 11:00:00', 'Claire Bernard', '2024-08-03 11:00:00', 'Claire Bernard', '0', '0000-00-00 00:00:00', '', 3, 3);

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
(1, 'Introduction à la Programmation', '2024-08-15 08:00:00', NULL, 'intro_programmation.pdf', 'polytechnique.pdf', '', '', '', 'Actif', '2024-08-01 10:00:00', 'Alice Dupont', '2024-08-01 10:30:00', 'Alice Dupont', '0', '0000-00-00 00:00:00', '', 1, 1, 1),
(2, 'Analyse des Données', '2024-08-20 09:00:00', NULL, 'analyse_donnees.pdf', '', '', '', '', 'Actif', '2024-08-02 11:00:00', 'Bob Martin', '2024-08-02 11:30:00', 'Bob Martin', '0', '0000-00-00 00:00:00', '', 2, 2, 2),
(3, 'Gestion de Projet', '2024-08-25 13:00:00', '2024-09-25 13:00:00', 'gestion_projet.pdf', '', '', '', '', 'Inactif', '2024-08-03 14:00:00', 'Claire Bernard', '2024-08-03 14:30:00', 'Claire Bernard', '0', '0000-00-00 00:00:00', '', 3, 1, 3);

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
(1, 'ETU12345', '', 1, 1),
(2, 'ETU67890', '', 1, 2),
(3, 'ETU11223', '', 1, 3),
(4, 'ETU44556', '', 1, 4),
(5, 'ETU78901', '', 2, 5),
(6, 'ETU23456', '', 2, 6),
(7, 'ETU34567', '', 2, 7),
(8, 'ETU45678', '', 2, 8),
(9, 'ETU56789', '', 1, 9);

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
(1, 'Mathématiques', 'Calcul différentiel et intégral', 'Actif', '2024-07-01 08:00:00', 'Alice Dupont', '2024-07-01 08:00:00', 'Alice Dupont', '0', '0000-00-00 00:00:00', ''),
(2, 'Physique', 'Mécanique et électromagnétisme', 'Actif', '2024-07-10 09:00:00', 'Bob Martin', '2024-07-10 09:00:00', 'Bob Martin', '0', '0000-00-00 00:00:00', ''),
(3, 'Informatique', 'Algorithmes et structures de données', 'Actif', '2024-07-15 10:00:00', 'Claire Bernard', '2024-07-15 10:00:00', 'Claire Bernard', '0', '0000-00-00 00:00:00', ''),
(4, 'Économie', "Principes de base de l'économie", 'Inactif', '2024-07-20 11:00:00', 'Alice Dupont', '2024-07-20 11:00:00', 'Alice Dupont', '1', '2024-07-20 11:00:00', 'Alice Dupont');

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
(1, 'LEROY', 'Alice', 'alice.leroy@example.com', '0654781234', '123 Rue des Fleurs, Paris', 'F', '1990-05-12', 'default.jpg', 'Actif', '2024-08-01 09:00:00', 'admin', '2024-08-01 09:00:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(2, 'DUPONT', 'Marc', 'marc.dupont@example.com', '0612345678', '456 Avenue des Champs, Lyon', 'M', '1985-09-23', 'default.jpg', 'Actif', '2024-08-02 10:15:00', 'admin', '2024-08-02 10:15:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(3, 'MOREAU', 'Claire', 'claire.moreau@example.com', '0647859623', '789 Boulevard du Mont, Marseille', 'F', '1992-11-05', 'default.jpg', 'Actif', '2024-08-03 11:30:00', 'admin', '2024-08-03 11:30:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(4, 'GARCIA', 'Jean', 'jean.garcia@example.com', '0678452931', '321 Rue de la Paix, Bordeaux', 'M', '1988-12-17', 'default.jpg', 'Actif', '2024-08-04 12:45:00', 'admin', '2024-08-04 12:45:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(5, 'RODRIGUEZ', 'Sofia', 'sofia.rodriguez@example.com', '0687954623', '654 Rue des Écoles, Toulouse', 'F', '1994-02-20', 'default.jpg', 'Actif', '2024-08-05 14:00:00', 'admin', '2024-08-05 14:00:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(6, 'FERRAND', 'Lucas', 'lucas.ferrand@example.com', '0698765432', '987 Route de la Mer, Nice', 'M', '1991-03-18', 'default.jpg', 'En attente', '2024-08-06 15:15:00', 'admin', '2024-08-06 15:15:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(7, 'LECLERC', 'Emma', 'emma.leclerc@example.com', '0612389475', '234 Avenue des Alpes, Grenoble', 'F', '1993-06-30', 'default.jpg', 'En attente', '2024-08-07 16:30:00', 'admin', '2024-08-07 16:30:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(8, 'MARTIN', 'Julien', 'julien.martin@example.com', '0671234567', '456 Rue de la Liberté, Nantes', 'M', '1989-07-21', 'default.jpg', 'En attente', '2024-08-08 17:45:00', 'admin', '2024-08-08 17:45:00', 'admin', '1', '2024-08-08 17:45:00', 'admin'),
(9, 'ROUX', 'Amandine', 'amandine.roux@example.com', '0632145789', '789 Rue du Château, Lille', 'F', '1995-10-11', 'default.jpg', 'Actif', '2024-08-09 18:00:00', 'admin', '2024-08-09 18:00:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(10, 'LAMBERT', 'Paul', 'paul.lambert@example.com', '0623456789', '321 Avenue des Pyramides, Strasbourg', 'M', '1987-04-16', 'default.jpg', 'En attente', '2024-08-10 19:15:00', 'admin', '2024-08-10 19:15:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(11, 'GUILLOT', 'Nina', 'nina.guillot@example.com', '0654321098', '654 Rue de la Gare, Rennes', 'F', '1996-12-09', 'default.jpg', 'En attente', '2024-08-11 20:30:00', 'admin', '2024-08-11 20:30:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(12, 'DAVID', 'Maxime', 'maxime.david@example.com', '0678901234', '987 Route de la Côte, Montpellier', 'M', '1986-08-25', '4.jpg', 'Actif', '2024-08-12 21:45:00', 'admin', '2024-08-12 21:45:00', 'admin', '0', '0000-00-00 00:00:00', ''),
(13, 'BENOIT', 'Alice', 'alice.benoit@example.com', '0667890123', '123 Rue de la Mer, Aix-en-Provence', 'F', '1992-07-15', 'default.jpg', 'Inactif', '2024-08-13 22:00:00', 'admin', '2024-08-13 22:00:00', 'admin', '0', '0000-00-00 00:00:00', '');

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
(1, 'Spécialiste en Mathématiques', 3, 1),
(2, 'Expert en Littérature', 4, 2),
(3, 'Enseignant en Physique', 12, 3);

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
(1, 'Absences non justifiées', 'Non lu', '2024-08-15 09:00:00', 'admin', '2024-08-15 09:00:00', 'admin', '0', '0000-00-00 00:00:00', '', 9, 1),
(2, 'Comportement perturbateur en classe', 'Non lu', '2024-08-16 10:30:00', 'admin', '2024-08-16 10:30:00', 'admin', '0', '0000-00-00 00:00:00', '', 5, 2),
(3, 'Devoirs non remis à temps', 'Non lu', '2024-08-17 14:00:00', 'admin', '2024-08-17 14:00:00', 'admin', '0', '0000-00-00 00:00:00', '', 7, 3);

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
