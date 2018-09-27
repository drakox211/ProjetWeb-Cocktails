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
<script src="js/script.js"></script>

<div class="container">
	<section>
		<div class="row">
		  <div class="col-lg-12 text-center">
			<h2 class="section-heading text-uppercase">Recherche avancée</h2>
			<h3 class="section-subheading text-muted">Recherchez votre future recette selon vos gouts.</h3>
		  </div>
		</div>
		
		<div class="form-group row" <?php if(isset($_GET["result"])) echo 'style="display: none;"';?>>
			<label class="col-sm-2 col-form-label">Nom d'ingrédient</label>
			<input type="checkbox" id="searchMode" checked data-toggle="toggle" data-on="Commence par" data-off="Contient" data-onstyle="info" data-offstyle="info">
			<div class="col">
			  <input type="text" id="ingerdientSearchbar" class="form-control" placeholder="Ex : Partie de citron" onkeyup="ingredientLike(this.value)">
			</div>
		</div>
		
		<div id ="ingredientDropdown" class="list-group">
		  <a class="list-group-item list-group-item-action active" id="dropdownHeader" style="display: none;">Ingrédients</a>
		</div>
		
		<section <?php if(isset($_GET["result"])) echo 'style="display: none;"';?>>
			<div class="container">
				<form method="POST" action="controleur.php">
					<div class="row">
					  <div class="col-lg-12 text-center">
						<h2 class="section-heading text-uppercase">Comportant les aliments</h2>
					  </div>
					</div>
					<div class="container" id="listContains">
					</div>

					<div class="row">
					  <div class="col-lg-12 text-center">
						<h2 class="section-heading text-uppercase">Ne comportant pas les aliments</h2>
					  </div>
					</div>
					<div class="container" id="listContainsnt">
					</div>
					<div class="form-group row">
						<div class="col-lg-12 text-center">
						  <button type="submit" name='action' value="Find" class="btn btn-primary">Recherche</button>
						</div>
					</div>
				</form>
			</div>
		</section>
		<?php
			if(valider("result", "GET")) {
				echo '<div class="row">
						<div class="col-lg-12 text-center">
							<h2 class="section-heading text-uppercase">Résultats de votre recherche</h2>
						</div>
					</div>';
				$ids = explode(";", $_GET["result"]);
				$recettes = array();
				foreach($ids as $id) array_push($recettes, getReciepe($id)); 
				
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
	
	<!-- Modal -->
	<div class="modal fade" id="ingredientModal" tabindex="-1" role="dialog" aria-labelledby="ingredientModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="ingredientModalLabel"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			Voulez vous l'ajouter aux recettes <b>contenant</b> ou <b>ne contenant pas</b> cet ingrédient ?
		  </div>
		  <div class="modal-footer">
			<button type="button" id="btnModalAdd" class="btn btn-primary" data-dismiss="modal" onclick="">Contient</button>
			<button type="button" id="btnModalAddnt" class="btn btn-primary" data-dismiss="modal" onclick="">Ne contient pas</button>
		  </div>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="ingredientModalDiscard" tabindex="-1" role="dialog" aria-labelledby="ingredientModalDiscardLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="ingredientModalDiscardLabel">Modal title</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			Voulez vous retirer cet ingrédient ?
		  </div>
		  <div class="modal-footer">
			<button type="button" id="btnModalRemove" class="btn btn-primary" data-dismiss="modal" onclick="">Retirer</button>
		  </div>
		</div>
	  </div>
	</div>
</div>




