var accueil=1;
var serie=0;
var login=0;
var inscription=0;
var compte=0;
var apropos=0;
var series_all=0;
var series_serie=0;
var series_anime=0;
var series_film=0;

function select(element) { // séléctionne le bon element du nav et affiche la page demandée

	var classnul = document.getElementsByClassName('noclass'); // création d'un HTMLCollection sans valeurs
	var old = document.getElementsByClassName('is-selected');
	
	if (classnul.length != old.length) { // si il y a un element de séléctioné
		if (element.classList.contains('navbuton')) { //si on selectionne autre chose qu'un filtre de recherche
			old.item(0).className = "navbuton not-selected";
		}
	}
	if (element.classList.contains('navbuton')) { // applique la classe is-selected aux elements du nav
		element.className = 'navbuton is-selected';
	} 
	if (element.id == 'series-all' || element.id == 'series-serie' || element.id == 'series-anime' || element.id == 'series-film') { // effet 'bouton radio' des types de series
		document.getElementById('series-all').className = 'asideButon whichSeries';
		document.getElementById('series-serie').className = 'asideButon whichSeries';
		document.getElementById('series-anime').className = 'asideButon whichSeries';
		document.getElementById('series-film').className = 'asideButon whichSeries';
		element.className = 'asideButon whichSeries choice';
	}
	if (element.id == 'title' || element.id == 'popularity' || element.id == 'followers') {
		document.getElementById('title').className = 'asideButon orderSeries';
		document.getElementById('popularity').className = 'asideButon orderSeries';
		document.getElementById('followers').className = 'asideButon orderSeries';
		document.getElementById('order').value = element.id;
		element.className = 'asideButon orderSeries choice';
	}
	
	if (element.id == 'detailCheck') {
		if (document.getElementById('detailBox').checked) {
			$(document).ready(function(){
				$('#displaySeries').fadeOut();
				$("footer").fadeOut();
				setTimeout(function(){
					$("#displaySeries .id").hide();
					$("#displaySeries .description").hide();
					$("#displaySeries .status").hide();
					$("#displaySeries .progression").hide();
					$("#displaySeries .note").hide();
					
					$('#displaySeries #tableSeries').css('display', 'block');
					$('#displaySeries #tableSeries').css('width', '93%');
					$('#displaySeries #tableSeries').css('margin', '1% 0 0 5%');
					$("#displaySeries .images").css('height', '12vw');
					$("#displaySeries .images").css('background-size', '12vw');
					$("#displaySeries .images").css('margin', '');
					$("#displaySeries .images").css('display', 'block');
					$("#displaySeries .images > img").css('width', '12vw');
					$("#displaySeries .title").css('display', 'block');
					$("#displaySeries .title").css('width', '12vw');
					$("#displaySeries .item").css('display', 'inline-block');
					$("#displaySeries .item").css('margin', '0 3% 2% 0');
					$("#displaySeries .item").css('vertical-align', 'top');
					
					$('#displaySeries').fadeIn();
					$("footer").css('position','absolute');
					$("footer").fadeIn();
				}, 700);
			});
		}
		else {
			$(document).ready(function(){
				$('#displaySeries').fadeOut();
				$("footer").fadeOut();
				setTimeout(function(){
					$("#displaySeries .id").fadeIn();
					$("#displaySeries .description").fadeIn();
					$("#displaySeries .status").fadeIn();
					$("#displaySeries .progression").fadeIn();
					$("#displaySeries .note").fadeIn();
					
					$('#displaySeries #tableSeries').css('display', 'table');
					$('#displaySeries #tableSeries').css('width', '95%');
					$('#displaySeries #tableSeries').css('margin', '2%');
					$("#displaySeries .images").css('height', '3vw');
					$("#displaySeries .images").css('background-size', '3vw');
					$("#displaySeries .images").css('margin', '0');
					$("#displaySeries .images").css('display', 'table-cell');
					$("#displaySeries .images > img").css('width', '3vw');
					$("#displaySeries .title").css('display', 'table-cell');
					$("#displaySeries .title").css('width', '');
					$("#displaySeries .item").css('display', 'table-row-group');
					$("#displaySeries .item").css('margin', '0');
					$("#displaySeries .item").css('vertical-align', 'middle');
					
					$('#displaySeries').fadeIn();
					$("footer").css('position','initial');
					$("footer").fadeIn();
				}, 700);
			});
		}
	}
	
	
	if (element.id == 'accueil') {
		if (accueil == 0){
			disapear();
			
			apear(element);
		}
	}
	else if (element.id == 'serie') {
		if (serie == 0) {
			disapear();
			
			apear(element);
		}
	}
	else if (element.id == 'login' || element.id == 'suite') {
		if (login == 0){
			if (element.id == 'suite') {
				document.getElementById('login').className = 'is-selected';
			}
			disapear();
			
			apear(element);
		}
	}
	else if (element.id == 'inscription' || element.id == 'insc'){
		if (inscription == 0){
			if (element.id == 'inscription') {
				document.getElementById('insc').className = 'is-selected';
			}
			disapear();
			
			apear(element);
		}
	}
	else if (element.id == 'compte'){
		if (compte == 0){
			disapear();

			apear(element);
		}
	}
	else if (element.id == 'apropos') {
		if (apropos == 0){
			disapear();
			
			apear(element);
		}
	}
	else if (element.id == 'series-all') {
		if (series_all == 0){
			//TODO : affiche les series correspondantes
		}
	}
	else if (element.id == 'series-serie') {
		if (series_serie == 0){
			//TODO : affiche les series correspondantes
		}
	}
	else if (element.id == 'series-anime') {
		if (series_anime == 0){
			//TODO : affiche les series correspondantes
		}
	}
	else if (element.id == 'series-all') {
		if (series_film == 0){
			//TODO : affiche les series correspondantes
		}
	}
}

