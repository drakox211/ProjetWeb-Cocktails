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

//Vérifie les entrées de formulaire
function verifForm($data) {
	$email = filter_var($data['mail'], FILTER_VALIDATE_EMAIL);
	$tel = preg_match("/^[0-9]{10}$/", $data['tel']);
	$zip = preg_match("/^[0-9]{5}$/", $data['zipcode']);
	$pseudo = ctype_alnum($data['pseudo']);
	
	$email = ($email === false) ? false: true;
	$tel = ($tel == 0) ? false: true;
	$zip = ($zip == 0) ? false: true;
	$pseudo = ($pseudo === false) ? false: true;
	
	return ($email && $tel && $zip && $pseudo);
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

//Ajoute une recette dans la BDD
function addReciepe($recette) {
	$sql = "INSERT INTO recettes(titre, ingredients, preparation, listIngredient) VALUES ('".addslashes($recette['titre'])."','".addslashes($recette['ingredients'])."', '".addslashes($recette['preparation'])."', '".addslashes(implode(";", $recette["index"]))."')";
	SQLInsert($sql);
}

//Récupère toutes les recettes contenant un ingrédient donné
function getReciepeByIngredient($ingredientName) {
	$sql = "SELECT * FROM recettes";
	$recettes = parcoursRs(SQLSelect($sql));
	$return = array();
	foreach ($recettes as $index => $recette) {
		$ingredients = $recette['listIngredient'];
		foreach(explode(";", $ingredients) as $ingredient) {
			if ($ingredientName == $ingredient) {
				array_push($return, $recette);
				break;
			}
		}
	}
	return $return;
}

//Récupère la photo d'un cocktail si elle existe, une image par defaut sinon.
function retrievePhoto($reciepeName) {
	$src = "img/Photos/";
	$ext = ".jpg";
	$default = "missing-image";
	
	$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
								'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
								'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
								'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
								'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
	$reciepeName = strtr( $reciepeName, $unwanted_array );
	$reciepeName = str_replace(" ","_", $reciepeName);

	return (file_exists($src.ucfirst($reciepeName).$ext)) ? $src.ucfirst($reciepeName).$ext : $src.$default.$ext;
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

//Ajoute un ingrédient
function addIngredient($nom, $path) {
	$sql = "INSERT INTO ingredients(nom, path) VALUES ('$nom','$path')";
	SQLInsert($sql);
}

//R♪écupère un ingredient selon son chemin (unique)
function getIngredient($path) {
	$sql = "SELECT * FROM ingredients WHERE path = '$path'";
	return parcoursRs(SQLSelect($sql));
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

//Récupère les fils directs d'un aliment
function getSons($ingredientName) {
	$sql = "SELECT path FROM ingredients WHERE nom = '$ingredientName'";
	$path = SQLGetChamp($sql);
	$path = str_replace(".", "\\.", $path);
	$sql = "SELECT * FROM ingredients WHERE path REGEXP '^".$path."\.[0123456789]+$'";
	return parcoursRs(SQLSelect($sql));
}

//Récupère tout les parents (jusau'a la racine) d'un ingrédient.
function getAllParents($path) {
    if (!strstr($path, "."))
        return array();

    $tab = explode(".",$path);
    $i=count($tab);
    $parent = array();
    do{
        unset($tab[$i-1]);
        $path = implode(".",$tab);
        $sql = "SELECT * FROM ingredients WHERE path = '$path'";
        array_push($parent, parcoursRs(SQLSelect($sql))[0]);
        $i--;
    }
    while($i!=1);
    return array_reverse($parent);
}

//Ajoute une recette aux favoris
function addFav($recette, $user) {
	$sql = "INSERT INTO panier(iduser, idreciepe) VALUES ('".$user."','".$recette."')";
	SQLInsert($sql);
}

//Retire une recette des favoris
function removeFav($recette, $user) {
	$sql = "DELETE FROM panier WHERE iduser = ".$user." AND idreciepe = ".$recette."";
	SQLDelete($sql);
}

//Verifie si une recette est dans les favoris
function isFavorite($idUser, $idRecette){
	$sql = "SELECT idreciepe FROM panier WHERE iduser = ".$idUser." AND idreciepe = ".$idRecette."";
	$fav = parcoursRs(SQLSelect($sql));
	return count($fav);
}

//Recupère une recette par son id
function getReciepe($id){
	return parcoursRs(SQLSelect("SELECT * FROM recettes WHERE idreciepe = ".$_GET['id'].""))[0];
}

//Recupère la liste des recettes favories d'un utilisateur
function getFav($id){
	return parcoursRs(SQLSelect("SELECT idreciepe FROM panier WHERE iduser = ".$id.""));
}

//Recupère toutes les recette favorite de l'utilisateur connecté
function getAllFav($id){
	return parcoursRs(SQLSelect("SELECT * FROM panier P, recettes R WHERE iduser = ".$_SESSION['idUser']." AND P.idreciepe = R.idreciepe"));
}
?>
