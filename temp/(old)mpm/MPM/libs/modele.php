<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/

include_once "maLibSQL.pdo.php";

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT idUser FROM users WHERE Nom='$login' AND Mdp='$passe'";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL ="SELECT admin FROM users WHERE idUser='$idUser'";
	return SQLGetChamp($SQL); 
}

function mkListe($idUser=false,$etat=false)
{
	if(!$idUser || !$etat)return;
	$SQL ="SELECT * FROM visionage WHERE idUser='$idUser' and etat='$etat'";
	$res = SQLSelect($SQL);
	$liste = parcoursRs($res);
	$listeChamps = array('images','title','status','genres','note','episode',);
	if(!$liste){echo "<tbody><tr><td colspan='6'>Aucune série à afficher</td></tr></tbody>"; return;}
	mkEntete($listeChamps);
	foreach($liste as $serie)
	{
		mkSerie($serie["idSerie"],$listeChamps,$etat);
	}
	
}

function getInfo($idUser=false,$idSerie=false, $action=false)
{
	if(!$idUser || !$idSerie || !$action)return;
	switch($action){
		case "epAct":
			$SQL ="SELECT EpAct FROM visionage WHERE idUser='$idUser' and idSerie='$idSerie'";
		break;
		case "note":
			$SQL ="SELECT note FROM visionage WHERE idUser='$idUser' and idSerie='$idSerie'";
		break;
	}
	return SQLGetChamp($SQL);
}

?>
