<?php
//include_once "maLibUtils.php";

/*
Ce fichier définit diverses fonctions permettant de faciliter la production de mises en formes complexes : 
tableaux, formulaires, ...
*/

function mkEntete($listeChamps=false)
{
	// Fonction appelée dans mkTable, produit une ligne d'entête
	// contenant les noms des champs à afficher dans mkTable
	// Les champs à afficher sont définis à partir de la liste listeChamps 
	// si elle est fournie ou du tableau tabAsso

	if (!$listeChamps) return;
	
	echo "<tbody class=\"item\">\n";
		echo "\t<tr>\n";
		foreach ($listeChamps as $nomChamp)	
		{
			echo "\t\t<th>$nomChamp</th>\n";
		}
		echo "\t</tr>\n";
	echo "</tbody>\n";
}

function mkLigne($tabAsso,$listeChamps=false,$origine = false,$etat)
{
	// Fonction appelée dans mkTable, produit une ligne 	
	// contenant les valeurs des champs à afficher dans mkTable
	// Les champs à afficher sont définis à partir de la liste listeChamps 
	// si elle est fournie ou du tableau tabAsso
	if (!$listeChamps)	// listeChamps est faux  : on utilise le not : '!'
	{
		// tabAsso est un tableau associatif
		echo "<tr>";
		foreach ($tabAsso as $cle => $val)	
		{
			echo "<td>$val</td>";
		}
		echo "</tr>";
	}
	else	// les champs à afficher sont dans $listeChamps
	{
		echo "<tr>";
		foreach ($listeChamps as $nomChamp)	
		{
			if($nomChamp == "images"){if (isset($tabAsso[$nomChamp]['poster'])) echo"<td class=$nomChamp><img src=\"".$tabAsso[$nomChamp]['poster']."\"/></td>"; else echo"<td class=$nomChamp></td>";}
			else if($nomChamp == "title"){
											echo "<td class=$nomChamp>"; 
											echo "<a href='index.php?view=detail&origine=$origine&idSerie=";
											echo $tabAsso['id'];
											echo "'>";
											echo $tabAsso[$nomChamp];
											echo "</a>";
											echo "</td>";
											}
			else if($nomChamp == "genres"){echo"<td class=$nomChamp>"; foreach($tabAsso[$nomChamp] as $genre){ echo "$genre ";} echo '</td>';}
			else if($nomChamp == "episode"){
											echo "<td class=$nomChamp>"; 
											$epAct = getInfo(valider("idUser","SESSION"),$tabAsso["id"],"epAct");
											echo "<span id='ep".$tabAsso["id"]."'>$epAct</span>/";
											echo $tabAsso['episodes'];
											if ($etat=="2")echo "<span class='plus' style='cursor: pointer;' onclick='plusUn(".$tabAsso['id'].",".valider("idUser","SESSION").",0);'> +</span>";
											else if($etat=="1")echo "<span class='plus' style='cursor: pointer;' onclick='plusUn(".$tabAsso['id'].",".valider("idUser","SESSION").",1);'><a href='index.php?view=perso'>+</a></span>";
											echo "</td>";
											}
			else if($nomChamp == "note"){
										echo"<td class=$nomChamp>"; 
										$note = getInfo(valider("idUser","SESSION"),$tabAsso["id"],"note");
										if ($note == NULL){
											echo "non noté";
										}
										else{
											echo "$note/10";
										}
										echo "</td>";
										}	
			else {if (isset($tabAsso[$nomChamp])) echo"<td class=$nomChamp>$tabAsso[$nomChamp]</td>"; else echo"<td class=$nomChamp></td>";}
		}
		echo "</tr>";
	}
}

function mkTbodys($tabData,$listeChamps=false,$origine = false, $etat = false)
{
	// Attention : le tableau peut etre vide 
	// On produit un code ROBUSTE, donc on teste la taille du tableau
	if (count($tabData) == 0) return;
	echo "<tbody class=\"item\">\n";
	
	// afficher une ligne de données avec les valeurs, à chaque itération
	mkLigne($tabData,$listeChamps,$origine,$etat);

	echo "</tbody>\n";
	
	// Produit un tableau affichant les données passées en paramètre
	// Si listeChamps est vide, on affiche toutes les données de $tabData
	// S'il est défini, on affiche uniquement les champs listés dans ce tableau, 
	// dans l'ordre du tableau
	
}

function search($search = false,$order = "title")
{
	if($search){

	$aContext = array(
    'http' => array(
        'proxy' => 'tcp://proxy.ig2i.fr:3128',
        'request_fulluri' => true,
    ),
);
$cxContext = stream_context_create($aContext);
	
	$url = "http://api.betaseries.com/shows/search?key=6fec4b43bb24&nbpp=10&title=".urlencode($search)."&order=".$order;
	$raw = file_get_contents($url, False/*, $cxContext*/);

	$json = json_decode($raw, TRUE);
	$tab = $json['shows'];
	
	$listeChamps = array('id','images','title','description','status');
	
	foreach ($tab as $serie)
	{
		mkTbodys($serie, $listeChamps,"search");
	}
}
else return 0;
}

