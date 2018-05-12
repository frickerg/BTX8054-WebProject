<?php include 'template/base.php'; ?>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">
				<img class="img-responsive" src="img/logo.png" alt="BFH - Bern University Of Applied Sciences">
			</a>

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
            </button>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="listPatients.php">Home</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
		<!--/.nav-collapse -->
	</div>
	<!--/.container-fluid -->
</nav>

<?php
    session_start();
    // First, we test if user is logged. If not, goto main.php (login page).
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
    include 'pdo.inc.php';
?>
<div class="container" id="sidebar">
	<div class="row">
		<div class="col-xs-12">
			<?php
            echo '<a> Welcome Dr. '.$_SESSION['user'].'</a>';
            ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<h2>Vital Signs List</h2>

			<?php
            try {
                $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

                $patientID = 0;
                if (isset($_GET['id'])) {
                    $patientID = (int) ($_GET['id']);
                }
                if ($patientID > 0) {
                    $sql0 = 'SELECT name, first_name
		                 FROM patient
		                 WHERE patient.patientID = :patientID';

                    $statement0 = $dbh->prepare($sql0);
                    $statement0->bindParam(':patientID', $patientID, PDO::PARAM_INT);
                    $result0 = $statement0->execute();

                    while ($line = $statement0->fetch()) {
                        echo '<h2> Patient: '.$line['first_name'].'  '.$line['name'].'</h2>';
                        echo '<h5>Select a Sign:</h5>';
                    }
                }
            } catch (PDOException $e) {
                /*** echo the sql statement and error message ***/
                echo $e->getMessage();
            }
            ?>
			<div class="btn-group" style="width:100%">
				<button class="btn-light" onclick="displayVitalSigns('Temperature');">Temperature</button>
				<button class="btn-light" onclick="displayVitalSigns('Pulse');">Pulse</button>
				<button class="btn-light" onclick="displayVitalSigns('Activity');">Activity</button>
				<button class="btn-light" onclick="displayVitalSigns('Blood Pressure');">Blood Pressure</button>
				<h2>Medicaments List</h2>
				<button class="btn-light" onclick="displayMedicaments('Medicament');">Medicament</button>
			</div>

			<h3>Settings</h3>
			<p>Add a Medication</p>
			<button class="btn-light" id="addValue">
				<i class="fas fa-user-plus"></i>&nbsp;Add New Medicament
			</button>
		</div>

		<div class="col-lg-8">
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
