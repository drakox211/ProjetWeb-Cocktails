<?php


session_start();

include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/maLibSecurisation.php"; 
include_once "libs/modele.php"; 

include_once "data/Donnees.inc.php"; 

$addArgs = "";

if ($action = valider("action"))
{
	switch($action)
	{
		case 'RecupMDP':
		$login = $_POST['nom_user'];

		if( $login ){
			$user = utilisateurParLogin($login)[0];
			$pass = randomPassword(16);
			$hash = password_hash($pass, PASSWORD_DEFAULT);
			changerPasse($user['iduser'], $hash);
		}
		$addArgs = "?err=4";
		break;

		case 'Connexion' :
		if (verifUser($_POST["pseudo"],$_POST["password"])) {
			setcookie('cookielogin', $_POST["pseudo"], time() + 3600 * 24 * 10);
		}
		else $addArgs = "?view=connexion";

		break;

		case 'Deconnexion' :
		setcookie("cookielogin", "", time() - 3600);
		session_destroy();
		break;
		
		case 'ReciepeImport' :
		global $Recettes;
		foreach ($Recettes as $index => $recette) addReciepe($recette);
		break;
		
		case 'IngredientImport' :
		global $Hierarchie;
		$rootname = getRacineName($Hierarchie);
		$rootpath = "1";
		parseData($Hierarchie, $rootname, $rootpath);
		break;
		
		case 'Inscription' :
		if (verifForm($_POST)) {
			if (count(utilisateurParLogin($_POST["pseudo"])) == 0) {
				$password = password_hash($_POST["password"], PASSWORD_DEFAULT);// pour crypter le mot de passe
				addUser($_POST["nom"],$_POST["prenom"],$_POST["mail"],$_POST["pseudo"],$password,$_POST["tel"],$_POST["adress"],$_POST["zipcode"],$_POST["city"],$_POST["sexe"],$_POST["birthdate"]);
				if (verifUser($_POST["nom_user"],$_POST["password"])) {
					setcookie('cookielogin', $_POST["nom_user"], time() + 3600 * 24 * 10);

					$addArgs = "?err=2";
				}
			}
			else $addArgs = "?view=inscription&err=2";
		}
		else $addArgs = "?view=inscription&err=1";
		break;

		case 'UpdateProfile' :
		updateUser($_POST["nom"],$_POST["prenom"],$_SESSION["pseudo"],$_POST["tel"],$_POST["adress"],$_POST["zipcode"],$_POST["city"],$_POST["sexe"],$_POST["birthdate"]);
		$addArgs = "?view=profil&err=0";
		break;
		
		case 'setMdp' :
		if ($nouveauPasse = valider("password"))
			if (valider("connecte","SESSION")) {
				$idUser = $_SESSION["idUser"]; 
				$user = utilisateurParId($idUser)[0];
					$password = password_hash($nouveauPasse, PASSWORD_DEFAULT);// pour crypter le mot de passe
					changerPasse($idUser,$password); // chgt BDD
					$addArgs = "?err=3";
		}
		break;
		
		case 'Find' :
        unset($_POST["action"]);
        $is = array();
        $isnt = array();
        foreach($_POST as $id => $ingredient) {
            if (strpos($id, "ingnt") === false) $is[] = $ingredient;
            else $isnt[] = $ingredient;
        }
        $addArgs = "?view=extsearch&result=".advancedSearch($is, $isnt);
        break;
		
		case 'AddToCart' :
		if (isset($_SESSION["tempFav"])) $_SESSION["tempFav"][] = getReciepe($_GET['idr']);
		else addFav($_GET['idr'],$_GET['idu']);
		$addArgs = "?view=recette&id=".$_GET["idr"];
		break;
		
		case 'RemoveToCart' :
		if (isset($_SESSION["tempFav"])) {
			$i = -1;
			foreach ($_SESSION["tempFav"] as $index => $recette) {
				if ($_GET['idr'] == $recette['idreciepe']) {
					$i = $index;
					break;
				}
			}
			if ($i != -1) unset($_SESSION["tempFav"][$i]);
		}
		else removeFav($_GET['idr'],$_GET['idu']);
		$addArgs = "?view=recette&id=".$_GET["idr"];
		break;
	}
}

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	
	header("Location: http://$host$uri/$addArgs");

	// On écrit seulement après cette entête
	ob_end_flush();

?>