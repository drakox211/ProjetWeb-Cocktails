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
					foreach(getAllParents($_GET["path"]) as $key => $value){
                      echo '<li class="breadcrumb-item active" aria-current="page"><a href="'.$baseArg.$value["path"].'">'.$value["nom"].'</a></li>';
                 }
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
		<?php
			$recettes = getReciepeByIngredient($ingredient["nom"]);
			if(count($recettes) != 0) {
				$nbRecettes = count($recettes);
				
				$indexR = 0;
				for($i = 0; $i <= floor($nbRecettes / 3); $i++) {
					echo '<div class="row">';
					for($j = 0; $j < 3; $j++) {
						$indexR = $i*3 + $j;
						if ($indexR >= $nbRecettes) break;
						echo '<div class="card reciepe-card" style="width: 18rem;">
								  <img class="card-img-top" src="'.retrievePhoto($recettes[$indexR]["titre"]).'" alt="Card image cap">
								  <div class="card-body">
									<h5 class="card-title">'.$recettes[$indexR]["titre"].'</h5>
									<a href="?view=recette&id='.$recettes[$indexR]["idreciepe"].'" class="btn btn-primary">Voir la recette</a>
								  </div>
								</div>';
					}
					echo '</div>';
				}
			}
		?>
	</section>
</div>




