<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>

		<footer>
			<div id="copyright">2iSeriesList est une propriété de Corentin Apolinario et Thomas Bagnato. Tout droits réservés.</div>
		</footer>
	</body>
</html>