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
				$sql = "SELECT titre FROM recettes WHERE idreciepe = ".$_GET['id']."";
				echo '<h2 class="section-heading text-uppercase">'.SQLGetChamp($sql).'</h2>';
			?>	
		  </div>
		</div>
		
		<?php 
		echo 	'<div class="card reciepe-card" style="width: 18rem;">
				<img class="card-img-top" src="'.retrievePhoto(SQLGetChamp($sql)).'" alt="Card image cap">
				</div>'
		?>	
		
		<div class="col-lg-12 text-center">
			</br></br></br>
			<h2 class="section-heading text-uppercase">Ingrédients</h2>
			<?php
				$sql = "SELECT ingredients FROM recettes WHERE idreciepe = ".$_GET['id']."";
				$tab = explode("|",SQLGetChamp($sql));
				$i=count($tab);
				while($i!=0){
					echo '<h3 class="section-subheading text-muted">'.$tab[$i-1].'</h3>';
					$i--;
				}
			?>
			
			</br></br></br>
			<h2 class="section-heading text-uppercase">Préparation</h2>
			
			<?php
				$sql = "SELECT preparation FROM recettes WHERE idreciepe = ".$_GET['id']."";
				echo '<h3 class="section-subheading text-muted">'.SQLGetChamp($sql).'</h3>';

				$sql = "SELECT idreciepe FROM panier WHERE iduser = ".$_SESSION['idUser']."";
				$fav = parcoursRs(SQLSelect($sql));
				$inFav = FALSE;
				for($i = 0; $i < count($fav); $i++)
				{
					if ($fav[$i]['idreciepe'] == $_GET['id'])
						$inFav = TRUE;
				}	
				if(!$inFav)
					 echo '<a href="controleur.php?action=AddToCart&idr='.$_GET["id"].'&idu='.$_SESSION["idUser"].'" class="btn btn-primary"> Ajouter aux favoris </a>';
				else
					 echo '<a href="controleur.php?action=RemoveToCart&idr='.$_GET["id"].'&idu='.$_SESSION["idUser"].'" class="btn btn-primary"> Retirer des favoris </a>';
			?>
		</div>
	</section>
</div>