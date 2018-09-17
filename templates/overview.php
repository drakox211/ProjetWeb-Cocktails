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

<div class="container">
	<section>
		<div class="row">
		  <div class="col-lg-12 text-center">
			<h2 class="section-heading text-uppercase">Apercu de nos cocktails</h2>
			<h3 class="section-subheading text-muted">La Recherche avancée permet de trouver un enemble de recettes grâce à une collection d'ingrédients contenus ou non dans ces recette.</h3>
			<a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="?view=search">Recherche simple</a>
			<a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="?view=extsearch">Recherche avancée</a>
		  </div>
		</div>
	</section>
</div>