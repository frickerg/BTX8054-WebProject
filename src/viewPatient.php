<?php include 'template/base.php';

    session_start();
    // First, we test if user is logged. If not, goto main.php (login page).
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
    include 'pdo.inc.php';
?>

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

<div class="container">
	<div class="row">
		<div id="sidebar" class="col-md-4">
			<?php
            try {
                $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

                $patientID = 0;
                if (isset($_GET['id'])) {
                    $patientID = (int) ($_GET['id']);
                }
                if ($patientID > 0) {
                    $sql0 = 'SELECT *
		                 FROM patient
		                 WHERE patient.patientID = :patientID';

                    $statement0 = $dbh->prepare($sql0);
                    $statement0->bindParam(':patientID', $patientID, PDO::PARAM_INT);
                    $result0 = $statement0->execute();

                    while ($line = $statement0->fetch()) {
                        echo '<h1>Patient - Vital Signs</h1>';
                        echo'<div class="patientinfo row">';
                        echo '<div class="col-4">';
                        echo '<div class="rounded-circle patient-portrait img-responsive" style="background: url(img/patient/'.strtolower($line['first_name'].$line['name']).'.jpg) no-repeat center center"></div>';
                        echo '</div>';
                        echo '<div class="col-8">';
                        echo '<h3>'.$line['first_name'].'  '.$line['name'].'</h3>';
                        echo '<p>'.$line['gender'].'<br/>'.$line['birthdate'].'</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            } catch (PDOException $e) {
                /*** echo the sql statement and error message ***/
                echo $e->getMessage();
            }
            ?>
				<p>Select a Sign:</p>
				<div class="btn-group" style="width:100%">
					<button class="btn-light" onclick="displayVitalSigns('Temperature');">Temperature</button>
					<button class="btn-light" onclick="displayVitalSigns('Pulse');">Pulse</button>
					<button class="btn-light" onclick="displayVitalSigns('Activity');">Activity</button>
					<button class="btn-light" onclick="displayVitalSigns('Blood Pressure');">Blood Pressure</button>
				</div>
				<h2>Medicaments List</h2>
				<div class="btn-group" style="width:100%">
					<button class="btn-light" onclick="displayMedicaments('Medicament');">Medicament</button>
				</div>
				<h3>Settings</h3>
				<p>Add a Medication</p>
				<button class="btn-light" id="addValue">
				<i class="fas fa-user-plus"></i>&nbsp;Add New Medicament
			</button>
		</div>

		<div id="main" class="col-md-8">
			<h2 id="signTitle"></h2>
			<?php
                if ($patientID > 0) {
                    $sql = "SELECT sign.signID, sign_name, value, time, note
			            FROM patient, vital_sign, sign
			            WHERE patient.patientID = $patientID
						AND patient.patientID = vital_sign.patientID
			            AND vital_sign.signID = sign.signID";

                    $statement = $dbh->prepare($sql);
                    $statement->bindParam(':patientID', $patientID, PDO::PARAM_INT);
                    $result = $statement->execute();

                    $i = 0;
                    while ($line = $statement->fetch()) {
                        if ($line['signID'] > $i) {
                            echo '</table>';
                        }
                        if ($line['signID'] > $i) {
                            echo '<table class="table table-striped signs" id="'.$line['sign_name'].'">';
                            echo '<tr>';
                            echo '<th>Vital Sign</th>';
                            echo '<th>Value</th>';
                            echo '<th>Time</th>';
                            echo '<th>Note</th>';
                            echo '</tr>';
                            ++$i;
                        }
                        echo '<tr>';
                        echo '<td>'.$line['sign_name'].'</td>';
                        echo '<td>'.$line['value'].'</td>';
                        echo '<td>'.$line['time'].'</td>';
                        echo '<td>'.$line['note'].'</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '<div id="warning" class="signs">No List exists</div>';
                } else {
                    echo '<h1>The patient does not exist</h1>';
                }
            ?>
		</div>
	</div>
</div>
<script>
	function displayVitalSigns(sign) {
		var list = document.getElementsByClassName("signs");
		for (var i = 0; i < list.length; i++) {
			list[i].style.display = "none";
		}
		try {
			document.getElementById(sign).style.display = "table";
		} catch (err) {
			document.getElementById('warning').style.display = "block";
		}
		document.getElementById('signTitle').innerHTML = sign;
	}
</script>

<?php include 'template/footer.php'; ?>