function disapear() { // cache les éléments non nécéssaire à l'affichage
	if (accueil == 1) {
		$(document).ready(function(){
			$("#bigTitle").slideUp("slow").fadeOut("slow");
			$(".menubuton").fadeOut("slow");
		});
		accueil = 0;
	}
	else if (serie == 1) {
			$("#seriesContainer").fadeOut("slow");
			$("aside").hide("slide", { direction: "left" });
		serie = 0;
	}
	else if (login == 1){
		$(document).ready(function(){
			$("#loginTitle").slideUp("slow").fadeOut("slow");
			$(".loginput").fadeOut("slow");
			$("#logSubmit").fadeOut("slow");
			$("#logForm").fadeOut("slow");
		});
		login = 0;
	}
	else if (inscription == 1) {
		$(document).ready(function(){
			$("#inscriptionTitle").slideUp("slow").fadeOut("slow");
			$(".loginput").fadeOut("slow");
			$("#inscSubmit").fadeOut("slow");
			$("#logForm").fadeOut("slow");
		});
		inscription = 0;
	}
	else if (compte == 1) {
		$(document).ready(function(){
			$("#listeContainer").fadeOut("slow");
		});
		compte = 0;
	}
	else if (apropos == 1) {
		$(document).ready(function(){
			$("#aboutTitle").slideUp("slow").fadeOut("slow");
			$("#container").fadeOut("slow");
		});
		apropos = 0;
	}
}

function apear(element) { // affiche les éléments non nécéssaire à l'affichage
	if (element.id == 'accueil') {
		$(document).ready(function(){
			$("#bigTitle").delay(1000).fadeIn("slow");
			$(".menubuton").delay(1000).fadeIn("slow");
		});
		accueil = 1;
	}
	else if (element.id == 'serie') {
		$(document).ready(function(){
			$("#seriesContainer").delay(1000).fadeIn("slow");
			$("aside").delay(1000).show("slide", { direction: "left" });
		});
		serie = 1;
	}
	else if (element.id == 'login' || element.id == 'suite') {
		$(document).ready(function(){
			$("#logForm").delay(1000).fadeIn("slow");
			$("#loginTitle").delay(1000).fadeIn("slow");
			$(".loginput").delay(1000).fadeIn("slow");
			$("#logSubmit").delay(1000).fadeIn("slow");
		});
		login = 1;
	}
	else if (element.id == 'inscription' || element.id == 'insc') {
		$(document).ready(function(){
			$("#logForm").delay(1000).fadeIn("slow");
			$("#inscriptionTitle").delay(1000).fadeIn("slow");
			$(".loginput").delay(1000).fadeIn("slow");
			$("#inscSubmit").delay(1000).fadeIn("slow");
		});
		inscription = 1;
	}
	else if (element.id == 'compte') {
		$(document).ready(function(){
			$("#listeContainer").delay(1000).fadeIn("slow");
		});
		compte = 1;
	}
	else if (element.id == 'apropos') {
		$(document).ready(function(){
			$("#aboutTitle").delay(1000).fadeIn("slow");
			$("#container").delay(1000).fadeIn("slow");
		});
		apropos = 1;
	}
}

function error(err) {
	
	switch(err){
		case('errlog'):
		element = document.getElementById("login");
		$(document).ready(function(){
			accueil = 0;
			login = 1;
			
			document.getElementById("accueil").className = "navbuton not-selected";
			document.getElementById("login").className = "navbuton is-selected";
			
			$("#bigTitle").hide();
			$(".menubuton").hide();
			
			$("#logForm").show();
			$("#loginTitle").show();
			$(".loginput").show();
			$("#logSubmit").show();
		});
		break;
		case('errinsc'):
		element = document.getElementById("insc");
		$(document).ready(function(){
			accueil = 0;
			inscription = 1;
			
			document.getElementById("accueil").className = "navbuton not-selected";
			document.getElementById("insc").className = "navbuton is-selected";
			
			$("#bigTitle").hide();
			$(".menubuton").hide();
			
			$("#logForm").show();
			$("#inscriptionTitle").show();
			$(".loginput").show();
			$("#inscSubmit").show();
		});
		break;
		case('serie'):
		element = document.getElementById("serie");
		$(document).ready(function(){
			accueil = 0;
			serie = 1;
			
			document.getElementById("accueil").className = "navbuton not-selected";
			document.getElementById("serie").className = "navbuton is-selected";
			
			$("#bigTitle").hide();
			$(".menubuton").hide();
			
			$("#seriesContainer").show();
			$("aside").show();
		});
		break;
		case('perso'):
		element = document.getElementById("compte");
		$(document).ready(function(){
			accueil = 0;
			compte = 1;
			
			document.getElementById("accueil").className = "navbuton not-selected";
			document.getElementById("compte").className = "navbuton is-selected";
			
			$("#bigTitle").hide();
			$(".menubuton").hide();
			
			$("#listeContainer").show();
		});
		break;
	}
}