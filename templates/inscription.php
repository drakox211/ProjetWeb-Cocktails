<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>
<div class="container" style="margin-bottom: 16px;">
			<h1 class="template-title-main">S'inscrire</h1>

     <form class="form-horizontal" method="POST" action="controleur.php" autocomplete="off">
      <fieldset>

        <!-- Form Name -->
        <legend style="padding-left: 5px;"> Enregistrez-vous ! </legend>

        <!-- Text input-->



        <div class="row">
          <div class="form-group">
            <div class="input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
              <div class="input-group-addon">
                Nom :
              </div>
              <input id="nom" name='nom' placeholder="Ex : Dupont" type="text" class="form-control input-md"  value="" onkeyup="insc_validNom(); insc_validAll();" onblur="insc_valid2Nom();"/>
            </div>
			<div id="msgnom" class="inscriptionerrormsg input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
			</div>
          </div>
        </div>



        <div class="row">
          <div class="form-group">
            <div class="input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
              <div class="input-group-addon">
                Prénom :
              </div>
              <input id="prenom" name='prenom' placeholder="Ex : Marcel" type="text" class="form-control input-md"  value="" onkeyup="insc_validPrenom(); insc_validAll();" onblur="insc_valid2Prenom();"/>
            </div>
			<div id="msgprenom" class="inscriptionerrormsg input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
			</div>
          </div>
        </div>


        <div class="row">
          <div class="form-group">
            <div class="input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
              <div class="input-group-addon">
                Numéro de licence :
              </div>
              <input id="num_licence" name='num_licence' placeholder="" type="text" class="form-control input-md"  value="" onkeyup="insc_validLicense(); insc_validAll();" onblur="insc_valid2License();"/>
            </div>
			<div id="msglicense" class="inscriptionerrormsg input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
			</div>
          </div>
        </div>


        <div class="row">
          <div class="form-group">
            <div class="input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
              <div class="input-group-addon">
                Email :
              </div>
              <input id="email" name='email' placeholder="Ex : dupont.michel@gmail.com" type="text" class="form-control input-md"  value="" onkeyup="insc_validMail(); insc_validAll();" onblur="insc_valid2Mail();"/>
            </div>
			<div id="msgmail" class="inscriptionerrormsg input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
			</div>
          </div>
        </div>


        <div class="row">
          <div class="form-group">
            <div class="input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
              <div class="input-group-addon">
                Nom d'utilisateur :
              </div>
              <input id="nom_user" name='nom_user' placeholder="Ex : Bart" type="text" class="form-control input-md"  value="" onkeyup="insc_validPseudo(); insc_validAll();" onblur="insc_valid2Pseudo();"/>
            </div>
			<div id="msgpseudo" class="inscriptionerrormsg input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
			</div>
          </div>
        </div>


        <div class="row">
          <div class="form-group">
            <div class="input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
              <div class="input-group-addon">
                Mot de passe :
              </div>
              <input id="password" name='password' placeholder="" class="form-control input-md" type="password" value="" onkeyup="insc_validPassword(); insc_confirmPassword(); insc_validAll();" onblur="insc_valid2Password();"/>
            </div>
			<div id="msgPassword" class="inscriptionerrormsg input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
			</div>
          </div>
		</div>
		
		<div class="row">
          <div class="form-group">
            <div class="input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
              <div class="input-group-addon">
                Confirmer :
              </div>
              <input id="password-confirm" name='password-confirm' class="form-control input-md" type="password" value="" onkeyup="insc_confirmPassword(); insc_validAll();" onblur="insc_confirm2Password();"/>
            </div>
			<div id="msgConfirm" class="inscriptionerrormsg input-group  col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4 col-xs-6 col-sm-5 col-md-5 col-lg-4">
			</div>
          </div>
        </div>



        <!-- Button -->
        <div class="row">
          <div class="form-group">
            <label class="col-md-4 control-label" for="soumettre"></label>
            <div class="col-md-4">
              <button id="soumettre" name='action' value="Inscription" class="btn btn-primary inscriptionbtn" disabled >Soumettre</button>
            </div>
          </div>
        </div>

      </fieldset>
    </form>

  </div>