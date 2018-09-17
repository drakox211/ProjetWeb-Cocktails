<?php
include_once "maLibSQL.pdo.php";
include_once "maLibUtils.php";
include_once "modele.php";

$action = valider("action");
$value  = valider("val");
$mode   = valider("mode");

switch($action){
	case("loadBeginName"):
		if (strlen($value) == 0) {
			echo "false";
			break;
		}
		$SQL = ($mode == "true") ? "SELECT * FROM ingredients WHERE nom LIKE '".$value."%'" : "SELECT * FROM ingredients WHERE nom REGEXP '$value'";
		$tab = parcoursRs(SQLSelect($SQL));
		if($tab){ $tab = json_encode($tab, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); echo $tab;}
		else echo "false";
	break;
}
?>
