<?php

//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}
//include_once("libs/maLibForms.php");
?>

	<!-- Header -->
    <header class="masthead">
      <div class="container">
        <div class="intro-text">
          <div class="intro-lead-in">Venez découvrir nos recettes</div>
          <div class="intro-heading text-uppercase">C'est gratuit</div>
          <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="?view=overview">Parcourrir nos recettes</a>
        </div>
      </div>
    </header>

    <!-- Portfolio Grid -->
    <section class="bg-light" id="portfolio">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase">Recherche par Ingredients</h2>
            <h3 class="section-subheading text-muted">Vous cherchez un coktails avec un ou plusieurs éléments en particulier ? </br>C'est par ici.</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-sm-6 portfolio-item">
            <a class="portfolio-link" href="?view=search&path=1.0">
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-search fa-3x"></i>
                </div>
              </div>
              <img class="img-fluid" src="img/ingredients/lime.jpg" alt="">
            </a>
            <div class="portfolio-caption">
              <h4>Fruits</h4>
              <p class="text-muted">Des bons fruits de saison (ou non).</p>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 portfolio-item">
            <a class="portfolio-link" href="?view=search&path=1.3.0">
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-search fa-3x"></i>
                </div>
              </div>
              <img class="img-fluid" src="img/ingredients/sake.jpg" alt="">
            </a>
            <div class="portfolio-caption">
              <h4>Alcools</h4>
              <p class="text-muted">Une grande variété de liqueurs.</p>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 portfolio-item">
            <a class="portfolio-link" href="?view=search&path=1.3.8">
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-search fa-3x"></i>
                </div>
              </div>
              <img class="img-fluid" src="img/ingredients/sirop.jpg" alt="">
            </a>
            <div class="portfolio-caption">
              <h4>Sirops</h4>
              <p class="text-muted">Un goût sucré à vos compositions ?</p>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 portfolio-item">
            <a class="portfolio-link" href="?view=search&path=1.3.1.1.7">
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-search fa-3x"></i>
                </div>
              </div>
              <img class="img-fluid" src="img/ingredients/soda.jpg" alt="">
            </a>
            <div class="portfolio-caption">
              <h4>Sodas</h4>
              <p class="text-muted">Pour dilluer vos alcools.</p>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 portfolio-item">
            <a class="portfolio-link" href="?view=search&path=1">
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-search fa-3x"></i>
                </div>
              </div>
              <img class="img-fluid" src="img/ingredients/cinnamon.jpg" alt="">
            </a>
            <div class="portfolio-caption">
              <h4>Autres</h4>
              <p class="text-muted">Parce que tout est possible.</p>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 portfolio-item">
            <a class="portfolio-link" href="https://www.cocktail7.com/shaker-luxe-inox.htm">
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-search fa-3x"></i>
                </div>
              </div>
              <img class="img-fluid" src="img/ingredients/shaker.jpg" alt="">
            </a>
            <div class="portfolio-caption">
              <h4>Conteneurs</h4>
              <p class="text-muted">Besoin d'un nouveau shaker ?</p>
            </div>
          </div>
        </div>
      </div>
    </section>
	
    <!-- Team -->
    <section class="bg-light" id="team">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase">Notre super équipe</h2>
          </div>
        </div>
		</br></br></br>
        <div class="row">
          <div class="col-sm-4">
            <div class="team-member">
              <img class="mx-auto rounded-circle" src="img/team/1.jpg" alt="">
              <h4>Julian Roussel</h4>
              <p class="text-muted">Lead Designer</p>
              <ul class="list-inline social-buttons">
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fab fa-twitter"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fab fa-linkedin-in"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="team-member">
              <img class="mx-auto rounded-circle" src="img/team/2.jpg" alt="">
              <h4>Bader Souani</h4>
              <p class="text-muted">Lead Marketer</p>
              <ul class="list-inline social-buttons">
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fab fa-twitter"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fab fa-linkedin-in"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="team-member">
              <img class="mx-auto rounded-circle" src="img/team/3.jpg" alt="">
              <h4>Thomas Bagnato</h4>
              <p class="text-muted">Lead Developer</p>
              <ul class="list-inline social-buttons">
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fab fa-twitter"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fab fa-linkedin-in"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <p class="large text-muted">Notre équipe est composée des meilleurs éléments dans leur domaine respectif.
			Déterminé, compétent, infatiguable... Des qualités parmi tant d'autres qu'ils les ont propulsé au sommet du monde.</p>
          </div>
        </div>
      </div>
    </section>