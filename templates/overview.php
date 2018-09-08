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
			<h3 class="section-subheading text-muted">Nous sommes fiers de nos cocktails, voici nos plus populaires</h3>
		  </div>
		</div>
	</section>
	<div id="carouselCocktails" class="carousel slide" data-ride="carousel">
	  <ol class="carousel-indicators">
		<li data-target="#carouselCocktails" data-slide-to="0" class="active"></li>
		<li data-target="#carouselCocktails" data-slide-to="1"></li>
		<li data-target="#carouselCocktails" data-slide-to="2"></li>
	  </ol>
	  <div class="carousel-inner">
		<div class="carousel-item active">
		  <a href="?view=recette&reciepe="><img class="d-block w-100" src="img/Photos/Black_velvet.jpg" alt="First slide"></a>
		  <div class="carousel-caption d-none d-md-block">
			<h5>[NOM DU COCKTAIL]</h5>
			<p>[Info sur le cocktail]</p>
		  </div>
		</div>
		<div class="carousel-item">
		  <a href="?view=recette&reciepe="><img class="d-block w-100" src="img/Photos/Cuba_libre.jpg" alt="Second slide"></a>
		  <div class="carousel-caption d-none d-md-block">
			<h5>[NOM DU COCKTAIL]</h5>
			<p>[Info sur le cocktail]</p>
		  </div>
		</div>
		<div class="carousel-item">
		  <a href="?view=recette&reciepe="><img class="d-block w-100" src="img/ingredients/sake.jpg" alt="Third slide"></a>
		  <div class="carousel-caption d-none d-md-block">
			<h5>[NOM DU COCKTAIL]</h5>
			<p>[Info sur le cocktail]</p>
		  </div>
		</div>
	  </div>
	  <a class="carousel-control-prev" href="#carouselCocktails" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#carouselCocktails" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	  </a>
	</div>
	<section>
		<div class="row">
		  <div class="col-lg-12 text-center">
			<h3 class="section-subheading text-muted">Vous pouvez rechercher tous nos cocktails en cliquant juste ici.</h3>
			<a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="?view=search">Recherche de cocktails</a>
		  </div>
		</div>
	</section>
</div>