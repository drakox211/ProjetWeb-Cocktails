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
		<div class="col-lg-12 text-center">
			<h2 class="section-heading text-uppercase"><?php echo 'Bonjour '.$_SESSION['pseudo']?></h2>
			<a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="?view=cart">Mes recettes préférées</a>
	</section>
	<section>
		<div class="row">
		  <div class="col-lg-12 text-center">
			<h2 class="section-heading text-uppercase">Modifier mes informations</h2>
			<h3 class="section-subheading text-muted">Seules les informations personnelles sont modifiables.</h3>
			<?php
				if (isset($_GET['err']) && $_GET['err'] == 0) echo '<div class="alert alert-success" role="alert">Vos informations ont bien été mises à jour</div>';
			?>
		  </div>
		</div>
		<form method="POST" action="controleur.php">
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-2 col-form-label">Identité</label>
			<div class="col">
			  <input type="text" name="nom" class="form-control" placeholder="Nom">
			</div>
			<div class="col">
			  <input type="text" name="prenom" class="form-control" placeholder="Prénom">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-2 col-form-label">Date de naissance</label>
			<div class="col">
			  <input type="date" name="birthdate" class="form-control" placeholder="Jour">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-2 col-form-label">Adresse postale</label>
			<div class="col">
			  <input type="text" name="adress" class="form-control" placeholder="n° de rue + rue" maxlength="100">
			</div>
			<div class="col">
			  <input type="text" name="zipcode" class="form-control" placeholder="Code Postal" maxlength="5">
			</div>
			<div class="col">
			  <input type="text" name="city" class="form-control" placeholder="Ville" maxlength="50">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-2 col-form-label">Téléphone</label>
			<div class="col">
			  <input type="text" name="tel" class="form-control" placeholder="Téléphone" maxlength="10">
			</div>
		  </div>
		  <fieldset class="form-group">
			<div class="row">
			  <legend class="col-form-label col-sm-2 pt-0">Sexe</legend>
			  <div class="col-sm-10">
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="sexe" id="gridRadios1" value="homme">
				  <label class="form-check-label" for="gridRadios1">
					Homme
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="sexe" id="gridRadios2" value="femme">
				  <label class="form-check-label" for="gridRadios2">
					Femme
				  </label>
			  </div>
			  <div class="form-check">
				  <input class="form-check-input" type="radio" name="sexe" id="gridRadios2" value="" checked>
				  <label class="form-check-label" for="gridRadios2">
					Non spécifié
				  </label>
			  </div>
			</div>
		  </fieldset>
		  <div class="form-group row">
			<div class="col-sm-10">
			  <button type="submit" name='action' value="UpdateProfile" class="btn btn-primary">Mettre à jour</button>
			</div>
		  </div>
		</form>
	</section>
</div>