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
$appFunction = '';
$operatingSystem = '';
$devTool = '';
$backEnd = '';
$numRecords = '';
$dbSecurity = '';
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
$cleansedDate = '';
$status = '';
$dateAdded = '';

$update = false;
$delete = false;
$folder = false;
$documents = false;
$researchers = false;
$remove = false;
$unassign = false;
$view = false;
$activate = false;
$ranks = false;
$appFunctionality = false;
$error = false;
$add = false;
$id = 0;

$systemOffice = "";

$lanBased = '';
$webBased = '';
$cloudBased = '';
$others = '';

$payroll = '';
$dtr = '';
$inventory = '';
$docMan = '';

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

//INSERT DATA
if(isset($_POST['save'])){
  date_default_timezone_set('Asia/Singapore');
  $dateNow = date("Y-m-d H:i:s"); 
  $name = ucwords(rtrim(preg_replace('!\s+!', ' ', $_POST['name'])));
  $office = strtoupper($_POST['office']);
  $itOfficerRank = $_POST['rank'];
  $itOfficer = ucwords($_POST['itOfficer']);
  $itOfficerContact = $_POST['itOfficerContact'];
  $itOfficerEmail = $_POST['itOfficerEmail'];
  $description = ucfirst($_POST['description']);
  $environment = $_POST['environment'];
  $appFunction = $_POST['appFunction'];
  $operatingSystem = $_POST['operatingSystem'];
  $devTool = strtoupper($_POST['devTool']);
  $backEnd = strtoupper($_POST['backEnd']);
  $numRecords = $_POST['numRecords'];
  $dbSecurity = $_POST['dbSecurity'];
  $source = $_POST['source'];
  $withContract = $_POST['withContract'];
  $dictmCertified = $_POST['dictmCertified'];
  if(isset($_POST['systemDoc'])){
    $systemDoc = 'yes';
  }
  else{
    $systemDoc = 'no';
  }
  if(isset($_POST['userManual'])){
    $userManual = 'yes';
  }
  else{
    $userManual = 'no';
  }
  if(isset($_POST['userAcceptance'])){
    $userAcceptance = 'yes';
  }
  else{
    $userAcceptance = 'no';
  }
  $typeIS = $_POST['typeIS'];
  $statusIS = $_POST['statusIS'];
  $remarks = str_replace('  ', ' ', str_replace(',', ', ', ucfirst($_POST['remarks'])));
  $preparedBy = ucwords($_POST['preparedBy']);
  $developedBy = ucwords($_POST['developedBy']);
  $developedByContact = $_POST['developedByContact'];
  $developedByEmail = $_POST['developedByEmail'];
  $dateInitiated = $_POST['dateInitiated'];
  $developmentDate = $_POST['developmentDate'];
  $turnOverDate = $_POST['turnOverDate'];
  $implementDate = $_POST['implementDate'];
  $cleansedDate = $_POST['cleansedDate'];
  $status = 'active';

  $targetDir = "../images/system logo/";
  $fileName = basename($_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
  $allowTypes = array('jpg','png','jpeg','gif','pdf');

  $pageSession = $_SESSION['pageSystem'];

  $result = $mysqli->query("SELECT * FROM tblsystems WHERE status = 'active' AND name = '$name'") or die($mysqli->error());
  $row = $result->fetch_assoc();
 

  if($row['name'] == $name){

    setcookie("name", $name);
    setcookie("group", $group);
    setcookie("office", $office);
    setcookie("itOfficerRank", $itOfficerRank);
    setcookie("itOfficer", $itOfficer);
    setcookie("itOfficerContact", $itOfficerContact);
    setcookie("itOfficerEmail", $itOfficerEmail);
    setcookie("description", $description);

    if($environment =='LAN-Based'){
      setcookie("lanBased", 'selected');
    }
    else if($environment =='WEB-Based'){
      setcookie("webBased", 'selected');
    }
    else if($environment =='CLOUD-Based'){
      setcookie("cloudBased", 'selected');
    }
    else if($environment =='Others'){
      setcookie("others", 'selected');
    }

    if($appFunction =='Payroll'){
      setcookie("payroll", 'selected');
    }
    else if($appFunction =='DTR'){
      setcookie("dtr", 'selected');
    }
    else if($appFunction =='Inventory Management'){
      setcookie("inventory", 'selected');
    }
    else if($appFunction =='Document Management'){
      setcookie("docMan", 'selected');
    }

    setcookie("operatingSystem", $operatingSystem);
    setcookie("devTool", $devTool);
    setcookie("backEnd", $backEnd);
    setcookie("numRecords", $numRecords);
    setcookie("dbSecurity", $dbSecurity);

    if ($source == 'In-House (by ITMS)'){
      setcookie("inHouseITMS", 'selected');
    }
    else if ($source == 'In-House (c/o Unit)'){
      setcookie("inHouseUnit", 'selected');
    }
    else if ($source == 'Outsource'){
      setcookie("outsource", 'selected');
    }

    if($withContract == 'yes'){
      setcookie("yesContract", 'checked');
    }
    else if ($withContract == 'no'){
      setcookie("noContract", 'checked');
    }

    if($dictmCertified == 'yes'){
      setcookie("yesCertified", 'checked');
    }
    else if ($dictmCertified == 'no'){
      setcookie("noCertified", 'checked');
    }

    if ($typeIS == 'Administrative'){
      setcookie("administrative", 'selected');
    }
    else if ($typeIS == 'Operations IS'){
      setcookie("operationsIS", 'selected');
    }
    else if ($typeIS == 'Support to Operations IS'){
      setcookie("supportOperationsIS", 'selected');
    }

    if ($statusIS == 'Operational'){
      setcookie("operational", 'selected');
    }
    else if ($statusIS == 'Non-Operational'){
      setcookie("nonOperational", 'selected');
    }
    else if ($statusIS == 'For Development'){
      setcookie("forDevelopment", 'selected');
    } 
    else if ($statusIS == 'For Enhancement'){
      setcookie("forEnhancement", 'selected');
    } 

    if ($systemDoc == 'yes'){
      setcookie("yesSystemDoc", 'checked');
    }

    if ($userManual == 'yes'){
      setcookie("yesUserManual", 'checked');
    }

    if ($userAcceptance == 'yes'){
      setcookie("yesUserAcceptance", 'checked');
    }
  
    setcookie("remarks", $remarks);
    setcookie("developedBy", $developedBy);
    setcookie("developedByContact", $developedByContact);
    setcookie("developedByEmail", $developedByEmail);

    setcookie("dateInitiated", $dateInitiated);
    setcookie("developmentDate", $developmentDate);
    setcookie("turnOverDate", $turnOverDate);
    setcookie("implementDate", $implementDate);
    setcookie("cleansedDate", $cleansedDate);

    setcookie("preparedBy", $preparedBy);

    $_SESSION['errorMessage'] = "This IS already exist";
    $_SESSION['errorMessageType'] = "danger";

    header('Location: ../systems/');
  }
  else{
    if(!empty($_FILES["file"]["name"])){
      if(in_array($fileType, $allowTypes)){
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            $mysqli->query("INSERT INTO tblsystems (logo, name, office, itOfficerRank, itOfficer, itOfficerContact, itOfficerEmail, description, environment, appFunction, operatingSystem, devTool, backEnd, numRecords, dbSecurity, source, withContract, dictmCertified, systemDoc, userManual, userAcceptance, typeIS, statusIS, remarks, preparedBy, developedBy, developedByContact, developedByEmail, dateInitiated, developmentDate, turnOverDate, implementDate, cleansedDate, status, dateAdded)  VALUES ('".$fileName."', '$name', '$office', '$itOfficerRank', '$itOfficer', '$itOfficerContact', '$itOfficerEmail', '$description', '$environment', '$appFunction', '$operatingSystem', '$devTool', '$backEnd', '$numRecords', '$dbSecurity', '$source','$withContract', '$dictmCertified', '$systemDoc', '$userManual', '$userAcceptance', '$typeIS', '$statusIS', '$remarks', '$preparedBy', '$developedBy','$developedByContact', '$developedByEmail', '$dateInitiated', '$developmentDate', '$turnOverDate', '$implementDate', '$cleansedDate', '$status', '$dateNow')") or die($mysqli->error);

            $resultAdded = $mysqli->query("SELECT id FROM tblsystems ORDER BY id DESC LIMIT 1") or die($mysqli->error());
            $rowAdded = $resultAdded->fetch_assoc();

            $systemId = $rowAdded['id'];
            $userId = $_SESSION['userId'];
                
            $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$systemId', 'Added', '$dateNow')") or die($mysqli->error);

            $_SESSION['message'] = "Record has been saved";
            $_SESSION['messageType'] = "success";
            
            header("Location: ../systems/?page=$pageSession"); 
        }
      }
    }  
    else{
      $mysqli->query("INSERT INTO tblsystems (name, office, itOfficerRank, itOfficer, itOfficerContact, itOfficerEmail, description, environment, appFunction, operatingSystem, devTool, backEnd, numRecords, dbSecurity, source, withContract, dictmCertified, systemDoc, userManual, userAcceptance, typeIS, statusIS, remarks, preparedBy, developedBy, developedByContact, developedByEmail, dateInitiated, developmentDate, turnOverDate, implementDate, cleansedDate, status, dateAdded)  VALUES ('$name', '$office', '$itOfficerRank', '$itOfficer', '$itOfficerContact', '$itOfficerEmail', '$description', '$environment', '$appFunction', '$operatingSystem', '$devTool', '$backEnd', '$numRecords', '$dbSecurity', '$source','$withContract', '$dictmCertified', '$systemDoc', '$userManual', '$userAcceptance', '$typeIS', '$statusIS', '$remarks', '$preparedBy', '$developedBy','$developedByContact', '$developedByEmail', '$dateInitiated', '$developmentDate', '$turnOverDate', '$implementDate', '$cleansedDate', '$status', '$dateNow')") or die($mysqli->error);

      $resultAdded = $mysqli->query("SELECT id FROM tblsystems ORDER BY id DESC LIMIT 1") or die($mysqli->error());
      $rowAdded = $resultAdded->fetch_assoc();

      $systemId = $rowAdded['id'];
      $userId = $_SESSION['userId'];
          
      $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$systemId', 'Added', '$dateNow')") or die($mysqli->error);

      $_SESSION['message'] = "Record has been saved";
      $_SESSION['messageType'] = "success";
      
      header("Location: ../systems/?page=$pageSession");
    }
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

//GET ID EDIT
if(isset($_GET['edit'])){
  
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM tblsystems WHERE id = $id") or die($mysqli->error());

  $row = $result->fetch_array();
  $logo = $row['logo'];
  $name = $row['name'];

  $office = $row['office'];
  $itOfficerRank = $row['itOfficerRank'];
  $itOfficer = $row['itOfficer'];
  $itOfficerContact = $row['itOfficerContact'];
  $itOfficerEmail = $row['itOfficerEmail'];
  $description = $row['description'];

  $environment = $row['environment'];
  if($environment =='LAN-Based'){
    $lanBased = 'selected';
  }
  else if($environment =='WEB-Based'){
    $webBased = 'selected';
  }
  else if($environment =='CLOUD-Based'){
    $cloudBased = 'selected';
  }
  else if($environment =='Others'){
    $others = 'selected';
  }

  $appFunction = $row['appFunction'];
  if($appFunction == 'Payroll'){
    $payroll = 'selected';
  }
  else if($appFunction == 'DTR'){
    $dtr = 'selected';
  }
  else if($appFunction == 'Inventory Management'){
    $inventory = 'selected';
  }
  else if($appFunction == 'Document Management'){
    $docMan = 'selected';
  }

  $operatingSystem = $row['operatingSystem'];
  $devTool = $row['devTool'];
  $backEnd = $row['backEnd'];
  $numRecords = $row['numRecords'];
  $dbSecurity = $row['dbSecurity'];

  $source = $row ['source'];
  if ($source == 'In-House (by ITMS)'){
    $inHouseITMS = 'selected';
  }
  else if ($source == 'In-House (c/o Unit)'){
    $inHouseUnit = 'selected';
  }
  else if ($source == 'Outsource'){
    $outsource = 'selected';
  }

  $withContract = $row ['withContract'];
  if($withContract == 'yes'){
    $yesContract = 'checked';
  }
  else if($withContract == 'no'){
    $noContract = 'checked';
  }

  $dictmCertified = $row['dictmCertified'];
  if($dictmCertified == 'yes'){
    $yesCertified = 'checked';
  }
  else if($dictmCertified == 'no'){
    $noCertified = 'checked';
  }

  $typeIS = $row['typeIS'];
  if($typeIS == 'Administrative'){
    $administrative = 'selected';
  }
  else if($typeIS == 'Operations IS'){
    $operationsIS = 'selected';
  }
  else if($typeIS == 'Support to Operations IS'){
    $supportOperationsIS = 'selected';
  }

  $statusIS = $row['statusIS'];
  if($statusIS == 'Operational'){
    $operational = 'selected';
  }
  else if($statusIS == 'Non-Operational'){
    $nonOperational = 'selected';
  }
  else if($statusIS == 'For Development'){
    $forDevelopment = 'selected';
  } 
  else if ($statusIS == 'For Enhancement'){
    $forEnhancement = 'selected';
  } 

  $systemDoc = $row['systemDoc'];
  if($systemDoc == 'yes'){
    $yesSystemDoc = 'checked';
  }

  $userManual = $row['userManual'];
  if($userManual == 'yes'){
    $yesUserManual = 'checked';
  }

  $userAcceptance = $row['userAcceptance'];
  if($userAcceptance == 'yes'){
    $yesUserAcceptance = 'checked';
  }
  

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
  $status = $row['status'];
  $dateAdded = $row['dateAdded'];

}

//UPDATE DATA
if(isset($_POST['update'])){
  date_default_timezone_set('Asia/Singapore');
  $dateNow = date("Y-m-d H:i:s"); 

  $id = $_POST['id'];
  $result = $mysqli->query("SELECT * FROM tblsystems WHERE id = $id") or die($mysqli->error());
  $row = $result->fetch_array();

  $name = ucwords(rtrim(preg_replace('!\s+!', ' ', $_POST['name'])));
  $office = strtoupper($_POST['office']);
  $itOfficerRank = $_POST['rank'];
  $itOfficer = ucwords($_POST['itOfficer']);
  $itOfficerContact = $_POST['itOfficerContact'];
  $itOfficerEmail = $_POST['itOfficerEmail'];
  $description = ucfirst($_POST['description']);
  $environment = $_POST['environment'];
  $appFunction = $_POST['appFunction'];
  $operatingSystem = $_POST['operatingSystem'];
  $devTool = strtoupper($_POST['devTool']);
  $backEnd = strtoupper($_POST['backEnd']);
  $numRecords = $_POST['numRecords'];
  $dbSecurity = $_POST['dbSecurity'];
  $source = $_POST['source'];
  $withContract = $_POST['withContract'];
  $dictmCertified = $_POST['dictmCertified'];
  if(isset($_POST['systemDoc'])){
    $systemDoc = 'yes';
  }
  else{
    $systemDoc = 'no';
  }
  if(isset($_POST['userManual'])){
    $userManual = 'yes';
  }
  else{
    $userManual = 'no';
  }
  if(isset($_POST['userAcceptance'])){
    $userAcceptance = 'yes';
  }
  else{
    $userAcceptance = 'no';
  }
  $typeIS = $_POST['typeIS'];
  $statusIS = $_POST['statusIS'];
  $remarks = str_replace('  ', ' ', str_replace(',', ', ', ucfirst($_POST['remarks'])));
  $preparedBy = ucwords($_POST['preparedBy']);
  $developedBy = ucwords($_POST['developedBy']);
  $developedByContact = $_POST['developedByContact'];
  $developedByEmail = $_POST['developedByEmail'];
  $dateInitiated = $_POST['dateInitiated'];
  $developmentDate = $_POST['developmentDate'];
  $turnOverDate = $_POST['turnOverDate'];
  $implementDate = $_POST['implementDate'];
  $cleansedDate = $_POST['cleansedDate'];

  $resultName = $mysqli->query("SELECT * FROM tblsystems WHERE status = 'active' AND name = '$name'") or die($mysqli->error());
  $rowName = $resultName->fetch_assoc();


  $targetDir = "../images/system logo/";
  $fileName = basename($_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
  $allowTypes = array('jpg','png','jpeg','gif','pdf');

  $pageSession = $_SESSION['pageSystem'];

  if($rowName['name'] == $name){
    if($row['name'] == $name){
      if(!empty($_FILES["file"]["name"])){
        if(in_array($fileType, $allowTypes)){
          if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            if($office != $row['office']){
              $mysqli->query("DELETE FROM tblresearchers WHERE systemId = '$id'") or die($mysqli->error());
            }

            $mysqli->query("UPDATE tblsystems SET logo='".$fileName."', name='$name', office='$office', itOfficerRank ='$itOfficerRank', itOfficer ='$itOfficer', itOfficerContact = '$itOfficerContact', itOfficerEmail = '$itOfficerEmail', description='$description', environment='$environment', appFunction='$appFunction', operatingSystem='$operatingSystem', devTool='$devTool', backEnd='$backEnd', numRecords='$numRecords', dbSecurity='$dbSecurity', source='$source', withContract='$withContract', dictmCertified='$dictmCertified', systemDoc='$systemDoc', userManual='$userManual', userAcceptance='$userAcceptance', typeIS='$typeIS', statusIS='$statusIS', remarks='$remarks', preparedBy='$preparedBy', developedBy='$developedBy', developedByContact='$developedByContact', developedByEmail='$developedByEmail', dateInitiated='$dateInitiated', developmentDate='$developmentDate', turnOverDate='$turnOverDate', implementDate='$implementDate', cleansedDate='$cleansedDate' WHERE id=$id") or die($mysqli->error());
                      
            $_SESSION['message'] = "System has been updated";
            $_SESSION['messageType'] = "success";
  
            $userId = $_SESSION['userId'];
      
            $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);
  
            header("Location: ../systems/?page=$pageSession");      
          }
        }
      }
      else{
        if($office != $row['office']){
          $mysqli->query("DELETE FROM tblresearchers WHERE systemId = '$id'") or die($mysqli->error());
        }

        $mysqli->query("UPDATE tblsystems SET name='$name', office='$office', itOfficerRank ='$itOfficerRank', itOfficer ='$itOfficer', itOfficerContact = '$itOfficerContact', itOfficerEmail = '$itOfficerEmail', description='$description', environment='$environment', appFunction='$appFunction', operatingSystem='$operatingSystem', devTool='$devTool', backEnd='$backEnd', numRecords='$numRecords', dbSecurity='$dbSecurity', source='$source', withContract='$withContract', dictmCertified='$dictmCertified', systemDoc='$systemDoc', userManual='$userManual', userAcceptance='$userAcceptance', typeIS='$typeIS', statusIS='$statusIS', remarks='$remarks', preparedBy='$preparedBy', developedBy='$developedBy', developedByContact='$developedByContact', developedByEmail='$developedByEmail', dateInitiated='$dateInitiated', developmentDate='$developmentDate', turnOverDate='$turnOverDate', implementDate='$implementDate', cleansedDate='$cleansedDate' WHERE id=$id") or die($mysqli->error());
  
        $_SESSION['message'] = "System has been updated";
        $_SESSION['messageType'] = "success";
  
        $userId = $_SESSION['userId'];
      
        $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);
  
        header("Location: ../systems/?page=$pageSession");
      }
    }
    else{
      $_SESSION['errorMessage'] = "This IS already exist";
      $_SESSION['errorMessageType'] = "danger";
  
      header("Location: ../systems/?edit=$id");
    }
  }
  else{
    if(!empty($_FILES["file"]["name"])){
      if(in_array($fileType, $allowTypes)){
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
          if($office != $row['office']){
            $mysqli->query("DELETE FROM tblresearchers WHERE systemId = '$id'") or die($mysqli->error());
          }

          $mysqli->query("UPDATE tblsystems SET logo='".$fileName."', name='$name', office='$office', itOfficerRank ='$itOfficerRank', itOfficer ='$itOfficer', itOfficerContact = '$itOfficerContact', itOfficerEmail = '$itOfficerEmail', description='$description', environment='$environment', appFunction='$appFunction', operatingSystem='$operatingSystem', devTool='$devTool', backEnd='$backEnd', numRecords='$numRecords', dbSecurity='$dbSecurity', source='$source', withContract='$withContract', dictmCertified='$dictmCertified', systemDoc='$systemDoc', userManual='$userManual', userAcceptance='$userAcceptance', typeIS='$typeIS', statusIS='$statusIS', remarks='$remarks', preparedBy='$preparedBy', developedBy='$developedBy', developedByContact='$developedByContact', developedByEmail='$developedByEmail', dateInitiated='$dateInitiated', developmentDate='$developmentDate', turnOverDate='$turnOverDate', implementDate='$implementDate', cleansedDate='$cleansedDate' WHERE id=$id") or die($mysqli->error());
  
          $_SESSION['message'] = "System has been updated";
          $_SESSION['messageType'] = "success";
  
          $userId = $_SESSION['userId'];
      
          $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);
  
          header("Location: ../systems/?page=$pageSession");
        }
      }
    }
    else{
      if($office != $row['office']){
        $mysqli->query("DELETE FROM tblresearchers WHERE systemId = '$id'") or die($mysqli->error());
      }
      
      $mysqli->query("UPDATE tblsystems SET name='$name', office='$office', itOfficer ='$itOfficer', itOfficerRank ='$itOfficerRank', itOfficerContact = '$itOfficerContact', itOfficerEmail = '$itOfficerEmail', description='$description', environment='$environment', appFunction='$appFunction', operatingSystem='$operatingSystem', devTool='$devTool', backEnd='$backEnd', numRecords='$numRecords', dbSecurity='$dbSecurity', source='$source', withContract='$withContract', dictmCertified='$dictmCertified', systemDoc='$systemDoc', userManual='$userManual', userAcceptance='$userAcceptance', typeIS='$typeIS', statusIS='$statusIS', remarks='$remarks', preparedBy='$preparedBy', developedBy='$developedBy', developedByContact='$developedByContact', developedByEmail='$developedByEmail', dateInitiated='$dateInitiated', developmentDate='$developmentDate', turnOverDate='$turnOverDate', implementDate='$implementDate', cleansedDate='$cleansedDate' WHERE id=$id") or die($mysqli->error());

      $_SESSION['message'] = "System has been updated";
      $_SESSION['messageType'] = "success";

      $userId = $_SESSION['userId'];
      
      $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);

      header("Location: ../systems/?page=$pageSession");
    }
  }
}

