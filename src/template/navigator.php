<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="#">
		<img class="img-responsive" src="img/logo.png" alt="BFH - Bern University Of Applied Sciences">
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="listPatients.php">Home <span class="sr-only">(current)</span></a>
			</li>
		</ul>
		<ul class="navbar-nav navbar-right">
			<li class="nav-item">
				<?php echo '<a class="nav-link">You are logged in as <b>'.$_SESSION['user'].'</b></a>'; ?>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="logout.php">Logout</a>
			</li>
		</ul>

	</div>
</nav>
