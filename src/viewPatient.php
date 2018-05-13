<?php include 'template/base.php';

    session_start();
    // First, we test if user is logged. If not, goto main.php (login page).
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
    include 'pdo.inc.php';
    include 'template/navigator.php';
?>

<div class="container">
	<div class="row">
		<div id="sidebar" class="col-md-4">
			<h1>Patient Overview</h1>
			<div class="patientinfo row">
				<?php
                    buildUserCard();
                ?>
			</div>
			<h2>Vital Signs</h2>
			<p>Select a Sign:</p>
			<div class="btn-group" style="width:100%">
				<button class="btn-light" onclick="displayVitalSigns('Temperature');">Temperature</button>
				<button class="btn-light" onclick="displayVitalSigns('Pulse');">Pulse</button>
				<button class="btn-light" onclick="displayVitalSigns('Activity');">Activity</button>
				<button class="btn-light" onclick="displayVitalSigns('Blood Pressure');">Blood Pressure</button>
			</div>
			<h2>Medication List</h2>
			<div class="btn-group" style="width:100%">
				<button class="btn-light" onclick="displayVitalSigns('Medicament');">Display All</button>
			</div>
			<p>Add a Medication</p>
			<button class="btn-light" id="addValue" data-toggle="modal" data-target="#addMedication">
					<i class="fas fa-user-plus"></i>&nbsp;Add New Medication
				</button>

			<!-- Modal -->
			<div class="modal fade" id="addMedication" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
						</div>
						<div class="modal-body">
							...
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="main" class="col-md-8">
			<h2 id="signTitle"></h2>
			<?php
                $vitalQuery = "SELECT sign.signID, sign_name, value, time, note
					FROM patient, vital_sign, sign
					WHERE patient.patientID = $patientID
					AND patient.patientID = vital_sign.patientID
					AND vital_sign.signID = sign.signID";
                executeQuery($vitalQuery);
                $medQuery = "SELECT m.medicineID, m.medicamentID, m.time, m.quantity, me.medicament_name, m.note
							FROM medicine m, medicament me
							WHERE m.medicineID = me.medicamentID
							AND m.patientID = $patientID";
                executeMedQuery($medQuery);
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
