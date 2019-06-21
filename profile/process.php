<?php
ob_start();
require '../connection.php';

if(!isset($_SESSION)){ 
  session_start();
}


$edit = false;
$password = false;

$fname = '';
$mname = '';
$lname = '';
$email = '';
$username = '';
$password = '';
$authorityLevel = '';
$email = '';

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

$jr = '';
$sr = '';
$i = '';
$ii = '';
$iii = '';
$iv = '';
$v = '';

if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $edit = true;
  $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id = $id") or die($mysqli->error());

    $row = $result->fetch_array();
    $fname = $row['fname'];
    $mname = $row['mname'];
    $lname = $row['lname'];
    $qualifier = $row['qualifier'];
    
    $rank = $row['rank'];

    $email = $row ['email'];
    $username = $row['username'];
    $password = $row['password'];
    $authorityLevel = $row['authorityLevel'];


}

if(isset($_POST['save'])){
  $id = $_POST['id'];
  $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id = $id") or die($mysqli->error());
  $row = $result->fetch_array();
  $fname = ucwords(strtolower($_POST['fname']));
  $mname = ucwords(strtolower($_POST['mname']));
  $lname = ucwords(strtolower($_POST['lname']));
  $qualifier = ucfirst($_POST['qualifier']);
  $email = strtolower($_POST ['email']);

  $rank = $_POST['rank'];
  $username = str_replace(' ', '', strtolower($lname .'.'. $fname));

    $mysqli->query("UPDATE tblaccounts SET fname='$fname', mname='$mname', lname ='$lname', qualifier='$qualifier', rank='$rank', email = '$email', username='$username' WHERE id=$id") or die($mysqli->error());

    $_SESSION['message'] = "Record has been updated";
    $_SESSION['messageType'] = "success";

    header('Location: ../profile/');
}

if(isset($_GET['password'])){
  $id = $_GET['password'];
  $password = true;
}

if(isset($_POST['savePassword'])){
  $id = $_POST['id'];
  $currentPassword = md5($_POST['currentPassword']);
  $newPassword =  md5($_POST['newPassword']);
  $confirmPassword =  md5($_POST['confirmPassword']);

  $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id = $id") or die($mysqli->error());
  $row = $result->fetch_array();

  if($row['password'] == $currentPassword){
    if($newPassword != $confirmPassword){
      $_SESSION['message'] = "Password should be the same";
      $_SESSION['messageType'] = "danger";
  
      header("Location: ../profile/?password=$id");
      
    }
    else{
    $mysqli->query("UPDATE tblaccounts SET password='$newPassword' WHERE id=$id") or die($mysqli->error());

    $_SESSION['message'] = "Password has been changed";
    $_SESSION['messageType'] = "success";

    header('Location: ../profile/');
    }
  }
  else{
    $_SESSION['message'] = "Please enter correct current password";
    $_SESSION['messageType'] = "danger";

    header("Location: ../profile/?password=$id");
  }



}


?>