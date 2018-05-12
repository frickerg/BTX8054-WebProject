<?php
include 'template/base.php';

session_start();

// First, we test if user is logged. If not, goto main.php (login page).
if (!isset($_SESSION['user'])) {
    header('Location: main.php');
    exit();
}

include 'pdo.inc.php';

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    /*** echo a message saying we have connected ***/
    echo '<div class="container">';
    echo '<h1>List of patients</h1>';
    $sql = 'select * from patient';

    $result = $dbh->query($sql);
    echo '<div class="row">';
    while ($line = $result->fetch()) {
        echo '<div class="col-xs-12 col-sm-6 col-lg-4">';
        echo '<div class="card">';
        echo '<div class="card-img-top img-responsive" style="background: url(img/patient/'.strtolower($line['first_name'].$line['name']).'.jpg) no-repeat center center"></div>';
        echo '<div class="card-body">';
        echo '<h2 class="card-title">'.$line['first_name'].' '.$line['name'].'</h2>';
        echo '<p class="card-text">lorem ipsum</p>';
        echo '<a class="btn btn-primary" href="viewPatient.php?id='.$line['patientID'].'">View Patient</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';

    $dbh = null;
} catch (PDOException $e) {
    /*** echo the sql statement and error message ***/
    echo $e->getMessage();
}

echo '<br>User ='.$_SESSION['user'];
?>
<br />
<i><a href="logout.php">Logout</a></i>


<?php include 'template/footer.php'; ?>