//GET ID TO DELETE
if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $delete = true;
}

if(isset($_POST['btnYes'])){
  date_default_timezone_set('Asia/Singapore');
  $dateNow = date("Y-m-d H:i:s"); 
  $id = $_POST['id'];
  $status = 'inactive';
  $pageSession = $_SESSION['pageSystem'];

  $mysqli->query("UPDATE tblsystems SET status = '$status' WHERE id = $id") or die($mysqli->error());

  $userId = $_SESSION['userId'];
    
  $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$id', 'Deleted', '$dateNow')") or die($mysqli->error);

  $_SESSION['message'] = "System has been deleted";
  $_SESSION['messageType'] = "success";

  header("Location: ../systems/?page=$pageSession");
}

//VIEW APP FUNCTION
if(isset($_GET['appFunction'])){
  $id = $_GET['appFunction'];
  $appFunctionality = true;
}


//UPDATE APP FUNCTION
if(isset($_POST['updateAppFunction'])){
  $systemIdAppFunction = $_POST['systemIdAppFunction'];
  $resultAppFunctions = $mysqli->query("SELECT * FROM tblappfunction") or die($mysqli->error());

  $divAppFunctionCount = $_POST['inputAppFunctionCount'];
  
  for($i = 1; $i<=$divAppFunctionCount; $i++){
    $newAppFunction =  $_POST['newAppFunction'. $i];

    if ($newAppFunction != ""){
      $resultAppFunctionCheck = $mysqli->query("SELECT * FROM tblappfunction WHERE appFunctionality = '$newAppFunction'") or die($mysqli->error());
      $rowAppFunctionCheck = $resultAppFunctionCheck->fetch_assoc();

      if(count($rowAppFunctionCheck) == 0){
        $mysqli->query("INSERT INTO tblappfunction (appFunctionality) VALUES ('$newAppFunction')") or die($mysqli->error());
      }
      else{

      }
    }  
  }

  $divExistingAppFunctionCount = $_POST['existingAppFunctionCount'];

  for($i = 1; $i<=$divExistingAppFunctionCount; $i++){
    $existingAppFunctionId =  $_POST['existingAppFunctionId'. $i];
    echo $existingAppFunction =  $_POST['existingAppFunction'. $i];

    $mysqli->query("UPDATE tblappfunction SET appFunctionality = '$existingAppFunction' WHERE id = $existingAppFunctionId") or die($mysqli->error());
  }

  $_SESSION['appFunctionMessage'] = "Application Functionality has been modified";
  $_SESSION['appFunctionMessageType'] = "success";
  header("Location: ../systems/?appFunction=$systemIdAppFunction");
}



