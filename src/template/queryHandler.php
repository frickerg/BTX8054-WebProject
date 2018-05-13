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

function buildPatientDataTable($query, $columns, $id)
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
                if (is_null($id)) {
                    echo '<table class="table table-striped signs" id="'.$line['name'].'">';
                } else {
                    echo '<table class="table table-striped signs" id="'.$id.'">';
                }
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

function executeQuery($query)
{
    global $dbh;
    $statement = $dbh->prepare($query);
    $statement->bindParam(':patientID', $patientID, PDO::PARAM_INT);
    $result = $statement->execute();

    return $statement;
}
