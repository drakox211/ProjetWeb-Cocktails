<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE HTML>
<html lang="fr-fr">
	<head>
		<title>2iSeriesList</title>
		<link rel="icon" href="./ressources/favicon.png" /> <!-- favicon -->
		<link rel='stylesheet' href='./css/headfoot.css'/>
		<script src="./js/jquery.min.js"></script>
		<script src="./js/jquery-ui.min.js"></script>
		<script type='text/javascript' src='./js/bdd.js'></script>
		<script type='text/javascript' src='./js/script.js'></script>
		<?php
			if(valider("view")=="detail")
			{
				echo "<link rel='stylesheet' href='./css/serie.css'/>";
			}
			else{
				echo "<link rel='stylesheet' href='./css/style.css'/>";
			}
		?>
		<meta charset="UTF-8" />
	</head>
<?php
	if(valider("view")=="detail") echo "<body onload='update(\"-1\",".valider("idUser","SESSION").",".valider("idSerie").")'>";
	else echo "<body>";
	
?>
		<header>
			<!-- <img id="logo" src="./ressources/logo.png" alt="Logo du site"> -->
			<nav>
				<ul>
					<?php
					if(valider("view")=="detail"){
						if($org = valider("origine")) echo "<a href='index.php?view=".$org."'><li onclick='select(this)' class='navbuton is-selected' id='retour'>Retour</li></a>";
						else echo "<a href='index.php'><li onclick='select(this)' class='navbuton is-selected' id='retour'>Retour</li></a>";;
					}else{
						echo "<a href='index.php'><li onclick='select(this)' class='navbuton is-selected' id='accueil'>Accueil</li></a>";
						echo "<li onclick='select(this)' class='navbuton not-selected' id='serie'>Séries</li>";
							$connecte=valider("connecte","SESSION");
							if(!$connecte){
								echo '<li onclick="select(this)" class="navbuton not-selected" id="login">Connexion</li>';
								echo '<li onclick="select(this)" class="navbuton not-selected" id="insc">Inscription</li>';
							}
							else
							{
								echo '<li onclick="select(this)" class="navbuton not-selected" id="compte">Mon Compte</li>';
								echo '<li onclick="select(this)" class="navbuton not-selected" id="logout"><a href="controleur.php?action=Logout">Déconnexion</a></li>';
							}
						echo "<li onclick='select(this)' class='navbuton not-selected' id='apropos'>A propos</li>";
					}
					?>
				</ul>
			</nav>
		</header>