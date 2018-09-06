<?php

//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}
//include_once("libs/maLibForms.php");


?>

<h1 id="bigTitle">Bienvenue sur 2iSeriesList</h1>

<?php
if(!$connecte=valider("connecte","SESSION"))
{
	echo '<div id="butoncontainer">';
		echo '<div onclick="select(this)" class="menubuton" id="suite">Accéder</div>';
		echo '<div onclick="select(this)" class="menubuton" id="inscription">S\'inscrire</div>';
	echo '</div>';
//<!-- ELEMENT DE PAGE -->
		echo '<form name="logForm" id="logForm" action="controleur.php">';
			echo '<h1 class="title" id="loginTitle" style="display:none">Connexion</h1>';
			echo '<h1 class="title" id="inscriptionTitle" style="display:none">Inscription</h1>';

			$err = valider('view');
			if (strpos($err,"err") !== FALSE){
				echo '<script> $(document).ready(function(){ $(".logs").css("border", "1px solid red"); error("'.$err.'"); });</script>';
				echo '<div style="text-align: center;"> Les logs entrés ne sont pas valides</div>';
			}
		
			echo '<input type="text" name="pseudo" class="loginput logs" placeholder="Pseudo">';
			echo '<input type="password" name="password" class="loginput logs" placeholder="Mot de passe">';
			echo '<input type="submit" value="Connexion" name="action" id="logSubmit">';
			echo '<input type="submit" value="Inscription" name="action" id="inscSubmit">';
		echo '</form>';
}
?>
<div id="seriesContainer">
<aside id="navSeries">
<div class="asideButon" id="series-search"><form name="searchForm" action="index.php"><input type="text" name="search" id="searchSeries" placeholder="Recherche"  autocomplete="off"><input style="display:none;" type="text" name="order" id="order" value="title"><input type="hidden" value="search" name="view"><input type="submit" value="Recherche" id="searchSubmit"></form></div>
	<!-- <div class="asideButon whichSeries choice" onclick="select(this)" id="series-all">Toutes les séries</div> -->
	<!-- <div class="asideButon whichSeries" onclick="select(this)" id="series-serie">Séries Télé</div> -->
	<!-- <div class="asideButon whichSeries" onclick="select(this)" id="series-anime">Séries d'Animation</div> -->
	<!-- <div class="asideButon whichSeries" onclick="select(this)" id="series-film">Films</div> -->
	<div class="asideButon " onclick="select(this)" id="order">Trier par</div>
	<div class="asideButon orderSeries choice" onclick="select(this)" id="title">Alphabétique</div>
	<div class="asideButon orderSeries" onclick="select(this)" id="popularity">Popularité</div>
	<div class="asideButon orderSeries" onclick="select(this)" id="followers">Followers</div>
	<div class="asideButon" onclick="select(this)" id="detail-view">
		<input type="checkbox" name="vue detailee" id="detailBox">
		<label id="detailCheck" for="detailBox" onclick="select(this)">Vue Détaillée</label>				
	</div>
</aside>
<section id="displaySeries"> <!-- ESPACE D'AFFICHAGE DES SERIES -->
	<table id="tableSeries"> <!-- tableau général -->
		<?php 
			/*for($i = 1;$i<11;$i++){
				mkSerie($i); 
			}*/
			$order = valider('order');
			$cherche = valider('search');
			if(!$cherche || $cherche=="")$cherche='*';
			if(!$order)$order="title";
			search($cherche,$order);
		?>
		<!--<tbody class="item"> espace série
			<tr> 
				<td class="indice">#04</td>
				<td class="jaquette"></td>
				<td class="nom">Le Doge Sequel</td>
				<td class="synopsis">C'est une histoire .</td>
				<td class="statut">Fini</td>
				<td class="progression">25/25</td>
				<td class="note">69/10</td>
			</tr>
		</tbody>-->
	</table>
</section>
</div>
<?php 
	$view=valider("view");
	if($view == "search")
	{
		if($search = valider("search"))echo "<script>document.getElementById(\"searchSeries\").value = \"$search\"; </script>"; 
		if($order=valider("order"))echo "<script>select(document.getElementById('$order'));</script>";
		echo '<script>error("serie");</script>';
	}
	else if($view == "perso" || $view == "postlogin")echo '<script>error("perso");</script>';
	
	if($connecte=valider("connecte","SESSION"))
	{
		echo '<div id="listeContainer">';
			echo '<section id="displayListe"> <!-- ESPACE D\'AFFICHAGE DES SERIES -->';
				echo'<table id="tableListe"> <!-- tableau général -->';
					$user = valider("idUser","SESSION");
					echo "<tbody><tr><th colspan='6' style='border: 20px solid transparent; font-size: 50px;'>En cours</th></tr></tbody>";
					mkListe($user,2);
					echo "<tbody><tr><th colspan='6' style='border: 20px solid transparent; font-size: 50px;'>A regarder</th></tr></tbody>";
					mkListe($user,1);
					echo "<tbody><tr><th colspan='6' style='border: 20px solid transparent; font-size: 50px;'>Terminées</th></tr></tbody>";
					mkListe($user,3);
				echo '</table>';
			echo '</section>';
		echo '</div>';
	}
?>
<h1 id="aboutTitle">Qu'est-ce que 2iSeriesList ?</h1>
<div id="container">
	<p class="about">2iSeriesList est une plateforme de gestion et de suivi de séries télévisées.</p>
	<p class="about">Elle vous permet de créer votre propre suivi, l'éditer par de simples clics, partager votre ressenti avec d'autres utilisateurs et bien plus encore.</p>
	<p class="about">Pour plus d'informations sur l'utilisation, <span title="FAQ" style="cursor: pointer;" onclick="window.open('templates/faq.html','FAQ','width=520,height=800,left=400,top=100');">cliquez ici</span></p>
</div>