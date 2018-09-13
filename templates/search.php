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
		<nav aria-label="breadcrumb">
		  <ol id="ingredientBreadcrumb" class="breadcrumb">
			<?php 
				$baseArg = "?view=search&path=";
				if (!isset($_GET["path"])) {
					
					$ingredient = getIngredient("1");
					$ingredient = $ingredient[0];
				}
				else {
					$ingredient = getIngredient($_GET["path"]);
					if (count($ingredient) == 0) $ingredient = getIngredient("1");	//Si le path fourni est erroné. on affiche la racine
					$ingredient = $ingredient[0];
					//fonction Julian getAllParents
					//ECHO format : echo '<li class="breadcrumb-item active" aria-current="page"><a href="'.$baseArg.$ingredient["path"].'">'.$ingredient["nom"].'</a></li>';
				}
				//Dernier element du breadcrumb
				echo '<li class="breadcrumb-item active" aria-current="page">'.$ingredient["nom"].'</li>';
			?>
		  </ol>
		</nav>
		
		<ul>
			<?php
				foreach (getSons(addslashes($ingredient["nom"])) as $key => $value) {
					echo '<li><a href="'.$baseArg.$value["path"].'">'.$value["nom"].'</a></li>';
				}
			?>
		</ul>
		<div class="row">
		  <div class="col-lg-12 text-center">
			<h2 class="section-heading text-uppercase">Recettes comportant cet aliment</h2>
			<h3 class="section-subheading text-muted">(Uniquement ingrédient ou sous-ingrédient de la catégorie ?)</h3>
		  </div>
		</div>
		<div class="card" style="width: 18rem;">
		  <img class="card-img-top" src=".../100px180/" alt="Card image cap">
		  <div class="card-body">
			<h5 class="card-title">Card title</h5>
			<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
			<a href="#" class="btn btn-primary">Go somewhere</a>
		  </div>
		</div>
	</section>
</div>




