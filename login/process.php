<?php
ob_start();
require '../connection.php';

if(!isset($_SESSION)){ 
  session_start();
}

//LOGIN
if(isset($_POST['login'])){
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  if($username != '' || $password != ''){
    $result = $mysqli->query("SELECT * FROM tblaccounts WHERE username = '$username' AND password = '$password' AND status !='deactivated'") or die($mysqli->error());
    $row = $result->fetch_assoc();
  
    if($row['username'] == $username && $row['password'] == $password){
      $_SESSION['userId'] = $row['id'];
      $_SESSION['userName'] = $row['username'];
      $_SESSION['fname'] = $row['fname'];
      $_SESSION['mname'] = $row['mname'];
      $_SESSION['lname'] = $row['lname'];
      $_SESSION['authorityLevel'] = $row['authorityLevel'];
      $_SESSION['office'] = $row['office'];

      $userId = $_SESSION['userId'];

      date_default_timezone_set('Asia/Singapore');
      $dateNow = date("Y-m-d H:i:s"); 


      $mysqli->query("INSERT INTO tblloginhistory (userId, timeIn, timeOut)  VALUES ('$userId', '$dateNow', '0000-00-00 00:00:00')") or die($mysqli->error);

      $resultLogin = $mysqli->query("SELECT id, timeIn FROM tblloginhistory WHERE userId = '$userId' AND timeIn = '$dateNow' ORDER BY id DESC LIMIT 1") or die($mysqli->error());
      $rowLogin = $resultLogin->fetch_assoc();

      $_SESSION['current'] = $rowLogin['id'];
      $_SESSION['timeIn'] = $rowLogin['timeIn'];


      header('Location: ../dashboard/');
    }
    else{
     
        $_SESSION['message'] = "Incorrect Username and Password";
        $_SESSION['messageType'] = "danger";
      
        header('Location: ../login/');
    }
  }
}

?>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->