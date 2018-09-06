<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre site. 
*/

include_once "maLibSQL.pdo.php";


function verifUserBdd($login,$passe){
// Vérifie l'identité d'un utilisateur 
// dont les identifiants sont passes en paramètre
// renvoie faux si user inconnu
// renvoie l'id de l'utilisateur si succès
	
	$SQL_pass="SELECT password FROM utilisateurs WHERE pseudo='$login'";
	$pass = SQLGetChamp($SQL_pass);

	if($pass == false) return false;
	
	if(password_verify($passe,$pass) == true){

		$SQL="SELECT iduser FROM utilisateurs WHERE pseudo='$login'";
		return SQLGetChamp($SQL);
	}
	else return false;
// si on avait besoin de plus d'un champ
// on aurait du utiliser SQLSelect
}

// Retourne true si le pseudo $login existe déjà dans la base de données, false sinon
function checkIfExists($login)
{
	$SQL="SELECT iduser FROM utilisateurs WHERE pseudo='$login'";
	$Array=SQLSelect($SQL);
	if ($Array==false) return false;
	else return true;
}
// Ajoute un utilisateur à la base de données (Les champs valide, blacklist et admin sont initialisés à 0 et les autres champs sont passés en paramètre)
function addUser($nom,$prenom,$email,$nom_user,$password,$tel){
	$SQL="INSERT INTO utilisateurs(nom,prenom,admin,pseudo,mail,blacklist,password,valid,tel) VALUES('$nom','$prenom',0,'$nom_user','$email',0,'$password',0,'$tel')";
	SQLInsert($SQL);
}

// Permet de remplacer le mot de passe de l'utilisateur désigné par $idUser par $pass
function changerPasse($idUser,$pass) {
	$SQL = "UPDATE utilisateurs SET password='$pass' WHERE iduser='$idUser'";
	SQLUpdate($SQL);
}

//Renvoie le pseudo d'un utilisateur
//$id = idUtilisateur
function getUser($id) {
	if (is_string($id)) $id = intval($id);
	$SQL="SELECT pseudo FROM utilisateurs WHERE iduser='$id'";
	return SQLGetChamp($SQL);
}

//Renvoie le numéro de téléphone d'un utilisateur
//$id = idUtilisateur
function getTel($id) {
	if (is_string($id)) $id = intval($id);
	$SQL="SELECT tel FROM utilisateurs WHERE iduser='$id'";
	return SQLGetChamp($SQL);
}

//Renvoie l'adresse mail d'un utilisateur
//$id = idUtilisateur
function getMail($id) {
	if (is_string($id)) $id = intval($id);
	$SQL="SELECT mail FROM utilisateurs WHERE iduser='$id'";
	return SQLGetChamp($SQL);
}

// Retourne un mot de passe aléatoire de longueur $taille 				
function randomPassword($taille) {
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

	for ($i = 0; $i < $taille; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	
	return implode($pass); //turn the array into a string
}
// Permet de retourner un tableau contenant les champs concernant un utilisateur désigné par son id $id_user
function utilisateurParId($id_user){
	$sql = "SELECT * FROM utilisateurs WHERE iduser = '$id_user'";
	return parcoursRs(SQLSelect($sql));
}
// Permet de retourner un tableau contenant les champs concernant un utilisateur désigné par son pseudo $login
function utilisateurParLogin($login){
	$sql = "SELECT * FROM utilisateurs WHERE pseudo = '$login'";
	return parcoursRs(SQLSelect($sql));
}

// 
function isMainPage(){
	return (!isset($_GET["view"]) || $_GET["view"] == "accueil" );
}
?>
