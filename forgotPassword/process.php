<?php
ob_start();
use PHPMailer\PHPMailer\PHPMailer;
require '../connection.php';

if(!isset($_SESSION)){ 
  session_start();
}

if(isset($_POST['send'])){
    date_default_timezone_set('Asia/Singapore');
    $dateNow = date("Y-m-d H:i:s"); 
    
    $email = $_POST['email'];
    $result = $mysqli->query("SELECT * FROM tblaccounts WHERE email = '$email' AND status != 'deactivated'") or die($mysqli->error());
    $row = $result->fetch_assoc();

    $tokenString = "abcdefghijklmnopqrstuvwxyz1234567890";
    $newToken = substr(str_shuffle($tokenString), 5 , 10);

    if(mysqli_num_rows($result) > 0){
        $mysqli->query("UPDATE tblaccounts SET token='$newToken', tokenExpiry=DATE_ADD('$dateNow', INTERVAL 5 MINUTE) WHERE email = '$email' AND status != 'deactivated'") or die($mysqli->error());
        
        require '../PHPMailer/PHPMailer.php';
        require '../PHPMailer/Exception.php';

        $mail = new PHPMailer();
        $mail->addAddress($email);
        $mail->setFrom("SMD@gmail.com", "CPI");
        $mail->Subject = "Reset Password";
        $mail->isHTML(true);
        $mail->Body = "Hi<br><br>
        
        <a href='systemmangementdivision.000webhostapp.com/changePassword/?email=$email&token=$newToken'>
        systemmangementdivision.000webhostapp.com/changePassword/?email=$email&token=$newToken
        </a><br><br>
        
        Thank you<br>
        SMD
        
        ";

        if($mail->send()){
            echo "Request has been sent to your email";
            header("location: ../login/");
        }
        else{
            echo "Request Failed", $mail->ErrorInfo;
        }
           
    }
    else{
        echo "Hacker to";
    }
}

?>