function mkSerie($id=false, $listeChamps=false,$etat)
{
if(!$id || !$listeChamps)return;

	$aContext = array(
    'http' => array(
        'proxy' => 'tcp://proxy.ig2i.fr:3128',
        'request_fulluri' => true,
    ),
);
$cxContext = stream_context_create($aContext);
	

	$url = "http://api.betaseries.com/shows/display?id=".$id."&key=6fec4b43bb24";
	$raw = file_get_contents($url, False/*, $cxContext*/);

	$json = json_decode($raw, TRUE);
	$tab = $json['show'];
	mkTbodys($tab,$listeChamps,"perso",$etat);
}

function mkDetail($id=false)
{
if(!$id)return;

	$aContext = array(
    'http' => array(
        'proxy' => 'tcp://proxy.ig2i.fr:3128',
        'request_fulluri' => true,
    ),
);
$cxContext = stream_context_create($aContext);
	

	$url = "http://api.betaseries.com/shows/display?id=".$id."&key=6fec4b43bb24";
	$raw = file_get_contents($url, False/*, $cxContext*/);

	$json = json_decode($raw, TRUE);
	$tab = $json['show'];
	
	$url = "https://api.betaseries.com/shows/characters?id=".$id."&key=6fec4b43bb24";
	$raw = file_get_contents($url, False/*, $cxContext*/);

	$json = json_decode($raw, TRUE);
	$cast = $json['characters'];
	
echo "<h1>".$tab["title"]."</h1>";
	
echo "<div id='data'>
	<aside> <!-- types, genres, longeurs -->";
		if(isset($tab['images']['poster'])) echo "<img src='".$tab['images']['poster']."' alt='Image non disponible'/>";
		else echo "<img src='ressources/indispo.jpg'/>";
		echo "<article>";
			//echo "<h3>Type : Série TV</h3>";
			echo "<h3>Genres : ";
				foreach($tab["genres"] as $genre){ echo "$genre ";}
			echo "</h3>";
			echo "<h3>Longeur : ".$tab["episodes"]."eps</h3>";
			echo "<h3>Statut : ".$tab["status"]."</h3>";
		echo "</article>
	</aside>
	<section> <!--description -->
		<h2>Description :</h2>";
		echo "<p>".$tab["description"]."</p> <!-- paragraphe descriptif -->";
		if(valider("connecte","SESSION")){
			echo "<div id='perso'>";
			echo "<h3>Avancement : &nbsp </h3>";
			
				echo "<form action='controleur.php' method='GET'>
					<select name='etat' id='perso-statut' onchange='update(document.getElementById(\"perso-statut\").value)'>
						<option value=0>---</option>
						<option value=1>A regarder</option>
						<option value=2>En cours</option>
						<option value=3>Fini</option>
					</select> <br/>
					<label>Episodes : <input type='number' name='episodes' id='perso-episode' autocomplete='off' min='0' max='".$tab["episodes"]."'> /".$tab["episodes"]."</label> <br/>
					<label>Note : <input type='number' name='note' id='perso-note' autocomplete='off' min='0' max='10'> / 10 </label> <br/>
					<a href='index.php?view=perso'><input type='button' style='cursor: pointer;' onclick='update(\"4\",".valider("idUser","SESSION").",".valider("idSerie").");' value='Mettre à jour'></a>
				</form>
			</div>";
		}
	echo "</section>";
	
	echo "<section> <!-- diffusion, casting -->
		<h2>Date de création : ".$tab["creation"]."</h2>";
		echo "<h2>Premiers roles :</h2>";
			if(empty($cast) || $cast[1]["role"]!="first") echo "<p>Non disponible</p>";//<p>John Doe, Lorem Ipsum, John Doe, Lorem Ipsum, John Doe, Lorem Ipsum, John Doe, Lorem Ipsum, John Doe, Lorem Ipsum, John Doe, Lorem Ipsum</p>
			else{ $i=0; while ($cast[$i]["role"]=="first"){echo "<p>".$cast[$i]["name"]." : ".$cast[$i]["actor"]."</p>"; $i++;}}
		//echo "<h2>Commentaires :</h2>";
		//<p>ESPACE COMMENTAIRES</p>
	echo "</section>	
</div>";
}

