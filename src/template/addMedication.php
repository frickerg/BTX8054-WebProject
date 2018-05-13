<div class="modal fade" id="addMedication" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$patientID; ?>" method="post">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" value="1">
					<div class="form-group">
						<label for="medicamentID">Medicament</label>
						<select class="form-control" name="medicamentID">
							<?php
                                $query = 'SELECT medicamentID as id,
									medicament_name as name
									FROM medicament';
                                addSelection($query);
                            ?>
					  </select>
					</div>
					<div class="form-group">
						<label for="physicianID">Physician</label>
						<select class="form-control" name="physicianID">
							<?php
                                $query = "SELECT staffID as id,
									CONCAT(first_name, ' ', name) as name
									FROM staff
									WHERE fonctionID = 2";
                                addSelection($query);
                            ?>
						</select>
					</div>
					<div class="form-group">
						<label for="nurseID">Nurse</label>
						<select class="form-control" name="nurseID">
							<?php
                                $query = "SELECT staffID as id,
									CONCAT(first_name, ' ', name) as name
									FROM staff
									WHERE fonctionID = 1";
                                addSelection($query);
                            ?>
						</select>
					</div>
					<div class="form-group">
						<label for="dateTime">Date/Time</label>
						<input class="form-control" type="datetime-local" name="dateTime" id="time-holder">
						<br/>
						<button class="btn btn-primary" type="button" name="timer" id="time">Get the Time</button>
					</div>
					<div class="form-group">
						<label for="quantity">Quantity</label>
						<input class="form-control" type="number" name="quantity">
					</div>

					<div class="form-group">
						<label for="note">Note</label>
						<textarea class="form-control" name="note" rows="3"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" name="submit" class="btn btn-primary">Save Perscription</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(
		function() {
			$('#time').click(function() {
				var time = moment().format('YYYY-MM-DDThh:mm');
				$('#time-holder').val(time);
			});
		}
	);
</script>

<?php
global $staffID;
if (isset($_POST['submit'])) {
    $medID = $_POST['medicamentID'];
    $quantity = $_POST['quantity'];
    $note = $_POST['note'];
    $physicianID = $_POST['physicianID'];
    $nurseID = $_POST['nurseID'];
    $dateTime = $_POST['dateTime'];

    $query = "INSERT INTO medicine (time, quantity, medicamentID, patientID, staffID_nurse, staffID_physician, note)
	VALUES ('$dateTime',$quantity,$medID,$patientID,$nurseID,$physicianID,'$note')";
    executeInsertStatement($query);
}
?>
