<?php
include_once "maLibSQL.pdo.php";
include_once "maLibUtils.php";
include_once "modele.php";

$action = valider("action");
$value  = valider("value");
switch($action){
	case("loadBeginName"):
		if (strlen($value) == 0) {
			echo "false";
			break;
		}
		$value .= '%';
		$SQL = "SELECT * FROM ingredients WHERE nom LIKE '$value' GROUP BY NOM";
		$tab = parcoursRs(SQLSelect($SQL));
		if($tab){ $tab = json_encode($tab, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); echo $tab;}
		else echo "false";
	break;
}
?>