/*

// Exemple d'appel :  mkTable($users,array('pseudo', 'couleur', 'connecte'));	
function mkTbody($tabData,$listeChamps=false)
{
	// Attention : le tableau peut etre vide 
	// On produit un code ROBUSTE, donc on teste la taille du tableau
	if (count($tabData) == 0) return;
	echo "<tbody class=\"item\">\n";
	
	// afficher une ligne de données avec les valeurs, à chaque itération
	mkLigne($tabData['show'],$listeChamps);

	echo "</tbody>\n";
	
	// Produit un tableau affichant les données passées en paramètre
	// Si listeChamps est vide, on affiche toutes les données de $tabData
	// S'il est défini, on affiche uniquement les champs listés dans ce tableau, 
	// dans l'ordre du tableau
	
}

// Exemple d'appel :  mkTable($users,array('pseudo', 'couleur', 'connecte'));	
function mkTable($tabData,$listeChamps=false)
{

	// Attention : le tableau peut etre vide 
	// On produit un code ROBUSTE, donc on teste la taille du tableau
	if (count($tabData) == 0) return;

	echo "<table border=\"1\">\n";
	// afficher une ligne d'entete avec le nom des champs
	mkLigneEntete($tabData[0],$listeChamps);

	//tabData est un tableau indicé par des entier
	foreach ($tabData as $data)	
	{
		// afficher une ligne de données avec les valeurs, à chaque itération
		mkLigne($data,$listeChamps);
	}
	echo "</table>\n";

	// Produit un tableau affichant les données passées en paramètre
	// Si listeChamps est vide, on affiche toutes les données de $tabData
	// S'il est défini, on affiche uniquement les champs listés dans ce tableau, 
	// dans l'ordre du tableau
	
}

// Produit un menu déroulant portant l'attribut name = $nomChampSelect

// Produit les options d'un menu déroulant à partir des données passées en premier paramètre
// $champValue est le nom des cases contenant la valeur à envoyer au serveur
// $champLabel est le nom des cases contenant les labels à afficher dans les options
// $selected contient l'identifiant de l'option à sélectionner par défaut
// si $champLabel2 est défini, il indique le nom d'une autre case du tableau 
// servant à produire les labels des options

// exemple d'appel : 
// $users = listerUtilisateurs("both");
// mkSelect("idUser",$users,"id","pseudo");
// TESTER AVEC mkSelect("idUser",$users,"id","pseudo",2,"couleur");

function mkSelect($nomChampSelect, $tabData,$champValue, $champLabel,$selected=false,$champLabel2=false)
{

	$multiple=""; 
	if (preg_match('/.*\[\]$/',$nomChampSelect)) $multiple =" multiple =\"multiple\" ";

	echo "<select $multiple name=\"$nomChampSelect\">\n";
	foreach ($tabData as $data)
	{
		$sel = "";	// par défaut, aucune option n'est préselectionnée 
		// MAIS SI le champ selected est fourni
		// on teste s'il est égal à l'identifiant de l'élément en cours d'affichage
		// cet identifiant est celui qui est affiché dans le champ value des options
		// i.e. $data[$champValue]
		if ( ($selected) && ($selected == $data[$champValue]) )
			$sel = "selected=\"selected\"";

		echo "<option $sel value=\"$data[$champValue]\">\n";
		echo  $data[$champLabel] . "\n";
		if ($champLabel2) 	// SI on demande d'afficher un second label
			echo  " ($data[$champLabel2])\n";
		echo "</option>\n";
	}
	echo "</select>\n";
}

function mkForm($action="",$method="get")
{
	// Produit une balise de formulaire NB : penser à la balise fermante !!
	echo "<form action=\"$action\" method=\"$method\" >\n";
}
function endForm()
{
	// produit la balise fermante
	echo "</form>\n";
}

function mkInput($type,$name,$value="",$attrs="")
{
	// Produit un champ formulaire
	echo "<input $attrs type=\"$type\" name=\"$name\" value=\"$value\"/>\n";
}

function mkRadioCb($type,$name,$value,$checked=false)
{
	// Produit un champ formulaire de type radio ou checkbox
	// Et sélectionne cet élément si le quatrième argument est vrai
	$selectionne = "";	
	if ($checked) 
		$selectionne = "checked=\"checked\"";
	echo "<input type=\"$type\" name=\"$name\" value=\"$value\"  $selectionne />\n";
}

function mkLien($url,$label, $qs="",$attrs="")
{
	echo "<a $attrs href=\"$url?$qs\">$label</a>\n";
}

function mkLiens($tabData,$champLabel, $champCible, $urlBase=false, $nomCible="")
{
	// produit une liste de liens (plus facile à styliser)
	// A partir de données fournies dans un tableau associatif	
	// Chaque lien pointe vers une url définie par le champ $champCible
	
	// SI urlBase n'est pas false, on utilise  l'url de base 
	// (avec son point d'interrogation) à laquelle on ajoute le champ cible 
	// dans la chaîne de requête, associé au paramètre $nomCible, après un '&' 

	// Exemples d'appels : 
	// mkLiens($conversations,"id","theme");
	// produira <a href="1">Multimédia</a> ...

	// mkLiens($conversations,"theme","id","index.php?view=chat","idConv");
	// produira <a href="index.php?view=chat&idConv=1">Multimédia</a> ...

	// parcourir les données de tabData 
	foreach($tabData as $data) {
		// on parcourt uniquement les valeurs
		// a chaque itération, les valeurs sont dans 
		// le tableau $data
		echo '<a href="';
		echo $urlBase . "&" . $nomCible . "=" ;
		echo $data[$champCible];
		echo '">';
		echo $data[$champLabel];
		echo "</a>\n<br />\n";
	}
}*/
?>