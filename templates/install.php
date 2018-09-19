<?php
global $BDD_host;
global $BDD_base;
global $BDD_user;
global $BDD_password;

include_once "data/Donnees.inc.php"; 

global $Recettes;
global $Hierarchie;

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";

//Creation de la table
$SQL = '
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cocktail`
--
CREATE DATABASE IF NOT EXISTS `'.$BDD_base.'` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `'.$BDD_base.'`;

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `idingredient` int(11) NOT NULL AUTO_INCREMENT,
  `path` char(110) NOT NULL,
  `nom` char(50) NOT NULL,
  PRIMARY KEY (`idingredient`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `iduser` int(11) NOT NULL,
  `idreciepe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `recettes`
--

DROP TABLE IF EXISTS `recettes`;
CREATE TABLE IF NOT EXISTS `recettes` (
  `idreciepe` int(11) NOT NULL AUTO_INCREMENT,
  `titre` char(255) NOT NULL,
  `ingredients` char(255) NOT NULL,
  `preparation` text NOT NULL,
  `listIngredient` char(255) NOT NULL,
  PRIMARY KEY (`idreciepe`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `nom` char(25) NOT NULL,
  `prenom` char(25) NOT NULL,
  `mail` char(50) NOT NULL,
  `pseudo` char(25) NOT NULL,
  `password` char(255) NOT NULL,
  `tel` char(10) NOT NULL,
  `zipcode` char(5) NOT NULL,
  `sexe` char(5) NOT NULL,
  `adress` char(100) NOT NULL,
  `city` char(50) NOT NULL,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
';

try {
	$dbh = new PDO("mysql:host=$BDD_host", $BDD_user, $BDD_password);

	$dbh->exec($SQL);
	//or die(print_r($dbh->errorInfo(), true));

} catch (PDOException $e) {
	die("DB ERROR: ". $e->getMessage());
}

//----------------------------------------------------------------------

//Insertion des recettes
foreach ($Recettes as $index => $recette) addReciepe($recette);

//Insertion des ingredients
$rootname = getRacineName($Hierarchie);
$rootpath = "1";
parseData($Hierarchie, $rootname, $rootpath);

//Redirection vers la page d'accueil
unset($_GET['view']);
header("Location:./index.php");
die("");

?>