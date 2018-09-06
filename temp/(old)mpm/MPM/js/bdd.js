function plusUn(idSerie, idUser,etat)
{
	jQuery.ajax({
		type: "POST",
		url: "libs/liste.php",
		data: { idUser:idUser,
				idSerie:idSerie,
				etat:etat,
				action:"inc"},
		cache: false,
		success: function(retour)
		{
			console.log("Mise à jour ok");
			console.log(retour);
			document.getElementById("ep"+idSerie).innerHTML = retour;
		}
    });
}

function update(chx,idUser,idSerie) {

	switch(chx){
		case "-1"://chargement des infos au lancement de la page
			jQuery.ajax({
				type: "POST",
				url: "libs/liste.php",
				data: { idUser:idUser,
						idSerie:idSerie,
						action:"load"},
				cache: false,
				success: function(retour)
				{
					console.log("Mise à jour ok");
					console.log(retour);
					tab = JSON.parse(retour);
					console.log(tab);
					if(tab){document.getElementById("perso-statut").value = tab.Etat;document.getElementById("perso-episode").value = tab.EpAct;document.getElementById("perso-note").value = tab.Note;}
				}
			});
		break;
		case "1":
			document.getElementById('perso-episode').value = "0";
			document.getElementById('perso-episode').readOnly = true;
			
			document.getElementById('perso-note').value = "";
			document.getElementById('perso-note').readOnly = true;
		break;
		case "2":
			document.getElementById('perso-episode').readOnly = false;
			
			document.getElementById('perso-note').readOnly = false;
		break;
		case "3": // Si on change le menu deroulant sur fini, automaiquement les épisodes se mettent au max (car tous vus) et on ne peux pas editer cete valeur etc.
			document.getElementById('perso-episode').value = document.getElementById('perso-episode').max;
			document.getElementById('perso-episode').readOnly = true; 
			
			document.getElementById('perso-note').readOnly = false;
		break;
	
		case "4": // Si on met à jour
			stat = document.getElementById('perso-statut').value;
			ep = document.getElementById('perso-episode').value;
			note = document.getElementById('perso-note').value;
			jQuery.ajax({
				type: "POST",
				url: "libs/liste.php",
				data: { idUser:idUser,
						idSerie:idSerie,
						ep:ep,
						note:note,
						stat:stat,
						action:"upd"},
				cache: false,
				success: function(retour)
				{
					console.log("Mise à jour ok");
					console.log(retour);
				}
			});
			
		break;
	}
}