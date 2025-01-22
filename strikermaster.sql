-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 22 jan. 2025 à 09:59
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `strikermaster`
--

-- --------------------------------------------------------

--
-- Structure de la table `calendrier`
--

DROP TABLE IF EXISTS `calendrier`;
CREATE TABLE IF NOT EXISTS `calendrier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_event` varchar(255) NOT NULL,
  `type_event` enum('match','tournois','galas') NOT NULL,
  `date_event` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `calendrier`
--

INSERT INTO `calendrier` (`id`, `nom_event`, `type_event`, `date_event`) VALUES
(11, 'ezfze', '', '3233-02-23'),
(10, 'test', 'galas', '2001-11-11'),
(22, 'k6', 'tournois', '2025-02-12'),
(20, 'leMatch', 'match', '2222-02-22');

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_inscription` (`user_id`,`event_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`id`, `user_id`, `event_id`) VALUES
(1, 9, 1),
(2, 9, 2),
(3, 9, 5),
(4, 14, 5),
(5, 10, 2),
(6, 10, 6),
(7, 17, 5),
(8, 18, 7),
(9, 17, 7),
(10, 17, 9),
(11, 49, 9),
(12, 51, 20),
(13, 51, 22),
(14, 51, 10);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','member') NOT NULL DEFAULT 'member',
  `profile_photo` varchar(255) DEFAULT NULL,
  `victoire_gala` int DEFAULT '0',
  `victoire_tournois` int DEFAULT '0',
  `victoire_match` int DEFAULT '0',
  `dossier` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `profile_photo`, `victoire_gala`, `victoire_tournois`, `victoire_match`, `dossier`) VALUES