//VIEW RANKS
if(isset($_GET['ranks'])){
  $id = $_GET['ranks'];
  $ranks = true;
}

//UPDATE RANKS
if(isset($_POST['updateRank'])){
  $systemIdRank = $_POST['systemIdRank'];
  $resultRanks = $mysqli->query("SELECT * FROM tblranks") or die($mysqli->error());

  $divRankCount = $_POST['inputRankCount'];
  
  for($i = 1; $i<=$divRankCount; $i++){
    $newRank =  $_POST['newRank'. $i];

    if ($newRank != ""){
      $resultRankCheck = $mysqli->query("SELECT * FROM tblranks WHERE rank = '$newRank'") or die($mysqli->error());
      $rowRankCheck = $resultRankCheck->fetch_assoc();

      if(count($rowRankCheck) == 0){
        $mysqli->query("INSERT INTO tblranks (rank) VALUES ('$newRank')") or die($mysqli->error());
      }
      else{

      }
    }  
  }

  $divExistingRankCount = $_POST['existingRankCount'];

  for($i = 1; $i<=$divExistingRankCount; $i++){
    $existingRankId =  $_POST['existingRankId'. $i];
    $existingRank =  $_POST['existingRank'. $i];

    $mysqli->query("UPDATE tblranks SET rank = '$existingRank' WHERE id = $existingRankId") or die($mysqli->error());
  }

  // while($rowRanks = $resultRanks->fetch_assoc()){
  //   $tblRankId = $rowRanks['id'];
  //   $tblRank = str_replace(' ', '', $rowRanks['rank']);
  //   $rankId = $_POST[$tblRankId];
  //   $rank = $_POST[$tblRank];
  //   $mysqli->query("UPDATE tblranks SET rank = '$rank' WHERE id = $rankId") or die($mysqli->error());
  // }

  $_SESSION['rankMessage'] = "Rank has been modified";
  $_SESSION['rankMessageType'] = "success";
  header("Location: ../systems/?ranks=$systemIdRank");
}

