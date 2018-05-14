<?php

$patientID = 0;
if (isset($_GET['id'])) {
    $patientID = (int) ($_GET['id']);
}

if (!isset($dbh)) {
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
}

function buildUserCard()
{
    global $patientID;
    if ($patientID > 0) {
        $query = "SELECT * FROM patient WHERE patient.patientID = $patientID";
        $statement = executeQuery($query);

        if ($line = $statement->fetch()) {
            echo '<div class="col-4">';
            echo '<div class="rounded-circle patient-portrait img-responsive" style="background: url(img/patient/'.strtolower($line['first_name'].$line['name']).'.jpg) no-repeat center center"></div>';
            echo '</div>';
            echo '<div class="col-8">';
            echo '<h3>'.$line['first_name'].'  '.$line['name'].'</h3>';
            echo '<p>'.$line['gender'].'<br/>'.$line['birthdate'].'</p>';
            echo '</div>';
        }
    }
}

function buildMedicamentTable($query, $columns, $id)
{
    global $patientID;
    if ($patientID > 0) {
        $statement = executeQuery($query);

        echo '<table class="table table-striped signs" id="'.$id.'">';
        echo '<tr>';
        foreach ($columns as $value) {
            echo "<th>$value</th>";
        }
        echo '</tr>';
        while ($line = $statement->fetch()) {
            echo '<tr>';
            for ($i = 0; $i < count($columns); ++$i) {
                echo "<td>$line[$i]</td>";
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<div id="warning" class="signs">No List exists</div>';
    } else {
        echo '<div id="warning" class="signs">The patient does not exist</div>';
    }
}

function buildVitalDataTable($query, $columns)
{
    global $patientID;
    if ($patientID > 0) {
        $statement = executeQuery($query);

        $currentID = 0;
        while ($line = $statement->fetch()) {
            if ($line['id'] > $currentID && $currentID > 0) {
                echo '</table>';
            }
            if ($line['id'] > $currentID) {
                echo '<table class="table table-striped signs" id="'.$line['name'].'">';
                echo '<tr>';
                foreach ($columns as $value) {
                    echo "<th>$value</th>";
                }
                echo '</tr>';
                ++$currentID;
            }
            echo '<tr>';
            for ($i = 0; $i < count($columns); ++$i) {
                echo "<td>$line[$i]</td>";
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<div id="warning" class="signs">No List exists</div>';
    } else {
        echo '<div id="warning" class="signs">The patient does not exist</div>';
    }
}

function addSelection($query)
{
    $statement = executeQuery($query);
    while ($line = $statement->fetch()) {
        echo '<option value="'.$line['id'].'">'.$line['name'].'</option>';
    }
}

function executeQuery($query)
{
    global $dbh;
    $statement = $dbh->prepare($query);
    $statement->bindParam(':patientID', $patientID, PDO::PARAM_INT);
    $result = $statement->execute();

    return $statement;
}

/* post on self: medication can be inserted into the database */
if (isset($_POST['submit'])) {
    $medID = $_POST['medicamentID'];
    $quantity = $_POST['quantity'];
    $note = $_POST['note'];
    $physicianID = $_POST['physicianID'];
    $nurseID = $_POST['nurseID'];
    $dateTime = $_POST['dateTime'];

    $query = "INSERT INTO medicine (time, quantity, medicamentID, patientID, staffID_nurse, staffID_physician, note)
	VALUES ('$dateTime',$quantity,$medID,$patientID,$nurseID,$physicianID,'$note')";
    executeQuery($query);
}

?>
