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

//INSERT DATA
if(isset($_POST['save'])){
  $name = ucwords($_POST['name']);
  $office = strtoupper($_POST['office']);
  $itOfficer = ucwords($_POST['itOfficer']);
  $itOfficerContact = $_POST['itOfficerContact'];
  $itOfficerEmail = $_POST['itOfficerEmail'];
  $description = ucfirst($_POST['description']);
  $environment = $_POST['environment'];
  $devTool = strtoupper($_POST['devTool']);
  $backEnd = strtoupper($_POST['backEnd']);
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
  $status = 'active';

  $targetDir = "../images/system logo/";
  $fileName = basename($_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
  $allowTypes = array('jpg','png','jpeg','gif','pdf');

  $pageSession = $_SESSION['page'];

  $result = $mysqli->query("SELECT * FROM tblsystems WHERE name = '$name'") or die($mysqli->error());
  $row = $result->fetch_assoc();
 

  if($row['name'] == $name){

    setcookie("name", $name);
    setcookie("office", $office);
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

    setcookie("devTool", $devTool);
    setcookie("backEnd", $backEnd);

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
    setcookie("preparedBy", $preparedBy);
    setcookie("developedBy", $developedBy);
    setcookie("developedByContact", $developedByContact);
    setcookie("developedByEmail", $developedByEmail);

    $_SESSION['errorMessage'] = "This IS already exist";
    $_SESSION['errorMessageType'] = "danger";

    header('Location: ../systems/');
  }
  else{
    if(!empty($_FILES["file"]["name"])){
      if(in_array($fileType, $allowTypes)){
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $mysqli->query("INSERT INTO tblsystems (logo, name, office, itOfficer, itOfficerContact, itOfficerEmail, description, environment, devTool, backEnd, source, withContract, dictmCertified, systemDoc, userManual, userAcceptance, typeIS, statusIS, remarks, preparedBy, developedBy,
            developedByContact, developedByEmail, dateInitiated, developmentDate, turnOverDate, implementDate, status,dateAdded)  VALUES ('".$fileName."', '$name', '$office', '$itOfficer', '$itOfficerContact', '$itOfficerEmail', '$description', '$environment', '$devTool', '$backEnd', '$source','$withContract', '$dictmCertified', '$systemDoc', '$userManual', '$userAcceptance', '$typeIS', '$statusIS', '$remarks', '$preparedBy', '$developedBy','$developedByContact', '$developedByEmail', '$dateInitiated', '$developmentDate', '$turnOverDate', '$implementDate', '$status', NOW())") or die($mysqli->error);

            $_SESSION['message'] = "Record has been saved";
            $_SESSION['messageType'] = "success";
            
            header("Location: ../systems/?page=$pageSession");
            
        }
      }
    }  
    else{
      $fileName = 'logo-itms.png';
      $mysqli->query("INSERT INTO tblsystems (logo, name, office, itOfficer, itOfficerContact, itOfficerEmail, description, environment, devTool, backEnd, source, withContract, dictmCertified, systemDoc, userManual, userAcceptance, typeIS, statusIS, remarks, preparedBy, developedBy,
      developedByContact, developedByEmail, dateInitiated, developmentDate, turnOverDate, implementDate, status,dateAdded)  VALUES ('$fileName', '$name', '$office', '$itOfficer', '$itOfficerContact', '$itOfficerEmail', '$description', '$environment', '$devTool', '$backEnd', '$source','$withContract', '$dictmCertified', '$systemDoc', '$userManual', '$userAcceptance', '$typeIS', '$statusIS', '$remarks', '$preparedBy', '$developedBy','$developedByContact', '$developedByEmail', '$dateInitiated', '$developmentDate', '$turnOverDate', '$implementDate', '$status', NOW())") or die($mysqli->error);

      $_SESSION['message'] = "Record has been saved";
      $_SESSION['messageType'] = "success";
      
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
  $id = $_POST['id'];
  $status = 'inactive';
  $pageSession = $_SESSION['page'];

  $mysqli->query("UPDATE tblsystems SET status = '$status' WHERE id = $id") or die($mysqli->error());

  $_SESSION['message'] = "System has been deleted";
  $_SESSION['messageType'] = "success";

  header("Location: ../systems/?page=$pageSession");
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
  $itOfficer = $row['itOfficer'];
  $itOfficerContact = $row['itOfficerContact'];
  $itOfficerEmail = $row['itOfficerEmail'];
  $description = $row['description'];
  $environment = $row['environment'];
  $devTool = $row['devTool'];
  $backEnd = $row['backEnd'];
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
  $dateAdded = $row['dateAdded'];
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

    $devTool = $row['devTool'];
    $backEnd = $row['backEnd'];
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
    if ($withContract == 'yes'){
      $yesContract = 'checked';
    }
    else if ($withContract == 'no'){
      $noContract = 'checked';
    }

    $dictmCertified = $row['dictmCertified'];
    if ($dictmCertified == 'yes'){
      $yesCertified = 'checked';
    }
    else if ($dictmCertified == 'no'){
      $noCertified = 'checked';
    }

    $typeIS = $row['typeIS'];
    if ($typeIS == 'Administrative'){
      $administrative = 'selected';
    }
    else if ($typeIS == 'Operations IS'){
      $operationsIS = 'selected';
    }
    else if ($typeIS == 'Support to Operations IS'){
      $supportOperationsIS = 'selected';
    }

    $statusIS = $row['statusIS'];
    if ($statusIS == 'Operational'){
      $operational = 'selected';
    }
    else if ($statusIS == 'Non-Operational'){
      $nonOperational = 'selected';
    }
    else if ($statusIS == 'For Development'){
      $forDevelopment = 'selected';
    } 
    else if ($statusIS == 'For Enhancement'){
      $forEnhancement = 'selected';
    } 

    $systemDoc = $row['systemDoc'];
    if ($systemDoc == 'yes'){
      $yesSystemDoc = 'checked';
    }

    $userManual = $row['userManual'];
    if ($userManual == 'yes'){
      $yesUserManual = 'checked';
    }

    $userAcceptance = $row['userAcceptance'];
    if ($userAcceptance == 'yes'){
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
    $status = $row['status'];
    $dateAdded = $row['dateAdded'];
}

//UPDATE DATA
if(isset($_POST['update'])){
  $id = $_POST['id'];
  $result = $mysqli->query("SELECT * FROM tblsystems WHERE id = $id") or die($mysqli->error());
  $row = $result->fetch_array();

  $name = ucwords($_POST['name']);
  $office = strtoupper($_POST['office']);
  $itOfficer = ucwords($_POST['itOfficer']);
  $itOfficerContact = $_POST['itOfficerContact'];
  $itOfficerEmail = $_POST['itOfficerEmail'];
  $description = ucfirst($_POST['description']);
  $environment = $_POST['environment'];
  $devTool = strtoupper($_POST['devTool']);
  $backEnd = strtoupper($_POST['backEnd']);
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

  $resultName = $mysqli->query("SELECT * FROM tblsystems WHERE name = '$name'") or die($mysqli->error());
  $rowName = $resultName->fetch_assoc();


  $targetDir = "../images/system logo/";
  $fileName = basename($_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
  $allowTypes = array('jpg','png','jpeg','gif','pdf');

  $pageSession = $_SESSION['page'];

  if($rowName['name'] == $name){
    if($row['name'] == $name){
      if(!empty($_FILES["file"]["name"])){
        if(in_array($fileType, $allowTypes)){
          if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            $mysqli->query("UPDATE tblsystems SET logo='".$fileName."', name='$name', office='$office', itOfficer ='$itOfficer', itOfficerContact = '$itOfficerContact', itOfficerEmail = '$itOfficerEmail', description='$description', environment='$environment', devTool='$devTool', backEnd='$backEnd', source='$source', withContract='$withContract', dictmCertified='$dictmCertified', systemDoc='$systemDoc', userManual='$userManual', userAcceptance='$userAcceptance', typeIS='$typeIS', statusIS='$statusIS', remarks='$remarks', preparedBy='$preparedBy', developedBy='$developedBy', developedByContact='$developedByContact', developedByEmail='$developedByEmail', dateInitiated='$dateInitiated', developmentDate='$developmentDate', turnOverDate='$turnOverDate', implementDate='$implementDate' WHERE id=$id") or die($mysqli->error());
                    
            $_SESSION['message'] = "Profile has been updated";
            $_SESSION['messageType'] = "success";

            header("Location: ../systems/?page=$pageSession");
          }
        }
      }
      else{
        $mysqli->query("UPDATE tblsystems SET name='$name', office='$office', itOfficer ='$itOfficer', itOfficerContact = '$itOfficerContact', itOfficerEmail = '$itOfficerEmail', description='$description', environment='$environment', devTool='$devTool', backEnd='$backEnd', source='$source', withContract='$withContract', dictmCertified='$dictmCertified', systemDoc='$systemDoc', userManual='$userManual', userAcceptance='$userAcceptance', typeIS='$typeIS', statusIS='$statusIS', remarks='$remarks', preparedBy='$preparedBy', developedBy='$developedBy', developedByContact='$developedByContact', developedByEmail='$developedByEmail', dateInitiated='$dateInitiated', developmentDate='$developmentDate', turnOverDate='$turnOverDate', implementDate='$implementDate' WHERE id=$id") or die($mysqli->error());
                    
        $_SESSION['message'] = "Profile has been updated";
        $_SESSION['messageType'] = "success";

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
            $mysqli->query("UPDATE tblsystems SET logo='".$fileName."', name='$name', office='$office', itOfficer ='$itOfficer', itOfficerContact = '$itOfficerContact', itOfficerEmail = '$itOfficerEmail', description='$description', environment='$environment', devTool='$devTool', backEnd='$backEnd', source='$source', withContract='$withContract', dictmCertified='$dictmCertified', systemDoc='$systemDoc', userManual='$userManual', userAcceptance='$userAcceptance', typeIS='$typeIS', statusIS='$statusIS', remarks='$remarks', preparedBy='$preparedBy', developedBy='$developedBy', developedByContact='$developedByContact', developedByEmail='$developedByEmail', dateInitiated='$dateInitiated', developmentDate='$developmentDate', turnOverDate='$turnOverDate', implementDate='$implementDate' WHERE id=$id") or die($mysqli->error());
                    
            $_SESSION['message'] = "Profile has been updated";
            $_SESSION['messageType'] = "success";

            header("Location: ../systems/?page=$pageSession");
          }
        }
      }
      else{
        $mysqli->query("UPDATE tblsystems SET name='$name', office='$office', itOfficer ='$itOfficer', itOfficerContact = '$itOfficerContact', itOfficerEmail = '$itOfficerEmail', description='$description', environment='$environment', devTool='$devTool', backEnd='$backEnd', source='$source', withContract='$withContract', dictmCertified='$dictmCertified', systemDoc='$systemDoc', userManual='$userManual', userAcceptance='$userAcceptance', typeIS='$typeIS', statusIS='$statusIS', remarks='$remarks', preparedBy='$preparedBy', developedBy='$developedBy', developedByContact='$developedByContact', developedByEmail='$developedByEmail', dateInitiated='$dateInitiated', developmentDate='$developmentDate', turnOverDate='$turnOverDate', implementDate='$implementDate' WHERE id=$id") or die($mysqli->error());
                    
        $_SESSION['message'] = "Profile has been updated";
        $_SESSION['messageType'] = "success";

        header("Location: ../systems/?page=$pageSession");
      }
  }


}

?>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->

