<?php
include 'template/base.php';

session_start();

unset($_SESSION['user']);

?>
<div class="container">
	<div class="text-center">
		<img id="logoMain" class="img-responsive" src="img/logo.png" alt="BFH - Bern University Of Applied Sciences">
	</div>
	<div class="row text-center" id="logout">
		<div class="col-12">
			<h1>Logout successful</h1>
			<a class="btn btn-primary" href="main.php">Back to login page</a>
		</div>
	</div>
</div>




 <?php include 'template/footer.php'; ?>
