-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2023 at 04:23 PM
-- Server version: 8.0.34-0ubuntu0.20.04.1
-- PHP Version: 7.4.3-4ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cni`
--

-- --------------------------------------------------------

--
-- Table structure for table `adm_profiles`
--

CREATE TABLE `adm_profiles` (
  `PROFIL_ID` smallint NOT NULL,
  `DESC_PROFIL` varchar(200) NOT NULL,
  `GESTION_UTILISATEUR` tinyint(1) NOT NULL DEFAULT '0',
  `CONFIGURATION` tinyint(1) NOT NULL DEFAULT '0',
  `SIG` tinyint(1) NOT NULL DEFAULT '0',
  `BI` tinyint(1) NOT NULL DEFAULT '0',
  `IHM` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adm_profiles`
--

INSERT INTO `adm_profiles` (`PROFIL_ID`, `DESC_PROFIL`, `GESTION_UTILISATEUR`, `CONFIGURATION`, `SIG`, `BI`, `IHM`) VALUES
(1, 'secretaire du MIDCSP', 1, 1, 0, 1, 0),
(2, 'secretaire de la DG DE LA COORDINATION DES ONG\'S ET DE LA PROMOTION DES LIBERTES PUBLIQUE', 1, 1, 1, 0, 0),
(3, 'secretaire de la Dir de l Cordination des ONG', 1, 1, 1, 1, 1),
(4, 'conseiller de la Dir de l Cordination des ONG', 0, 0, 0, 0, 0),
(5, 'secretaire de la DG de la cordination des ONG et de la Promotion des libertes', 0, 0, 0, 0, 0),
(6, 'secretaire du cabinet du ministre  MIDCSP', 0, 0, 0, 0, 0),
(7, 'cours administrative', 0, 0, 0, 0, 0),
(16, 'Ministre', 1, 1, 0, 1, 1),
(17, 'ASBL', 0, 0, 0, 0, 0),
(18, 'PAD', 1, 1, 1, 0, 0),
(19, 'Secrétaire du ministère sectoriel', 0, 0, 0, 0, 0),
(21, 'Conseiller du ministre', 0, 0, 0, 0, 0),
(22, 'Conseiller du département technique', 0, 0, 0, 0, 0),
(23, 'Secrétaire du département technique', 0, 0, 0, 0, 0),
(25, 'Ministre', 0, 0, 0, 0, 0),
(26, 'Comptable', 1, 0, 0, 0, 0),
(31, 'Analyste de projet', 0, 0, 0, 0, 0),
(32, 'SECRETAIRE TEST', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `adm_users`
--

CREATE TABLE `adm_users` (
  `CONNEXION_ID` int NOT NULL,
  `NOM` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PRENOM` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TEL` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EMAIL` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PASSWORD` varchar(150) NOT NULL,
  `PROFIL_ID` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adm_users`
--

INSERT INTO `adm_users` (`CONNEXION_ID`, `NOM`, `PRENOM`, `TEL`, `EMAIL`, `PASSWORD`, `PROFIL_ID`) VALUES
(1, 'BAREKENSABE', 'ALEXIS', '79839653', 'admin@cni.bi', '827ccb0eea8a706c4c34a16891f84e7b', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adm_profiles`
--
ALTER TABLE `adm_profiles`
  ADD PRIMARY KEY (`PROFIL_ID`);

--
-- Indexes for table `adm_users`
--
ALTER TABLE `adm_users`
  ADD PRIMARY KEY (`CONNEXION_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adm_profiles`
--
ALTER TABLE `adm_profiles`
  MODIFY `PROFIL_ID` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `adm_users`
--
ALTER TABLE `adm_users`
  MODIFY `CONNEXION_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
