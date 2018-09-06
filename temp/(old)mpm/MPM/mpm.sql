-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 06 Juin 2016 à 19:44
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mpm`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `idCom` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `idEp` int(11) NOT NULL,
  `idSerie` int(11) NOT NULL,
  `com` text NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`idCom`),
  UNIQUE KEY `idCom` (`idCom`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `idType` int(11) NOT NULL,
  `Nom` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `type`
--

INSERT INTO `type` (`idType`, `Nom`) VALUES
(1, 'Anime'),
(2, 'Mini-serie');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(20) NOT NULL,
  `Mdp` varchar(32) NOT NULL,
  `Admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `idUser` (`idUser`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idUser`, `Nom`, `Mdp`, `Admin`) VALUES
(2, 'Coco', '202cb962ac59075b964b07152d234b70', 1),
(3, 'Tomtom', '250cf8b51c773f3f8dc8b4be867a9a02', 0);

-- --------------------------------------------------------

--
-- Structure de la table `visionage`
--

DROP TABLE IF EXISTS `visionage`;
CREATE TABLE IF NOT EXISTS `visionage` (
  `idVis` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `idSerie` int(11) NOT NULL,
  `EpAct` int(11) NOT NULL DEFAULT '0',
  `Note` decimal(10,0) DEFAULT NULL,
  `Etat` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idVis`),
  UNIQUE KEY `idVis` (`idVis`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `visionage`
--

INSERT INTO `visionage` (`idVis`, `idUser`, `idSerie`, `EpAct`, `Note`, `Etat`) VALUES
(1, 2, 1161, 0, '5', 0),
(2, 2, 858, 0, '5', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
