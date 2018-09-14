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
			<h2 class="section-heading text-uppercase">Vos recettes favorites</h2>
			<?php
				$fav = getAllFav($_SESSION['idUser']);
				for($i = 0; $i < count($fav); $i++){
					echo '<div class="row">';
						echo '<div class="card reciepe-card" style="width: 18rem;">
								  <img class="card-img-top" src="'.retrievePhoto($fav[$i]["titre"]).'" alt="Card image cap">
								  <div class="card-body">
									<h5 class="card-title">'.$fav[$i]["titre"].'</h5>
									<a href="?view=recette&id='.$fav[$i]["idreciepe"].'" class="btn btn-primary">Voir la recette</a>
								  </div>
								</div>';
					echo '</div>';
					echo '</br></br>';
				}
			?>
		  </div>
		</div>
	</section>
</div>