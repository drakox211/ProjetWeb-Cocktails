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
				foreach (getSons($ingredient["nom"]) as $key => $value) {
					echo '<li><a href="'.$baseArg.$value["path"].'">'.$value["nom"].'</a></li>';
				}
			?>
		</ul>
		<div class="row">
		  <div class="col-lg-12 text-center">
			<h2 class="section-heading text-uppercase">Recettes comportant cet aliment</h2>
		  </div>
		</div>
		<?php
			$recettes = getReciepeByIngredient($ingredient["nom"]);
			if(count($recettes) != 0) {
				$nbRecettes = count($recettes);
				
				$indexR = 0;
				$parLigne = 5;
				for($i = 0; $i <= floor($nbRecettes / $parLigne); $i++) {
					echo '<div class="row row-card-reciepe">';
					for($j = 0; $j < $parLigne; $j++) {
						$indexR = $i*$parLigne + $j;
						if ($indexR >= $nbRecettes) break;
						echo '<div class="card reciepe-card" style="width: 12rem;">
								  <img class="card-img-top card-img-shrink" src="'.retrievePhoto($recettes[$indexR]["titre"]).'" alt="Card image cap">
								  <div class="card-body">
									<h6 class="card-title">'.$recettes[$indexR]["titre"].'</h6>
									<a href="?view=recette&id='.$recettes[$indexR]["idreciepe"].'" class="btn btn-primary btn-reciepe">Voir la recette</a>
								  </div>
								</div>';
					}
					echo '</div>';
				}
			}
		?>
	</section>
</div>




