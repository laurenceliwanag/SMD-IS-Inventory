<?php
ob_start();
require '../connection.php';

if(!isset($_SESSION)){ 
  session_start();
}
$logo = '';
$name = '';
$office = '';
$itOfficer = '';
$itOfficerContact = '';
$itOfficerEmail = '';
$description = '';
$environment = '';
$devTool = '';
$backEnd = '';
$source = '';
$withContract = '';
$dictmCertified = '';
$systemDoc = '';
$userManual = '';
$userAcceptance = '';
$typeIS = '';
$statusIS = '';
$remarks = '';
$preparedBy = '';
$developedBy = '';
$developedByContact = '';
$developedByEmail = '';
$dateInitiated = '';
$developmentDate = '';
$turnOverDate = '';
$implementDate = '';
$status = '';
$dateAdded = '';

$update = false;
$delete = false;
$view = false;
$activate = false;
$error = false;
$id = 0;

$lanBased = '';
$webBased = '';
$cloudBased = '';

$inHouseITMS = '';
$inHouseUnit = '';
$outsource = '';


$administrative = '';
$operationsIS = '';
$supportOperationsIS = '';

$operational = '';
$nonOperational = '';
$forDevelopment = '';
$forEnhancement = '';


$yesContract = '';
$noContract = '';

$yesCertified = '';
$noCertified = '';

$yesSystemDoc = '';
$noSystemDoc = '';
$yesUserManual = '';
$noUserManual = '';
$yesUserAcceptance = '';
$noUserAcceptance = '';


//GET ID TO ACTIVATE
if(isset($_GET['activate'])){
  $id = $_GET['activate'];
  $activate = true;
}

if(isset($_POST['btnYesA'])){
  date_default_timezone_set('Asia/Singapore');
  $dateNow = date("Y-m-d H:i:s"); 
  
  $id = $_POST['id'];
  $status = 'active';

  $resultSystem = $mysqli->query("SELECT * FROM tblsystems WHERE id='$id'") or die($mysqli->error());
  $rowSystem = $resultSystem->fetch_assoc();

  $name = $rowSystem['name'];

  $result = $mysqli->query("SELECT * FROM tblsystems WHERE status = 'active' AND name = '$name'") or die($mysqli->error());
  $row = $result->fetch_assoc();

  if($row['name'] == $name){
    $_SESSION['errorMessage'] = "This system already exist";
    $_SESSION['errorMessageType'] = "danger";

    header('Location: ../deleted/');
  }
  else{
    $mysqli->query("UPDATE tblsystems SET status = '$status' WHERE id = $id") or die($mysqli->error());

    $userId = $_SESSION['userId'];
      
    $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$id', 'Recovered', '$dateNow')") or die($mysqli->error);
  
    $_SESSION['message'] = "System has been recovered";
    $_SESSION['messageType'] = "success";
  
    header("Location: ../systems/");
  }
}

//GET ID VIEW
if(isset($_GET['view'])){
  $id = $_GET['view'];
  $view = true;
  $result = $mysqli->query("SELECT * FROM tblsystems WHERE id = $id") or die($mysqli->error());

  $row = $result->fetch_array();
  $logo = $row['logo'];
  $name = $row['name'];
  $office = $row['office'];
  $itOfficerRank = $row['itOfficerRank'];
    
  $resultRank = $mysqli->query("SELECT * FROM tblranks WHERE id = $itOfficerRank") or die($mysqli->error());
  $rowRank = $resultRank->fetch_array();

  $itOfficerRank = $rowRank['rank'];
  $itOfficer = $row['itOfficer'];
  $itOfficerContact = $row['itOfficerContact'];
  $itOfficerEmail = $row['itOfficerEmail'];
  $description = $row['description'];
  $environment = $row['environment'];
  $appFunction = $row['appFunction'];

  $resultAppFunction = $mysqli->query("SELECT * FROM tblappfunction WHERE id = $appFunction") or die($mysqli->error());
  $rowAppFunction = $resultAppFunction->fetch_array();

  $appFunction = $rowAppFunction['appFunctionality'];
  $operatingSystem = $row['operatingSystem'];
  $devTool = $row['devTool'];
  $backEnd = $row['backEnd'];
  $numRecords = $row['numRecords'];
  $dbSecurity = $row['dbSecurity'];
  $source = $row ['source'];
  $withContract = $row ['withContract'];
  $dictmCertified = $row['dictmCertified'];
  $typeIS = $row['typeIS'];
  $statusIS = $row['statusIS'];
  $systemDoc = $row['systemDoc'];
  $userManual = $row['userManual'];
  $userAcceptance = $row['userAcceptance'];
  $remarks = $row ['remarks'];
  $preparedBy = $row['preparedBy'];
  $developedBy = $row['developedBy'];
  $developedByContact = $row['developedByContact'];
  $developedByEmail = $row['developedByEmail'];
  $dateInitiated = $row['dateInitiated'];
  $developmentDate = $row['developmentDate'];
  $turnOverDate = $row['turnOverDate'];
  $implementDate = $row['implementDate'];
  $cleansedDate = $row['cleansedDate'];
  $dateAdded = date('Y-d-m h:i:s a', strtotime($row['dateAdded']));
}


?>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->

