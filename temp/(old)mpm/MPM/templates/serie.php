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

include_once("libs/maLibForms.php");
include_once("libs/modele.php");

$idSerie = valider("idSerie");
if(!$idSerie){echo "<h1>Série innexistante</h1>"; return;}
mkDetail($idSerie);

?>

<!-- 
<h1>Game Of Thrones</h1>

<div id="data">
	<aside> <!-- types, genres, longeurs --\>
		<img src="http://cdn.betaseries.com/betaseries/images/fonds/poster/121361.jpg" />
		<article>
			<h3>Type : Série TV</h3>
			<h3>Genres : Action, Boobs</h3>
			<h3>Longeur : 420 eps</h3>
			<h3>Statut : En cours</h3>
		</article>
	</aside> 
	<section> <!-- description --\>
		<h2>Description :</h2>
		<p>Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis Ceci est un synopsis </p> <!-- paragraphe descriptif --\>
		<div id="perso">
			<h3>Avancement : &nbsp </h3>
			
			<form action="controleur.php" method="GET">
				<select id="perso-statut" onchange="update()">
					<option>Fini</option>
					<option>En cours</option>
					<option>A regarder</option>
				</select> <br/>
				<label>Episodes : <input type="text" name="episodes" id="perso-episode" autocomplete="off"> / 420 </label> <br/>
				<label>Note : <input type="number" name="episodes" id="perso-note" autocomplete="off" min="0" max="10"> / 10 </label> <br/>
				<input type="submit" value="Mettre à jour">
			</form>
		</div>
	</section> 
	
	<section> <!-- diffusion, casting --\>
		<h2>Date de diffusion :</h2>
		<p>Du 25/02/40 à 26/23/41 ( texte alternatif pour les "pas sortis" ou "en cours")</p>
		<h2>Casting :</h2>
		<p>John Doe, Lorem Ipsum, John Doe, Lorem Ipsum, John Doe, Lorem Ipsum, John Doe, Lorem Ipsum, John Doe, Lorem Ipsum, John Doe, Lorem Ipsum</p>
		<h2>Commentaires</h2>
		<p>ESPACE COMMENTAIRES</p>
	</section>		
</div>
-->