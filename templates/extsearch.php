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
			<h3 class="section-subheading text-muted">Nous sommes fiers de nos cocktails, voici nos plus populaires</h3>
		  </div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Nom d'ingrédient</label>
			<div class="col">
			  <input type="text" id="ingerdientSearchbar" class="form-control" placeholder="Ex : Partie de citron" onkeyup="ingredientLike(this.value)">
			</div>
		</div>
		
		<div class="dropdown-menu">
		  <h6 class="dropdown-header">Dropdown header</h6>
		  <a class="dropdown-item" href="#">Action</a>
		  <a class="dropdown-item" href="#">Another action</a>
		</div>
		
		<div id ="ingredientDropdown" class="list-group">
		  <a class="list-group-item list-group-item-action active" id="dropdownHeader">Ingrédients</a>
		</div>
		
		<section>
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
			Voulez vous l'ajouter aux recettes <b>contenant</b> ou <b>ne contenant pas</b> cet ingrédient ?
		  </div>
		  <div class="modal-footer">
			<button type="button" id="btnModalRemove" class="btn btn-primary" data-dismiss="modal" onclick="">Retirer</button>
		  </div>
		</div>
	  </div>
	</div>
</div>




