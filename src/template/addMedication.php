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
						  <option value="4">Adrenalin</option>
						  <option value="2">Aspirin 1000 mg</option>
						  <option value="1">Aspirin 500mg</option>
						  <option value="3">Morphin</option>
					  </select>
					</div>
					<div class="form-group">
						<label for="physicianID">Physician</label>
						<select class="form-control" name="physicianID">
							<option value="1">Gregory House</option>
							<option value="2">James Wilson</option>
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
					<button type="submit" class="btn btn-primary">Save Perscription</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
$(
    function(){
        $('#time').click(function(){
			var time = moment().format('YYYY-MM-DDThh:mm:ss');
            $('#time-holder').val(time);
        });
    }
);
</script>
