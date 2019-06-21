<?php
ob_start();
require '../connection.php';

if(!isset($_SESSION)){ 
  session_start();
}


date_default_timezone_set('Asia/Singapore');
$dateNow = date("Y-m-d H:i:s"); 

$currentSession = $_SESSION['current'];
$currentTimeIn = $_SESSION['timeIn'];

$mysqli->query("UPDATE tblloginhistory SET timeOut='$dateNow' WHERE id='$currentSession' AND timeIn='$currentTimeIn'") or die($mysqli->error);

session_destroy();

header('Location: ../login/');

?>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->