//VIEW RESEARCHERS
if(isset($_GET['researchers'])){
  $id = $_GET['researchers'];
  $systemOffice = $_GET['office'];
  $researchers = true;
}

//UPDATE RESEARCHER
if(isset($_POST['updateResearcher'])){
  $systemId = $_POST['systemId'];
  $systemOffice = $_POST['systemOffice'];
  $inputResearcherCount = $_POST['inputResearcherCount'];
  
  for($i = 1; $i<=$inputResearcherCount; $i++){
    $newResearcher =  $_POST['newResearcher'. $i];
    if ($newResearcher != ""){
      $resultResearchers = $mysqli->query("SELECT * FROM tblresearchers WHERE systemId = '$systemId' AND accountId = '$newResearcher'") or die($mysqli->error());
      $rowResearchers = $resultResearchers->fetch_assoc();

      if(count($rowResearchers) == 0){
        $mysqli->query("INSERT INTO tblresearchers (accountId, systemId) VALUES ('$newResearcher', '$systemId')") or die($mysqli->error());
        
        $_SESSION['researcherMessage'] = "Researcher has been assigned";
        $_SESSION['researcherMessageType'] = "success";
        header("Location: ../systems/?researchers=$systemId&office=$systemOffice");
      }
      else{
        header("Location: ../systems/?researchers=$systemId&office=$systemOffice");
      }
    }
    else{
      header("Location: ../systems/?researchers=$systemId&office=$systemOffice");
    }
  }

  header("Location: ../systems/?researchers=$systemId&office=$systemOffice");
}

