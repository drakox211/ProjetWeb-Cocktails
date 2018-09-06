function update() {
	var x = document.getElementById("perso-statut").value;
	
	if (x == 'Fini') { // Si on change le menu deroulant sur fini, automaiquement les épisodes se mettent au max (car tous vus) et on ne peux pas editer cete valeur etc.
		document.getElementById('perso-episode').value = METTRE_ICI_VARIABLE_EPISODES_TOTAUX;
		document.getElementById('perso-episode').readOnly = true; 
		
		document.getElementById('perso-episode').value = METTRE_ICI_VARIABLE_NOTE_PERSO;
		document.getElementById('perso-note').readOnly = false;
	} else if (x == 'A regarder') {
		document.getElementById('perso-episode').value = "";
		document.getElementById('perso-episode').readOnly = true;
		
		document.getElementById('perso-note').value = "";
		document.getElementById('perso-note').readOnly = true;
	} else if (x == 'En cours') {
		document.getElementById('perso-episode').value = METTRE_ICI_VARIABLE_EPISODES_VUS;
		document.getElementById('perso-episode').readOnly = false;
		
		document.getElementById('perso-episode').value = METTRE_ICI_VARIABLE_NOTE_PERSO;
		document.getElementById('perso-note').readOnly = false;
	}
}