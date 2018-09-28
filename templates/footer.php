<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>
	<!-- Footer -->
		<footer>
		  <div class="container">
			<div class="row">
			  <div class="col-md-4">
				<span class="copyright">Copyright &copy; Rouanito 2018</span>
			  </div>
			  <div class="col-md-4">
				<ul class="list-inline social-buttons">
				  <li class="list-inline-item">
					<a href="#">
					  <i class="fab fa-twitter"></i>
					</a>
				  </li>
				  <li class="list-inline-item">
					<a href="#">
					  <i class="fab fa-facebook-f"></i>
					</a>
				  </li>
				  <li class="list-inline-item">
					<a href="#">
					  <i class="fab fa-linkedin-in"></i>
					</a>
				  </li>
				</ul>
			  </div>
			  <div class="col-md-4">
				<ul class="list-inline quicklinks">
				  <li class="list-inline-item">
					<a href="#">Privacy Policy</a>
				  </li>
				  <li class="list-inline-item">
					<a href="#">Terms of Use</a>
				  </li>
				</ul>
			  </div>
			</div>
		  </div>
		</footer>

		<!-- Bootstrap core JavaScript -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Plugin JavaScript -->
		<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

		<!-- Contact form JavaScript -->
		<script src="js/jqBootstrapValidation.js"></script>
		<script src="js/contact_me.js"></script>

		<!-- Custom scripts for this template -->
		<script src="js/agency.min.js"></script>
		
		<link href="css/bootstrap-toggle.min.css" rel="stylesheet">
		<script src="js/bootstrap-toggle.min.js"></script>
		
		<!-- Initialize tooltip -->
		<script>
			$(document).ready(function(){
			  $('[data-toggle="tooltip"]').tooltip()
			})
		</script>
	</body>
</html>