<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>
<style>
	body {background-color: #212529; color: white;}
</style>

<section id="connexion">
    <div class="container">
	<form method="POST" action="controleur.php">
	  <div class="form-group row">
		<label for="inputPseudo" class="col-sm-2 col-form-label">Login</label>
		<div class="col-sm-10">
		  <input type="text" name="pseudo" class="form-control" id="inputPseudo" placeholder="Pseudonyme">
		</div>
	  </div>
	  <div class="form-group row">
		<label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
		<div class="col-sm-10">
		  <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
		</div>
	  </div>
	  <div class="form-group row">
		<div class="col-sm-10">
		  <button type="submit" name='action' value="Connexion" class="btn btn-primary">Log In</button>
		</div>
	  </div>
	  <div class="form-group row">
		<div class="col-sm-10">
		  <a href="?view=inscription">Pas encore inscrit ? </br>C'est ici</a>
		</div>
	  </div>
	</form>
	</div>
</section>