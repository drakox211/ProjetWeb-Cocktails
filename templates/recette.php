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
			<?php 
				$recette = getReciepe($_GET['id']);
				echo '<h2 class="section-heading text-uppercase">'.$recette['titre'].'</h2>';
			?>	
		  </div>
		</div>
		
		<?php 
		echo 	'<div class="card reciepe-card" style="width: 18rem;">
				<img class="card-img-top" src="'.retrievePhoto($recette['titre']).'" alt="Card image cap">
				</div>';
		?>	
		
		<div class="col-lg-12 text-center">
			</br></br></br>
			<h2 class="section-heading text-uppercase">Ingrédients</h2>
			<?php
				$ingredient = explode("|",$recette['ingredients']);
				$i=count($ingredient);
				while($i!=0){
					echo '<h3 class="section-subheading text-muted">'.$ingredient[$i-1].'</h3>';
					$i--;
				}
			?>
			
			</br></br></br>
			<h2 class="section-heading text-uppercase">Préparation</h2>
			
			<?php
				echo '<h3 class="section-subheading text-muted">'.$recette['preparation'].'</h3>';
			?>
			
			<?php
				$fav = getFav($_GET['id']);
				if(!isFavorite($_SESSION['idUser'], $_GET['id']))
					 echo '<a href="controleur.php?action=AddToCart&idr='.$_GET["id"].'&idu='.$_SESSION["idUser"].'" class="btn btn-primary"> Ajouter aux favoris </a>';
				else
					 echo '<a href="controleur.php?action=RemoveToCart&idr='.$_GET["id"].'&idu='.$_SESSION["idUser"].'" class="btn btn-primary"> Retirer des favoris </a>';
			?>
		</div>
	</section>
</div>