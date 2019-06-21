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
$ranks = false;
$error = false;
$add = false;
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


//INSERT DATA
if(isset($_POST['save'])){
  date_default_timezone_set('Asia/Singapore');
  $dateNow = date("Y-m-d H:i:s"); 

  $fname = ucwords(strtolower($_POST['fname']));
  $mname = ucwords(strtolower($_POST['mname']));
  $lname = ucwords(strtolower($_POST['lname']));
  $qualifier = $_POST['qualifier'];
  $office = $_POST['office'];
  $rank = $_POST['rank'];
  $email = strtolower($_POST['email']);
  $username = $_POST['username'];
  $password =  md5($_POST['password']);
  $authorityLevel = strtolower($_POST['authorityLevel']);
  $status = 'activated';

  $pageSession = $_SESSION['pageAccount'];

  $result = $mysqli->query("SELECT * FROM tblaccounts WHERE status = 'activated' AND (username = '$username' OR email = '$email')") or die($mysqli->error());
  $row = $result->fetch_assoc();
  

  if($row['username'] == $username){
    setcookie("fname", $fname);
    setcookie("mname", $mname);
    setcookie("lname", $lname);
    setcookie("qualifier", $qualifier);
    setcookie("rank", $rank);
    setcookie("office", $office);


    if($authorityLevel == 'admin'){
      setcookie("admin", 'selected');
    }
    else if($authorityLevel == 'user'){
      setcookie("user", 'selected');
    }
    else if($authorityLevel == 'researcher'){
      setcookie("researcher", 'selected');
    }

    setcookie("email", $email);
    setcookie("username", $username);
    setcookie("password", $_POST['password']);


    $_SESSION['errorMessage'] = "This user already exist";
    $_SESSION['errorMessageType'] = "danger";

    header('Location: ../accounts/');
  }
  else if($row['email'] == $email){
    setcookie("fname", $fname);
    setcookie("mname", $mname);
    setcookie("lname", $lname);
    setcookie("qualifier", $qualifier);
    setcookie("rank", $rank);
    setcookie("office", $office);

    if($authorityLevel == 'admin'){
      setcookie("admin", 'selected');
    }
    else if($authorityLevel == 'user'){
      setcookie("user", 'selected');
    }
    else if($authorityLevel == 'researcher'){
      setcookie("researcher", 'selected');
    }

    setcookie("email", $email);
    setcookie("username", $username);
    setcookie("password", $_POST['password']);


    $_SESSION['errorMessage'] = "This email is already asssociated with another account";
    $_SESSION['errorMessageType'] = "danger";

    header('Location: ../accounts/');
  }
  else{
   if($fname != '' && $lname != '' && $rank != '' && $username != '' && $password != '' && $authorityLevel != '' && $email !=''){
      $mysqli->query("INSERT INTO tblaccounts (fname, mname, lname, qualifier, rank, office, email, username, password, authorityLevel, status, dateAdded)  VALUES ('$fname', '$mname', '$lname', '$qualifier', '$rank', '$office', '$email', '$username', '$password', '$authorityLevel', '$status', '$dateNow')") or die($mysqli->error);

      $resultAdded = $mysqli->query("SELECT id FROM tblaccounts ORDER BY id DESC LIMIT 1") or die($mysqli->error());
      $rowAdded = $resultAdded->fetch_assoc();

      $accountId = $rowAdded['id'];
      $userId = $_SESSION['userId'];
          
      $mysqli->query("INSERT INTO tblaccounttrail (userId, accountId, action, dateModified)  VALUES ('$userId', '$accountId', 'Added', '$dateNow')") or die($mysqli->error);

      $_SESSION['message'] = "Record has been saved";
      $_SESSION['messageType'] = "success";
    
      header("Location: ../accounts/?page=$pageSession");
    }
  }
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
      $mysqli->query("INSERT INTO tblranks (rank) VALUES ('$newRank')") or die($mysqli->error());
    }
    
  }

  while($rowRanks = $resultRanks->fetch_assoc()){
    $tblRankId = $rowRanks['id'];
    $tblRank = str_replace(' ', '', $rowRanks['rank']);
    $rankId = $_POST[$tblRankId];
    $rank = $_POST[$tblRank];
    $mysqli->query("UPDATE tblranks SET rank = '$rank' WHERE id = $rankId") or die($mysqli->error());
  }
  
  $_SESSION['rankMessage'] = "Rank has been added";
  $_SESSION['rankMessageType'] = "success";
  header("Location: ../accounts/?ranks=$systemIdRank");
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
  $status = 'deactivated';
  $pageSession = $_SESSION['pageAccount'];

  $mysqli->query("UPDATE tblaccounts SET status = '$status' WHERE id = $id") or die($mysqli->error());

  $_SESSION['message'] = "Account has been deactivated";
  $_SESSION['messageType'] = "success";

  $userId = $_SESSION['userId'];
          
  $mysqli->query("INSERT INTO tblaccounttrail (userId, accountId, action, dateModified)  VALUES ('$userId', '$id', 'Deactivated', '$dateNow')") or die($mysqli->error);

  header("Location: ../accounts/?page=$pageSession");
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
    $office = $row['office'];
    $resultRank = $mysqli->query("SELECT * FROM tblranks WHERE id = $rank") or die($mysqli->error());
    $rowRank = $resultRank->fetch_array();

    $rank = $rowRank['rank'];

    $email = $row ['email'];
    $username = $row['username'];
    $password = $row['password'];
    $authorityLevel = ucwords($row['authorityLevel']);
    $dateAdded = date('Y-d-m h:i:s a', strtotime($row['dateAdded']));
}


