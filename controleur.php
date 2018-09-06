<?php


session_start();

include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/maLibSecurisation.php"; 
include_once "libs/modele.php"; 

$addArgs = "";

if ($action = valider("action"))
{
	switch($action)
	{
		case 'setPlanningEntrainement': 
		if (!empty($_FILES["planning"])){

			uploadPlanning("planning");
		}

		$addArgs = "?view=vueAdmin";
		break;

		case 'setPhotoTarifs': 
		if (!empty($_FILES["tarif"])){

			uploadPhotoTarif("tarif");
		}

		$addArgs = "?view=vueAdmin";
		break;

		case 'setPhotoSalle': 
		if (!empty($_FILES["salle"])){

			uploadPhotoSalle("salle");
		}

		$addArgs = "?view=vueAdmin";
		break;

		case 'RecupMDP':
		$login = $_POST['nom_user'];

		if( $login ){
			$user = utilisateurParLogin($login)[0];
			$pass = randomPassword(16);
			$hash = password_hash($pass, PASSWORD_DEFAULT);
			changerPasse($user['iduser'], $hash);


//Array ( [iduser] => 17 [nom] => max [prenom] => mosse [admin] => 0 [pseudo] => test [mail] => thomasg3576@gmail.com [blacklist] => 0 [noLicense] => 0123 [password] => $2y$10$CGXFBHZS9fd78XOS2Vfgqe2nrYZFtIbQXnOsPYrCI7png4zxSsu9C [valid] => 0 [tel] => 0123456789 ) 
			$to    = $user['mail'];
			$from  = "noreply@as-roost-warendin-dmf.fr";  // adresse MAIL OVH liée à ton hébergement.
			$Subject1 = html_entity_decode("Mot de passe oublié  ");
			$Subject = mb_encode_mimeheader($Subject1,"UTF-8", "B", "\n");																 

			$mail_Data = "<html><body>Bonjour,<br><br>";
			$mail_Data .= " Votre nouveau mot de passe est:  $pass<br/>";
			$mail_Data .= " Vous pouvez dès maintenant vous connecter avec ce mot de passe et aller le changer dans votre profil.<br/>";			
			$mail_Data .= " <br>";
			$mail_Data .= " Cordialement, <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " L'AS ROOST WARENDIN <br>";
			$mail_Data .= " <a href=\"https://as-roost-warendin-dmf.fr\" target=\"_blank\" style=\"color:blue;\">Notre site</a> <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " Veuillez ne pas répondre à ce message. <br></body></html>";

			$headers  = "MIME-Version: 1.0 \n";
			$headers .= "Content-type: text/html; charset=utf-8 \n";
			$headers .= "From: $from  \n";

			$headers .= "X-Priority: 1  \n";
			$headers .= "X-MSMail-Priority: High \n";

			$CR_Mail = TRUE;

			$CR_Mail = @mail ($to, $Subject, $mail_Data, $headers);

		}
		$addArgs = "?err=4";
		break;

		case 'Connexion' :
		if (verifUser($_POST["pseudo"],$_POST["password"])) {
			setcookie('cookielogin', $_POST["pseudo"], time() + 3600 * 24 * 10);
		}

		else $addArgs = "?err=1";

		break;

		case 'Deconnexion' :
		setcookie("cookielogin", "", time() - 3600);
		session_destroy();
		break;
		
		case 'Inscription' :
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);// pour crypter le mot de passe
		addUser($_POST["nom"],$_POST["prenom"],$_POST["email"],$_POST["nom_user"],$password,$_POST["num_tel"]);
		if (verifUser($_POST["nom_user"],$_POST["password"])) {
			setcookie('cookielogin', $_POST["nom_user"], time() + 3600 * 24 * 10);

			//Envoie mail à thierry pour lui informer qu'un nouvel utilisateur s'est inscrit
			$to    = "thom1998@orange.fr";
			$from  = "noreply@as-roost-warendin-dmf.fr";  // adresse MAIL OVH liée à ton hébergement.
			$Subject = utf8_decode ("Nouveau membre a valider");

			$mail_Data = "<html><body>Bonjour,<br><br>";
			$mail_Data .= " Un nouveau membre s'est inscrit sur le site.<br/>";
			$mail_Data .= " Veuillez aller le valider dans votre espace \"admin\".<br/>";								
			$mail_Data .= " <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " Cordialement, <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " L'AS ROOST WARENDIN <br>";
			$mail_Data .= " <a href=\"https://as-roost-warendin-dmf.fr\" target=\"_blank\" style=\"color:blue;\">Notre site</a> <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " Veuillez ne pas répondre à ce message. <br></body></html>";

			$headers  = "MIME-Version: 1.0 \n";
			$headers .= "Content-type: text/html; charset=utf-8 \n";
			$headers .= "From: $from  \n";

			$headers .= "X-Priority: 1  \n";
			$headers .= "X-MSMail-Priority: High \n";

			$CR_Mail = TRUE;

			$CR_Mail = @mail ($to, $Subject, $mail_Data, $headers);


			$addArgs = "?err=2";
		}
		break;

		case 'sauvegarderModifAdmin' :
		$fichier = $_POST["fichier"];
		$texte = $_POST["texte"];

									// $texte = "date : ".$_POST["date"]."  resultat : ".$_POST["resultat"]; //pour faire des tests

		sauvegarderTxt($fichier,$texte);
		$addArgs = "?view=vueAdmin";
		break;

		case 'validerUtil' :
		if ($idUser = valider("idUser")){
			for ($i=0; $i < sizeof($idUser) ; $i++) { 
				validerUtilisateur($idUser[$i]);
			}
		}
		$addArgs = "?view=vueAdmin";
		break;

		case 'autoriser' :
		if ($idUser = valider("idUser"))
			autoriserUtilisateur($idUser);
		$addArgs = "?view=vueAdmin";
		break;

		case 'interdire' :
		if ($idUser = valider("idUser"))
			interdireUtilisateur($idUser);
		$addArgs = "?view=vueAdmin";
		break;
		case 'suppNews' :
		if ($id = valider("idNews"))
			supprimerNews($id);
		$addArgs = "?view=vueAdmin";
		break;

		case 'ajoutNews' :
		if (($titre = valider("titre")) && ($contenu = valider("contenu")))
			$idNews = ajouterNews($titre, $contenu);
		$addArgs = "?view=vueAdmin";
		break;

		case 'Tournament' :
		$name = $_POST["name"];
		$date = $_POST["date"];
		$date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));
		$description = $_POST["description"];
		$id = $_SESSION["idUser"];
		$rule = $_POST["rule"];
		
		$name = addslashes($name);
		$description = addslashes($description);
		$rule = addslashes($rule);
		createTournament($name, $date, $description, $id, $rule);
		$addArgs = "?view=tournois";
		break;
		
		case 'DelTour' :
		$idt = $_GET["idt"];
		
		broadcastDelTour($idt);
		delTournament($idt);
		$addArgs = "?view=tournois";
		break;

		case 'Covoiturage' :
		$nbplaces = intval($_POST["nbplaces"]);
		$heure = $_POST["heure"];
		$lieu = $_POST["location"];
		$idtournoi = $_GET["id"];
		$iduser = $_SESSION["idUser"];
		
		createCovoiturage($nbplaces, $heure, $lieu, $iduser, $idtournoi);
		$addArgs = "?view=tournoi&id=" . $idtournoi;
		break;
		
		case 'DelCovoiturage' :
		$idt = $_GET["id"];
		$idu = $_SESSION["idUser"];
		
		broadcastDelCov($idt, $idu);
		delCovoiturage($idt,$idu);
		$addArgs = "?view=tournoi&id=" . $idt;
		break;
		
		case 'Inscription Covoiturage' :
		$idc = $_GET["idc"];
		$idt = $_GET["idt"];
		$idu = $_SESSION["idUser"];
		$uname = getUser($idu);
		$tname = getTournament($idt)[0]["nom"];

		$to    = getMail(getCreator($idc));
		$from  = "noreply@as-roost-warendin-dmf.fr";  // adresse MAIL OVH liée à ton hébergement.
		$Subject = utf8_decode ("[$tname] Demande d'inscription au covoiturage ");

		$mail_Data = "<html><body>Bonjour,<br><br>";
		$mail_Data .= " L'utilisateur $uname souhaite s'inscrire à votre covoiturage.<br/>";	
		$mail_Data .= " Vous pouvez accepter sa requête via la page web de votre covoiturage.<br>";		
		$mail_Data .= " <br>";
		$mail_Data .= " Cordialement, <br>";
		$mail_Data .= " <br>";
		$mail_Data .= " L'AS ROOST WARENDIN <br>";
		$mail_Data .= " <a href=\"https://as-roost-warendin-dmf.fr\" target=\"_blank\" style=\"color:blue;\">Notre site</a> <br>";
		$mail_Data .= " <br>";
		$mail_Data .= " <br>";
		$mail_Data .= " Veuillez ne pas répondre à ce message. <br></body></html>";

		$headers  = "MIME-Version: 1.0 \n";
		$headers .= "Content-type: text/html; charset=utf-8 \n";
		$headers .= "From: $from  \n";
		$headers .= "X-Priority: 1  \n";
		$headers .= "X-MSMail-Priority: High \n";

		$CR_Mail = TRUE;
		$CR_Mail = @mail($to, $Subject, $mail_Data, $headers);
		inscCov($idu,$idc);
		$addArgs = "?view=tournoi&note=1&id=" . $idt;
		break;
		
		case 'AuthCov' :
		$idt = $_GET["idt"];
		$idc = $_GET["idc"];
		$idu = $_GET["idu"];
		$tname = getTournament($idt)[0]["nom"];
		
		$to    = getMail($idu);
		$from  = "noreply@as-roost-warendin-dmf.fr";  // adresse MAIL OVH liée à ton hébergement.
		$Subject = utf8_decode ("[$tname] Validation d'inscription au covoiturage ");

		$mail_Data = "<html><body>Bonjour,<br><br>";
		$mail_Data .= " Votre inscription au covoiturage pour le tournoi $tname a été validée par le chauffeur.<br/>";		
		$mail_Data .= " <br>";
		$mail_Data .= " Cordialement, <br>";
		$mail_Data .= " <br>";
		$mail_Data .= " L'AS ROOST WARENDIN <br>";
		$mail_Data .= " <a href=\"https://as-roost-warendin-dmf.fr\" target=\"_blank\" style=\"color:blue;\">Notre site</a> <br>";
		$mail_Data .= " <br>";
		$mail_Data .= " <br>";
		$mail_Data .= " Veuillez ne pas répondre à ce message. <br></body></html>";

		$headers  = "MIME-Version: 1.0 \n";
		$headers .= "Content-type: text/html; charset=utf-8 \n";
		$headers .= "From: $from  \n";
		$headers .= "X-Priority: 1  \n";
		$headers .= "X-MSMail-Priority: High \n";

		$CR_Mail = TRUE;
		$CR_Mail = @mail($to, $Subject, $mail_Data, $headers);
		
		validCov($idc,$idu);
		$addArgs = "?view=tournoi&id=" . $idt;
		break;
		
		case 'tournamentSub' :
		$idt = $_GET["id"];
		$idu = $_SESSION["idUser"];
		
		tournoiIns($idt,$idu);
		$addArgs = "?view=tournoi&id=" . $idt;
		break;
		
		case 'tournamentUns' :
		$idt = $_GET["id"];
		$idu = $_SESSION["idUser"];
		
		tournoiDes($idt,$idu);
		$addArgs = "?view=tournoi&id=" . $idt;
		break;

		case 'setMdp' :
		if ($nouveauPasse = valider("password"))
			if (valider("connecte","SESSION")) {
				$idUser = $_SESSION["idUser"]; 
				$user = utilisateurParId($idUser)[0];
					$password = password_hash($nouveauPasse, PASSWORD_DEFAULT);// pour crypter le mot de passe
					changerPasse($idUser,$password); // chgt BDD
					$addArgs = "?err=3";

					//Array ( [iduser] => 17 [nom] => max [prenom] => mosse [admin] => 0 [pseudo] => test [mail] => thomasg3576@gmail.com [blacklist] => 0 [noLicense] => 0123 [password] => $2y$10$CGXFBHZS9fd78XOS2Vfgqe2nrYZFtIbQXnOsPYrCI7png4zxSsu9C [valid] => 0 [tel] => 0123456789 ) 
					$to    = $user['mail'];
			$from  = "noreply@as-roost-warendin-dmf.fr";  // adresse MAIL OVH liée à ton hébergement.
			$Subject = utf8_decode ("Changement de votre mot de passe  ");

			$mail_Data = "<html><body>Bonjour,<br><br>";
			$mail_Data .= " Nous vous informons que votre mot de passe a été modifié.<br/>";
			$mail_Data .= " Si vous n'avez pas demandé de changement de mot passe, veuillez faire \"mot de passe oublié\" pour en avoir un nouveau.<br/>";		
			$mail_Data .= " Si cela se reproduit, veuillez contacter Thierry Tartar : 06 26 43 79 66<br/>";							
			$mail_Data .= " <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " Cordialement, <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " L'AS ROOST WARENDIN <br>";
			$mail_Data .= " <a href=\"https://as-roost-warendin-dmf.fr\" target=\"_blank\" style=\"color:blue;\">Notre site</a> <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " <br>";
			$mail_Data .= " Veuillez ne pas répondre à ce message. <br></body></html>";

			$headers  = "MIME-Version: 1.0 \n";
			$headers .= "Content-type: text/html; charset=utf-8 \n";
			$headers .= "From: $from  \n";

			$headers .= "X-Priority: 1  \n";
			$headers .= "X-MSMail-Priority: High \n";

			$CR_Mail = TRUE;

			$CR_Mail = @mail ($to, $Subject, $mail_Data, $headers);
		}

		break;

		case 'addSponsor' :						
		if (!empty($_FILES["logo"]) && $lien = valider("lien")){

			$upload1 = upload("logo", $lien );
		}

		$addArgs = "?view=vueAdmin";
		break;

		case 'deleteSponsor' :						
		if ($idSponsor = valider("sponsors")){

			suppSponsor($idSponsor );
		}

		$addArgs = "?view=vueAdmin";
		break;

		case 'addMembreBureau' :						
		if (!empty($_FILES["bureau"]) && $description_membre_bureau = valider("description_membre_bureau")){

			uploadMembreBureau("bureau", $description_membre_bureau );
		}

		$addArgs = "?view=vueAdmin";
		break;

		case 'deleteBureau' :						
		if ($idBureau = valider("bureau")){

			suppBureau($idBureau );
		}

		$addArgs = "?view=vueAdmin";
		break;


		case 'addEntraineur' :						
		if (!empty($_FILES["entraineur"]) && $nomEntraineur = valider("description_entraineur")){

			uploadEntraineur("entraineur", $nomEntraineur );
		}

		$addArgs = "?view=vueAdmin";
		break;	

		case 'deleteEntraineur' :						
		if ($idEntraineur = valider("entraineur")){

			suppEntraineur($idEntraineur );
		}

		$addArgs = "?view=vueAdmin";
		break;		


		case 'deleteFichier' :						
		if ($idFichier = valider("dowload")){

			suppFichier($idFichier );
		}

		$addArgs = "?view=vueAdmin";
		break;					


		case 'addFichier' :						
		if (!empty($_FILES["dowload_file"]) && $descriptionFichier = valider("description_fichier")){

			uploadFichier("dowload_file", $descriptionFichier );
		}

		$addArgs = "?view=vueAdmin";
		break;			

		case 'addTopic':
		$idTopic=addTopic(htmlspecialchars(addslashes($_POST["titre"])),htmlspecialchars(addslashes($_POST["desc"])));
		$addArgs="?view=sujetsForum&idTopic=".$idTopic;
		break;
		
		case 'addSujet':
		$idSujet=addSujet(htmlspecialchars(addslashes($_POST["titre"])),htmlspecialchars(addslashes($_POST["desc"])),$_GET["idTopic"],$_SESSION["idUser"]);
		$addArgs="?view=commentaires&idsujet=".$idSujet;
		break;

		case 'addCommentaire':
		addCommentaire(htmlspecialchars(addslashes($_POST["desc"])),$_SESSION["idUser"],$_GET["idsujet"]);
		$addArgs="?view=commentaires&idsujet=".$_GET["idsujet"];
		break;
		
		case 'Uploader' :
			//il faut checker notre maxfileupload http://php.net/manual/fr/ini.core.php#ini.max-file-uploads
			//il faut checker 
		$error1=0;
		$error2=0;
		$error3=0;
		$destfol = "./ressources/gallerie/".$_POST["repertoireCourant"]."/";
		$monfichier = fopen($destfol.'config.config', 'r+'); 
					$compteurImages = fgets($monfichier);//on lit la première ligne du fichier
					
					$extensions_ok =  array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
					

					foreach ($_FILES["sentfile"]["error"] as $key => $error) //as key : assigne en plus la clé de l'élément courant à la variable $key à chaque itération.
					{
						switch ($error)
						{ 
					    	case UPLOAD_ERR_OK : //pas d'erreur d'upload
					    	if( in_array( exif_imagetype($_FILES['sentfile']['tmp_name'][$key]), $extensions_ok ) )
								{			//SECURITE; exif_imagetype renvoie le vrai type du fichier
									$tmp_name = $_FILES["sentfile"]["tmp_name"][$key];
									$tmp = explode(".", $_FILES["sentfile"]["name"][$key]);

							        $extension='.'.end($tmp); //recupere l'extension de l'image pour la renommer sur le serveur$extension='.'.end(explode(".", $_FILES["sentfile"]["name"][$key])); //recupere l'extension de l'image pour la renommer sur le serveur
							        move_uploaded_file($tmp_name, $destfol.$compteurImages.$extension );
							        $compteurImages++;						        

							    }
							    else $error1=1;
							    break;
					    	case UPLOAD_ERR_FORM_SIZE :   // http://php.net/manual/fr/features.file-upload.errors.php
					    	$error2=1;
					    	break;
					    	case UPLOAD_ERR_CANT_WRITE :
					    	$error3=1;
					    	break;      
					    }
					}

					$addArgs="?view=galerie&dossier=".$_POST["repertoireCourant"];
					if ($error1) $addArgs.="&uploadOk=0&ERREUR_TYPE_FICHIER=1";
					else if ($error2) $addArgs.="&uploadOk=0&UPLOAD_ERR_FORM_SIZE=1"; 
					else if ($error3) $addArgs.="&uploadOk=0&UPLOAD_ERR_CANT_WRITE=1"; 
					else $addArgs.="&uploadOk=1";

					fseek($monfichier, 0);//met le pointeur de lecture/ecriture au debut du fichier
					fputs($monfichier, $compteurImages); //met à jour le nb d'images
					fclose($monfichier);


					break;	

					case 'creerDossier' :
					if ($_POST["nomDossier"] == "") {
						$addArgs="?view=galerie&dossiervide";
						break;
					}
					if(!is_dir("./ressources/gallerie/".$_POST["nomDossier"])) {
						$a = mkdir("./ressources/gallerie/".$_POST["nomDossier"], 0777, true);
						if ( $a ){
							$file = fopen('./ressources/gallerie/'.$_POST["nomDossier"].'/config.config', 'w+'); 
							fputs($file, 0);
							fclose($file);
							$addArgs="?view=galerie&dossier=".$_POST["nomDossier"];
						}
						else 
							$addArgs="?view=galerie&creer=0";
					}
	                else{ //le nom de dossier demandé existe déjà
	                	$addArgs="?view=galerie&ko=1";
	                	$i=0;
	                	while (1){
	                		if(is_dir( "./ressources/gallerie/".$_POST["nomDossier"] ." (".$i.")"))
	                			$i++;
	                		else {
	                			mkdir("./ressources/gallerie/".$_POST["nomDossier"] ." (".$i.")", 0777, true);
	                			$file = fopen('./ressources/gallerie/'.$_POST["nomDossier"]." (".$i.')/config.config', 'w+'); 
	                			fputs($file, 0);
	                			fclose($file);
	                			$addArgs="?view=galerie&creer=1";
	                			break;
	                		}
	                	}
	                }
	                break;	

	                case 'supprimerPhotos' :
	                $addArgs="?view=galerie&dossier=".$_POST["repertoireCourantSuppresion"];
	                if ( $img_delete = valider('img_delete')  )
	                {
	                	foreach ($img_delete as $path)
	                	{
	                		echo "Suppression image : ",$path,"<br>";
	                		unlink( $path );
	                	}
	                }
	                break;

	                case 'supprimerDossier' :
	                $addArgs="?view=galerie";
	                if ( $folder_delete = valider('folder_delete')  )
	                {
	                	foreach ($folder_delete as $path)
	                	{
	                		echo "Suppression dossier : ",$path,"<br>";
	                		rmAllDir( $path );
	                	}
	                }
	                break;
	            }




	        }

	        $host  = $_SERVER['HTTP_HOST'];
	        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');


	        header("Location: http://$host$uri/$addArgs");

	// On écrit seulement après cette entête
	        ob_end_flush();

	        ?>