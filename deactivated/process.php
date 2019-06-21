<?php
ob_start();
require '../connection.php';

if(!isset($_SESSION)){ 
  session_start();
}

$fname = '';
$mname = '';
$lname = '';
$email = '';
$username = '';
$office = '';
$rank = '';
$qualifier = '';
$password = '';
$authorityLevel = '';
$email = '';
$status = '';
$dateAdded = '';

$update = false;
$delete = false;
$view = false;
$activate = false;
$error = false;
$id = 0;

$nup = '';
$po1 = '';
$po2 = '';
$po3 = '';
$spo1 = '';
$spo2 = '';
$spo3 = '';
$spo4 = '';
$pinsp = '';
$spinsp = '';
$cpinsp = '';
$psupt = '';

$admin = '';
$user = '';
$researcher = '';

//GET ID TO ACTIVATE
if(isset($_GET['activate'])){
  $id = $_GET['activate'];
  $activate = true;
}

if(isset($_POST['btnYesA'])){
  date_default_timezone_set('Asia/Singapore');
  $dateNow = date("Y-m-d H:i:s"); 
  
  $id = $_POST['id'];
  $status = 'activated';

  $resultAccount = $mysqli->query("SELECT * FROM tblaccounts WHERE id='$id'") or die($mysqli->error());
  $rowAccount = $resultAccount->fetch_assoc();

  $username = $rowAccount['username'];
  $email = $rowAccount['email'];


  $result = $mysqli->query("SELECT * FROM tblaccounts WHERE status = 'activated' AND (username = '$username' OR email = '$email')") or die($mysqli->error());
  $row = $result->fetch_assoc();

  if($row['username'] == $username){
    $_SESSION['errorMessage'] = "This user already exist";
    $_SESSION['errorMessageType'] = "danger";

    header('Location: ../deactivated/');
  }
  else if($row['email'] == $email){
    $_SESSION['errorMessage'] = "This user already exist";
    $_SESSION['errorMessageType'] = "danger";

    header('Location: ../deactivated/');
  }
  else{
    $mysqli->query("UPDATE tblaccounts SET status = '$status' WHERE id = $id") or die($mysqli->error());

    $userId = $_SESSION['userId'];
            
    $mysqli->query("INSERT INTO tblaccounttrail (userId, accountId, action, dateModified)  VALUES ('$userId', '$id', 'Activated', '$dateNow')") or die($mysqli->error);
  
    $_SESSION['message'] = "Account has been activated";
    $_SESSION['messageType'] = "success";
  
    header("Location: ../accounts/");
  }

}

//GET ID VIEW
if(isset($_GET['view'])){
  $id = $_GET['view'];
  $view = true;
  $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id = $id") or die($mysqli->error());

    $row = $result->fetch_array();
    $fname = $row['fname'];
    $mname = $row['mname'];
    $lname = $row['lname'];
    $status = ucwords($row['status']);
    $qualifier = $row['qualifier'];

    $rank = $row['rank'];
    $resultRank = $mysqli->query("SELECT * FROM tblranks WHERE id = $rank") or die($mysqli->error());
    $rowRank = $resultRank->fetch_array();

    $rank = $rowRank['rank'];
    $office = $row['office'];
    $email = $row ['email'];
    $username = $row['username'];
    $password = $row['password'];
    $authorityLevel = ucwords($row['authorityLevel']);
    $dateAdded = date('Y-d-m h:i:s a', strtotime($row['dateAdded']));
}

?>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->

