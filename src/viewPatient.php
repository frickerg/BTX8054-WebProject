<?php include 'template/base.php'; ?>

<div class="navbar">
	<a href="listPatients.php">Home</a>
	<a href="logout.php">Logout</a>
</div>


<?php
    session_start();
    // First, we test if user is logged. If not, goto main.php (login page).
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
    include 'pdo.inc.php';
    echo '<a> Welcome Dr. '.$_SESSION['user'].'</a>';
?>

<div class="container">
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
        }	?>
	<div class="btn-group" style="width:100%">
		<button class="btn-primary" onclick="displayVitalSigns('temperature');">Temperature</button>
		<button class="btn-primary" onclick="displayVitalSigns('pulse');">Pulse</button>
		<button class="btn-primary" onclick="displayVitalSigns('activity');">Activity</button>
		<button class="btn-primary" onclick="displayVitalSigns('bloodpressure');">Blood Pressure</button>
		<h2>Medicaments List</h2>
		<button class="btn-primary" onclick="displayMedicaments('Medicament');">Medicament</button>
	</div>

	<h3>Settings</h3>
	<p>Add a Medication</p>
	<button class="btn-primary" id="addValue">
    <i class="fas fa-user-plus"></i> Add New Medicament</button>
</div>


<div class="main">
	<h2>Vital signs</h2>
	<?php
        if ($patientID > 0) {
            $sql = 'SELECT sign.signID, sign_name, value, time, note
	            FROM patient, vital_sign, sign
	            WHERE patient.patientID = vital_sign.patientID
	            AND vital_sign.signID = sign.signID';

            $statement = $dbh->prepare($sql);
            $statement->bindParam(':patientID', $patientID, PDO::PARAM_INT);
            $result = $statement->execute();

            $i = 0;
            while ($line = $statement->fetch()) {
                if (0 == $i) {
                    echo "<table id='".strtolower($line['sign_name'])."' class='signs'>";
                    ++$i;
                } elseif ($line['signID'] > $i) {
                    echo '</table>';
                    echo "<table id='".strtolower($line['sign_name'])."' class='signs'>";
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

	}
</script>

<?php include 'template/footer.php'; ?>