//GET RESEARCHER ID TO REMMOVE
if(isset($_GET['unassign'])){
  $id = $_GET['unassign'];
  $systemOffice = $_GET['office'];
  $systemIdResearcher = $_GET['unassignResearcher'];
  $unassign = true;
}

if(isset($_POST['btnYesUnassign'])){
  $id = $_POST['id'];
  $systemIdResearcher = $_POST['systemIdResearcher'];
  $systemOffice =$_POST['systemOffice'];
  $mysqli->query("DELETE FROM tblresearchers WHERE id = $id") or die($mysqli->error());

  $userId = $_SESSION['userId'];

  $_SESSION['unassignMessage'] = "Researcher has been unassigned";
  $_SESSION['unassignMessageType'] = "success";

  header("Location: ../systems/?researchers=$systemIdResearcher&office=$systemOffice");
}

//VIEW FOLDERS
if(isset($_GET['folder'])){
  $id = $_GET['folder'];
  $folder = true;
}

//VIEW DOCUMENT
if(isset($_GET['documents'])){
  $id = $_GET['documents'];
  $folder = $_GET['folder'];
  $documents = true;
}

//UPDATE DOCUMENT
if(isset($_POST['updateFolder'])){
  date_default_timezone_set('Asia/Singapore');
  $dateNow = date("Y-m-d H:i:s"); 

  $id = $_POST['systemId'];
  $folder = $_POST['folder'];

  $result = $mysqli->query("SELECT * FROM tblsystems WHERE id = $id") or die($mysqli->error());
  $row = $result->fetch_assoc();
  $systemName =  $row['id'];

  $targetDir1 = "../images/system documents/";
  $allowTypes1 = array('jpg','png','jpeg','gif');
      
  $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    
  if(!empty(array_filter($_FILES['fileDocuments']['name']))){
    foreach($_FILES['fileDocuments']['name'] as $key=>$val){
      
     
      $fileName1 = strtolower(basename($_FILES['fileDocuments']['name'][$key]));
      $fileName1 = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-' . $systemName), $fileName1);
      $name_only = pathinfo($fileName1, PATHINFO_FILENAME);
      $extension_only = pathinfo($fileName1, PATHINFO_EXTENSION);

      $count = 1;
      while (file_exists($targetDir1 . $fileName1)){
        $fileName1 = (string)$name_only . ' (' . $count . ')' . '.' . $extension_only;
        $count++;
      }
     
      $targetFilePath1 = $targetDir1 . $fileName1;
      $fileType1 = pathinfo($targetFilePath1,PATHINFO_EXTENSION);
        if(in_array($fileType1, $allowTypes1)){
          if(move_uploaded_file($_FILES["fileDocuments"]["tmp_name"][$key], $targetFilePath1)){
            $insertValuesSQL .= "('$id', '".$fileName1."', '$folder', '$dateNow'),";
          }
        }
        else{
          $errorUploadType .= $_FILES['fileDocuments']['name'][$key].', ';
        }
    }

    $insertValuesSQL = trim($insertValuesSQL,',');
    $mysqli->query("INSERT INTO tbldocuments (systemId, filename, folder, uploaded_on) VALUES $insertValuesSQL") or die($mysqli->error);

    $_SESSION['documentMessage'] = "Document has been updated";
    $_SESSION['documentMessageType'] = "success";

    $userId = $_SESSION['userId'];

    $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);

    header("Location: ../systems/?documents=$id&folder=$folder");
  }
  else{
    
    $_SESSION['documentMessage'] = "There is no selected file";
    $_SESSION['documentMessageType'] = "danger";

    header("Location: ../systems/?documents=$id&folder=$folder");

  }

}

if(isset($_GET['add'])){
  $add = true;
}

//GET DOCUMENT ID TO REMMOVE
if(isset($_GET['remove'])){
  $id = $_GET['remove'];
  $documents = $_GET['removeDocuments'];
  $folder = $_GET['removeFolder'];
  $remove = true;
}

if(isset($_POST['btnYesRemove'])){
  date_default_timezone_set('Asia/Singapore');
  $dateNow = date("Y-m-d H:i:s"); 
  
  $id = $_POST['id'];
  $documents = $_POST['documents'];
  $folder = $_POST['folder'];

  $resultDocument = $mysqli->query("SELECT * FROM tbldocuments WHERE id = $id") or die($mysqli->error());
  $rowDocument = $resultDocument->fetch_assoc();

  $systemId = $rowDocument['systemId'];

  $mysqli->query("DELETE FROM tbldocuments WHERE id = $id") or die($mysqli->error());

  $userId = $_SESSION['userId'];
    
  $mysqli->query("INSERT INTO tblsystemtrail (userId, systemId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);

  $_SESSION['removeMessage'] = "Document has been removed";
  $_SESSION['removeMessageType'] = "success";

  header("Location: ../systems/?documents=$documents&folder=$folder");
}


?>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->

