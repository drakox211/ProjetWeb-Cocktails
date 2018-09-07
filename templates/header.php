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

<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rouanito Cocktails - Make your own cocktail</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/agency.min.css" rel="stylesheet">
  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="<?php echo (!isMainPage()) ? '?view=accueil': '#page-top' ?>">Rouaniato</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#services" <?php if (!isMainPage()) echo 'style="display:none;"' ?>>Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#portfolio" <?php if (!isMainPage()) echo 'style="display:none;"' ?>>Ingredients</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about" <?php if (!isMainPage()) echo 'style="display:none;"' ?>>A propos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#team" <?php if (!isMainPage()) echo 'style="display:none;"' ?>>L'équipe</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact" <?php if (!isMainPage()) echo 'style="display:none;"' ?>>Contact</a>
            </li>
			<li class="nav-item">
              <div>&nbsp </div>
            </li>
			<li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo (@$_SESSION["connecte"]) ? 'controleur.php?action=Deconnexion' : '?view=connexion' ?>" <?php if (!isMainPage()) echo 'style="display:none;"' ?>><?php if (@$_SESSION["connecte"])echo 'De' ?>Connexion</a>
            </li>
			<li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="" <?php if (!isMainPage()) echo 'style="display:none;"' ?>><i class="fas fa-shopping-cart"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>