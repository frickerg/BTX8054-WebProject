<?php
include 'template/base.php';

session_start();

unset($_SESSION['user']);

?>
<h1>Logout done</h1>
<a href="main.php">Back to login page</a>

 <?php include 'template/footer.php'; ?>
