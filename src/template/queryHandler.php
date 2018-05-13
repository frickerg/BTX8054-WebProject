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
    global $dbh, $patientID;
    $query = "SELECT * FROM patient WHERE patient.patientID = $patientID";
    $statement = $dbh->prepare($query);
    $statement->bindParam(':patientID', $patientID, PDO::PARAM_INT);
    $result = $statement->execute();

    while ($line = $statement->fetch()) {
        echo '<div class="col-4">';
        echo '<div class="rounded-circle patient-portrait img-responsive" style="background: url(img/patient/'.strtolower($line['first_name'].$line['name']).'.jpg) no-repeat center center"></div>';
        echo '</div>';
        echo '<div class="col-8">';
        echo '<h3>'.$line['first_name'].'  '.$line['name'].'</h3>';
        echo '<p>'.$line['gender'].'<br/>'.$line['birthdate'].'</p>';
        echo '</div>';
    }
}

function executeQuery($query)
{
    global $dbh, $patientID;
    if ($patientID > 0) {
        $statement = $dbh->prepare($query);
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
}

function executeMedQuery($query)
{
    global $dbh, $patientID;
    if ($patientID > 0) {
        $statement = $dbh->prepare($query);
        $statement->bindParam(':patientID', $patientID, PDO::PARAM_INT);
        $result = $statement->execute();

        $i = 0;
        while ($line = $statement->fetch()) {
            if ($line['medicineID'] > $i) {
                echo '</table>';
            }
            if ($line['medicineID'] > $i) {
                echo '<table class="table table-striped signs" id="Medicament">';
                echo '<tr>';
                echo '<th>Medicine ID</th>';
                echo '<th>Time</th>';
                echo '<th>Quantity</th>';
                echo '<th>Medicament Name</th>';
                echo '<th>Note'.'</th>';
                echo '</tr>';
                ++$i;
            }
            echo '<tr>';
            echo '<td>'.$line['medicineID'].'</td>';
            echo '<td>'.$line['time'].'</td>';
            echo '<td>'.$line['quantity'].'</td>';
            echo '<td>'.$line['medicament_name'].'</td>';
            echo '<td>'.$line['note'].'</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<div id="warning" class="signs">No List exists</div>';
    } else {
        echo '<h1>The patient does not exist</h1>';
    }
}