(28, 'Ewan', '$2y$10$n2qlLOtIyj5JrqMAkSbLfO7ncMLPGhkY3/QoNpoYYVkebAs6K60T2', 'Ewan@gmail.com', 'member', NULL, 2, 0, 6, NULL),
(26, 'Louise', '$2y$10$ngsO8m0uizgHn4.66ZLgHOMSjYlCkpIqd6oqiwe.1ws0iQdCVOtVC', 'louise@gmail.com', 'member', NULL, 9, 3, 6, NULL),
(25, 'Eliot', '$2y$10$kcYyL3Bzam4bSr5GWc9lG.Expt0IU8Kj7UCRUUEqNwCczbZZclR3K', 'eliot@gmail.com', 'member', NULL, 6, 0, 1, NULL),
(24, 'Romain', '$2y$10$pgmeMLdcz7ii4zbKhCKpuOobAL7WjaeBUmcbfd..ySN8lUsaeMgNC', 'romain@gmail.com', 'member', NULL, 6, 5, 0, NULL),
(22, 'Sefer', '$2y$10$NVR5zeEyRc0yWLrICqDrOeREFgC3EZyedSYho8MtpHgYjkpfIhrkG', 'Sefer@gmail.com', 'admin', NULL, 3, 9, 9, NULL),
(23, 'Leanne', '$2y$10$1DoFSMrnsal5YJx/hNSB4.ORBWcFfWZlI0SMMp6TdGJiI8G0cFPTS', 'Leanne@gmail.com', 'member', NULL, 0, 7, 1, NULL),
(21, 'Elwyn', '$2y$10$AVi8o5/Tx4Q7gmm0vVdw5.OEj4OJBWDd1v/T7vmCpKajmt8E6ve6.', 'elwyn@gmail.com', 'member', NULL, 2, 0, 1, NULL),
(18, 'Felipe', '$2y$10$o84LrAn81cm7/IHetgHURe3s8cShfucCG8UGBrvEumXOEv0KeTNiS', 'Felipe@gmail.com', 'member', NULL, 7, 0, 4, NULL),
(19, 'Matheo H', '$2y$10$0h0gnLWFqT7BMzjgeV.1nucTIISVjY1FrMZp7Ys4p/1dD4eNBAG.y', 'matheo@gmail.com', 'member', NULL, 8, 6, 0, NULL),
(27, 'Mehdi', '$2y$10$Fkrz2.sCcTyDCRX9fTf7KOv.oycQwbAyiKrYR4hWGiZ6IrZqGO1W.', 'mehdi@gmail.com', 'member', NULL, 1, 9, 6, NULL),
(20, 'Matheo C', '$2y$10$GieXQO23lyPRutOT000w0.gRezi1dbbtRa9M2w30P2VuIhQvVD4ti', 'mat@gmail.com', 'member', NULL, 6, 3, 6, NULL),
(17, 'Milan.Matejka', '$2y$10$aAnawyJ8TBJdgMLj0AORaO0f5RYY87JEmW3BvBkNUbnFMi8ts931a', 'MilanMatejka38@gmail.com', 'admin', 'uploads/profile_photos/Milan.Matejka.jpg', 6, 7, 1, NULL),
(29, 'Jeremie', '$2y$10$7k0OSg6Hpf/KTDUnyeIQRe8Z4YIxYVdS/2XYCI2ucMmuZGotnKaHa', 'Jeremie@gmail.com', 'member', NULL, 5, 1, 3, NULL),
(30, 'Louis', '$2y$10$bEp1mVl7fU5jQqAMCAme1OPa99fLy5ztqyHqvEDZKPGQOugXVVmCC', 'louis@gmail.com', 'member', NULL, 5, 9, 5, NULL),
(31, 'Killian', '$2y$10$9dWJpAfwm0VPsEKTCtYwwOgk326SL.Dkth68sIyVKucZVEN41F4nq', 'killian@gmail.com', 'member', NULL, 2, 0, 3, NULL),
(32, 'Thomas', '$2y$10$fSgQCVhbtMAkLL5IyfSBvuVoNx83W4Y2IUxS1Rrk4gLFlxmNrDZky', 'thomas@gmail.com', 'member', NULL, 0, 7, 1, NULL),
(33, 'Mathis.Martin', '$2y$10$/MDv4eJQ4j9Rhm2bTuMH4OT3Xv9Dqb/QL0Y.hiYfGJG6NsE6MmBCe', 'Mathis.Martin@gmail.com', 'member', NULL, 3, 9, 3, NULL),
(34, 'Simon', '$2y$10$nxB9FBw/pu57M8/nYMGSYeyGUzw3ocDrXiYmS6Lj/a6FFUVs7sRGu', 'simon@gmail.com', 'member', NULL, 5, 9, 6, NULL),
(35, 'Mohamed', '$2y$10$OFFH6mn1RgaDetuGO7VQQewPqft08Ya2pxRDoI1qaCv2Xnw9w3iu2', 'mohamed@gmail.com', 'member', NULL, 7, 3, 9, NULL),
(36, 'Chayimaa', '$2y$10$1BHjX953OLrGr1nsqUJiEe1PASCGx9UXocSSTY1ytSvB0Nu7yyFfm', 'chayimaa@gmail.com', 'member', NULL, 7, 2, 9, NULL),
(37, 'Ayat', '$2y$10$/kiOkUS5pU3aN5WkI4Vlnevc.w7hkKe...J173.FuqFBQF0VOQMHW', 'ayat@gmail.com', 'member', NULL, 6, 3, 4, NULL),
(38, 'Quanq-liem', '$2y$10$wi1DxufhR8bLWrb5GZBf.OkXzW0y4oeVRrP0Q4dSzn2D8VZr.zjPi', 'QUANG-LIEM@gmail.com', 'member', NULL, 1, 4, 9, NULL),
(39, 'Tom', '$2y$10$1ynX0TNiAu4sRcSZFOnJw.a3jM9QfimSMzXTN12XmO1e7d/AJpePK', 'TOM@gmail.com', 'member', NULL, 0, 5, 1, NULL),
(40, 'Johan', '$2y$10$LKjiTCMfGu2PcSyvfroEO.41.oHy6GY1Sm49CFsuYGx0R8Yy/DdPe', 'johan@gmail.com', 'member', NULL, 4, 9, 4, NULL),
(41, 'Florentin', '$2y$10$oS6P8doNS0dRb5sLmRV5suu8rV4G1pyKHU.zIx0Nz9H6IZeNb3Ezm', 'FLORENTIN@gmail.com', 'member', NULL, 3, 6, 7, NULL),
(42, 'Clement', '$2y$10$LCnlA33XcaWfo0OaVQgxg.jGUzEsFKH.5Nzgeooa1b8B/I1.FLlja', 'CLEMENT@gmail.com', 'member', NULL, 2, 8, 1, NULL),
(43, 'Martin', '$2y$10$B8VqJGSCBIzZhOCmvFfFY.BAcauqQ1GljClE6JpfblYAQC2hfaxem', 'Martin@gmail.com', 'member', NULL, 9, 4, 2, NULL),
(44, 'Alexendre', '$2y$10$GcUmEnkrhj/dAIfGAXNnYe9lNuJ..jFV5aRwlxSFw4b7zvFgFpo6S', 'ALEXANDRE@gmail.com', 'member', NULL, 3, 7, 5, NULL),
(45, 'Teo', '$2y$10$F9ibvD1iGiqOYSWouLvbDe6KZUEfycni/.877GqRWJInYgXt4r0pC', 'TEO@gmail.com', 'member', NULL, 1, 3, 5, NULL),
(46, 'Zaynab', '$2y$10$CpJ/Y6FxnH0KSpA8fDJSG.h5Gw1bvjgqz4.l9j3iSDWOGfp3I7QOG', 'Zaynab@gmail.com', 'member', NULL, 3, 8, 5, NULL),
(47, 'Gabin', '$2y$10$SUbGywgKcTyL336yf7U4jefRo2wMm6k9D.en92PQTqneb.BJ5e/MO', 'Gabin@gmail.com', 'member', NULL, 6, 6, 7, NULL),
(48, 'user', '$2y$10$cMA6B50NuaOjFzzMR5vRSuqI1eX8fHw/8toeVaFWh8IjXSeoOFN6C', 'user@hmail.com', 'member', 'uploads/profile_photos/user.jpg', 0, 0, 1, 'uploads/dossiers/Dossier d\'Inscription - Club StrikerMaster (3).odt'),
(49, 'membre', '$2y$10$V2gTRJNAXDnxi8nVzMCnCuYwQYIzHmo1Er/0ExiMxpZuGS/LaVfAO', 'membre@mmm', 'member', 'uploads/profile_photos/membre.jpg', 0, 0, 0, 'uploads/dossiers/Dossier d\'Inscription - Club StrikerMaster (1).odt'),
(50, 'util', '$2y$10$.M5tn13oammnDeJaG.wSqujjtj40ieyEJWQHjeSNClnPRuu4F28.G', 'util@gmail', 'member', NULL, 0, 0, 0, NULL),
(51, 'shin', '$2y$10$rBjfm9pz3ynHy2bPC.6WN.40vC3iRzJdV6qncwP7M23sUueLW.p3W', 'shin@gmail.com', 'member', NULL, 0, 0, 0, 'uploads/dossiers/Dossier d\'Inscription - Club StrikerMaster (3).odt');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
