<?php
include_once "maLibSQL.pdo.php";
include_once "maLibUtils.php";
include_once "modele.php";

$action = valider("action");
		$idUser = valider("idUser");
		$idSerie = valider("idSerie");
switch($action){
	case("inc"):
		$etat = valider("etat");
		
		if(!$etat)$SQL = "update visionage set EpAct=Epact+1 where idUser = $idUser and idSerie = $idSerie";
		else $SQL = "update visionage set EpAct=Epact+1, etat='2' where idUser = $idUser and idSerie = $idSerie";
		SQLUpdate($SQL);
		$SQL = "select EpAct from visionage where idUser = $idUser and idSerie = $idSerie";
		echo getInfo($idUser,$idSerie,"epAct");
	break;
	case("upd"):
		$ep = valider("ep");if(!$ep)$ep="default";
		$note = valider("note");if(!$note)$note="default";
		$stat = valider("stat");if(!$stat)$stat="0";
		
		if($idUser && $idSerie){
			$SQL = "SELECT idVis from visionage where idUser = $idUser and idSerie = $idSerie";
			
			if($stat=="0"){if(SQLGetChamp($SQL)){$SQL = "DELETE from visionage where idUser=$idUser and idSerie=$idSerie;";}}
			else{ 
				if (SQLGetChamp($SQL)){
					$SQL = "update visionage set EpAct=$ep, note=$note, etat=$stat where idUser=$idUser and idSerie=$idSerie;";
				}else{
					$SQL = "insert into visionage values (default,'$idUser','$idSerie',$ep,$note,$stat);";
				}
			}
			echo($SQL);
			SQLUpdate($SQL);
		}
		else echo("veuilez donner un id d'utilisateur et un id de série");
	break;
	case("load"):
		$SQL = "SELECT * from visionage where idUser = $idUser and idSerie = $idSerie";
		$tab = parcoursRs(SQLSelect($SQL));
		if($tab){ $tab = json_encode($tab[0]); echo $tab;}
		else echo "false";
	break;
}
?>