//GET ID EDIT
if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id = $id") or die($mysqli->error());

    $row = $result->fetch_array();
    $fname = $row['fname'];
    $mname = $row['mname'];
    $lname = $row['lname'];
    $status = $row['status'];
    $qualifier = $row['qualifier'];
    $rank = $row['rank'];
    $office = $row['office'];
    $email = $row ['email'];
    $username = $row['username'];
    $password = $row['password'];
    
    $authorityLevel = $row['authorityLevel'];
    if($authorityLevel == 'admin'){
      $admin = 'selected';
    }
    else if($authorityLevel == 'researcher'){
      $researcher = 'selected';
    }
    else if($authorityLevel == 'user'){
      $user = 'selected';
    }
}

//UPDATE DATA
if(isset($_POST['update'])){
  date_default_timezone_set('Asia/Singapore');
  $dateNow = date("Y-m-d H:i:s"); 
  
  $id = $_POST['id'];
  $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id = $id") or die($mysqli->error());
  $row = $result->fetch_array();
  $fname = ucwords(strtolower($_POST['fname']));
  $mname = ucwords(strtolower($_POST['mname']));
  $lname = ucwords(strtolower($_POST['lname']));
  $qualifier = $_POST['qualifier'];
  $email = strtolower($_POST ['email']);

  $rank = $_POST['rank'];
  $office = $_POST['office'];
  $username = str_replace(' ', '', strtolower($lname .'.'. $fname));
  if($row['password'] == $_POST['password']){
    $password = ($_POST['password']);
  }
  else{
    $password = md5($_POST['password']);
  }
  $authorityLevel = strtolower($_POST['authorityLevel']);

  $resultUsername = $mysqli->query("SELECT * FROM tblaccounts WHERE status = 'activated' AND username = '$username'") or die($mysqli->error());
  $rowUsername = $resultUsername->fetch_assoc();

  $resultEmail = $mysqli->query("SELECT * FROM tblaccounts WHERE status = 'activated' AND email = '$email'") or die($mysqli->error());
  $rowEmail = $resultEmail->fetch_assoc();

  $pageSession = $_SESSION['pageAccount'];

  
  if($rowEmail['email'] == $email){
    if($row['email'] == $email){
      if($rowUsername['username'] == $username){
        if($row['username'] == $username){
          $mysqli->query("UPDATE tblaccounts SET fname='$fname', mname='$mname', lname ='$lname', qualifier='$qualifier', rank='$rank', office='$office', email = '$email', username='$username', password='$password', authorityLevel = '$authorityLevel' WHERE id=$id") or die($mysqli->error());
            
          $_SESSION['message'] = "Profile has been updated";
          $_SESSION['messageType'] = "success";

          $userId = $_SESSION['userId'];
          
          $mysqli->query("INSERT INTO tblaccounttrail (userId, accountId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);
      
          header("Location: ../accounts/?page=$pageSession");
        }
        else{
          $_SESSION['errorMessage'] = "This user already exist";
          $_SESSION['errorMessageType'] = "danger";
      
          header("Location: ../accounts/?edit=$id");
        }
      }
      else{
        $mysqli->query("UPDATE tblaccounts SET fname='$fname', mname='$mname', lname ='$lname', qualifier='$qualifier', rank='$rank', office='$office', email = '$email', username='$username', password='$password' WHERE id=$id") or die($mysqli->error());
            
        $_SESSION['message'] = "Profile has been updated";
        $_SESSION['messageType'] = "success";

        $userId = $_SESSION['userId'];
          
        $mysqli->query("INSERT INTO tblaccounttrail (userId, accountId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);
      
        header("Location: ../accounts/?page=$pageSession");
      }
    }
    else{
      $_SESSION['errorMessage'] = "This email is already associated with another account";
      $_SESSION['errorMessageType'] = "danger";

      header("Location: ../accounts/?edit=$id");
    }
  }
  else{
    if($rowUsername['username'] == $username){
      if($row['username'] == $username){
        $mysqli->query("UPDATE tblaccounts SET fname='$fname', mname='$mname', lname ='$lname', qualifier='$qualifier', rank='$rank', office='$office', email = '$email', username='$username', password='$password' WHERE id=$id") or die($mysqli->error());
          
        $_SESSION['message'] = "Profile has been updated";
        $_SESSION['messageType'] = "success";

        $userId = $_SESSION['userId'];
          
        $mysqli->query("INSERT INTO tblaccounttrail (userId, accountId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);
    
        header("Location: ../accounts/?page=$pageSession");
      }
      else{
        $_SESSION['errorMessage'] = "This user already exist";
        $_SESSION['errorMessageType'] = "danger";
    
        header("Location: ../accounts/?edit=$id");
      }
    }
    else{
      $mysqli->query("UPDATE tblaccounts SET fname='$fname', mname='$mname', lname ='$lname', qualifier='$qualifier', rank='$rank', office='$office', email = '$email', username='$username', password='$password' WHERE id=$id") or die($mysqli->error());
          
      $_SESSION['message'] = "Profile has been updated";
      $_SESSION['messageType'] = "success";

      $userId = $_SESSION['userId'];
          
      $mysqli->query("INSERT INTO tblaccounttrail (userId, accountId, action, dateModified)  VALUES ('$userId', '$id', 'Edited', '$dateNow')") or die($mysqli->error);
    
      header("Location: ../accounts/?page=$pageSession");
    }
  }
}

if(isset($_GET['add'])){
  $add = true;
}

?>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->

