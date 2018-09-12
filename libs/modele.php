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
function checkIfExists($login) {
	$SQL="SELECT iduser FROM utilisateurs WHERE pseudo='$login'";
	$Array=SQLSelect($SQL);
	return ($Array==false) ? false : true;
}
// Ajoute un utilisateur à la base de données
function addUser($nom,$prenom,$email,$nom_user,$password,$tel,$adress,$zipcode,$city,$sexe,$birthdate){
	 $birthdate = ($birthdate == '') ? 'NULL' : "'".$birthdate."'" ;
	$SQL="INSERT INTO utilisateurs(nom,prenom,pseudo,mail,password,tel,adress,zipcode,city,sexe,birthdate) VALUES('$nom','$prenom','$nom_user','$email','$password','$tel','$adress','$zipcode','$city','$sexe',$birthdate)";
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

// Vérifie si l'utilisateur est sur la page d'accueil
function isMainPage(){
	return (!isset($_GET["view"]) || $_GET["view"] == "accueil" );
}

// Vérifie si l'utilisateur est sur la page d'inscription/connexion
function isLoginPage(){
	return (isset($_GET["view"]) && ($_GET["view"] == "inscription" || $_GET["view"] == "connexion"));
}

//Recupere le nom de la racine
function getRacineName($hierarchie) {	
	foreach($hierarchie as $key => $value) {											//Parcours des ingredients
		foreach ($value as $categorie => $innervalue) {									//Parcours des relations pere-fils
			if (count($value) == 1 && $categorie == 'sous-categorie') return $key;		//On trouve la racine et on renvoie la data
		}
	}
	return null;
}

//Recupere la liste de fils d'un ingredient. renvoie null si c'est une feuille.
function getIngredientFils($hierarchie, $nom) {
	foreach($hierarchie as $key => $value) {	
		if ($key == $nom) {
			foreach ($value as $categorie => $ingredients) {				//...on parcours ses relations pere-fils
				if ($categorie == 'sous-categorie') return $ingredients;	//...si l'ingredient n'est pas une feuille, on retourne ses fils
			}
		}
	}
	return null;															//L'ingrédient est une feuille
}

//Ajoute un nouveau chemin a un ingredient
function addIngredientPath($ingredient, $path) {
	$SQL = "SELECT path FROM ingredients WHERE nom='$ingredient'";
	$temp = SQLGetChamp($SQL);
	foreach (explode(' ', $temp) as $paths) if ($path == $paths) return;		//Previent la duplication non-voulue de données
	$path = SQLGetChamp($SQL).' '.$path;
	$SQL = "UPDATE ingredients SET path='$path' WHERE nom='$ingredient'";
	SQLUpdate($SQL);
}

//Ajoute un ingrédient
function addIngredient($nom, $path) {
	$sql = "INSERT INTO ingredients(nom, path) VALUES ('$nom','$path')";
	SQLInsert($sql);
}

//Parcours donnees.ico.php pour inserer les ingredients dans la bdd avec leur arboressence.
function parseData($dataTable, $nom, $path) {
	//$dataTable est le tableau de données
	//$hierarchie est un tableau des fils d'un ingredient
	//Si $hierarchie est une feuille, on remonte
	addIngredient(addslashes($nom), $path);														//On ajoute l'ingredient
	$hierarchie = getIngredientFils($dataTable, $nom);
	if (is_null($hierarchie)) return;
	
	foreach ($hierarchie as $index => $ingredient) {											//Pour chaque ingredient fils
		$localpath = $path.'.'.$index;															//On lui affecte le bon chemin
		parseData($dataTable, $ingredient, $localpath);											//On parcours ses fils
	}
}
?>
