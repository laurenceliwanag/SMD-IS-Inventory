<?php
session_start();
if(isset($_SESSION['userId'])){
    header('Location: ../dashboard/');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

        <link rel="stylesheet" type="text/css" href="../style.css">
        <link rel="icon" href="../images/logo-itms.png">
        <title>System Management Division</title>
        <style>
        body{
            background-image: linear-gradient(#007bff, #5bc0de);
        }
        </style>
    </head>
    <body onload="loading()">
        <?php require_once 'process.php' ?>
        
        <div class="loader" id="loader"></div>
        
        <div class="container">
            <form action="process.php" method="POST">
                <div class="contentLogin">
                    <div class="row" id="formLogin">          
                        <div class="col">
                            <div class="row">
                                <img src="../images/logo-itms.png" id="logo">
                            </div>
                            <div class="row">
                                <div class="col" id="loginAlert">
                                    <?php if(isset($_SESSION['message'])): ?>
                                    <div class="alert alert-<?=$_SESSION['messageType']?>" id="messageAlert">
                                        <?php 
                                        echo $_SESSION['message'];
                                        unset($_SESSION['message']);
                                        ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if(isset($_GET['email']) && isset($_GET['token'])): ?>
                            <?php 
                                $email = $_GET['email'];
                                $token = $_GET['token'];
                                $result = $mysqli->query("SELECT * FROM tblaccounts WHERE email='$email' AND token='$token'") or die($mysqli->error);
                                $row = $result->fetch_assoc();
                                date_default_timezone_set('Asia/Singapore');
                                $dateNow = date("Y-m-d h:i:s"); 

                                $expired = (date('Y-m-d h:i:s', strtotime($row['tokenExpiry'])) < $dateNow);
                            ?>

                            <?php if($expired == true): ?>
                                <div class="row">
                                    <div class="form-group">
                                        <input type="text" hidden class="form-control" name="email" value="<?php echo $email; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl" style="background: #007bff; border: 1px solid white; border-radius: 5px; font-size: 1.5rem; line-height: 3rem; text-align: center;">
                                        Reset Token has Expired
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-link" name="send" style="color: white;">Resend Request</button> 
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row" hidden>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                                    </div>
                                </div>
                                <div class="row" hidden>
                                    <div class="form-group">
                                        <input type="text"  class="form-control" name="token" value="<?php echo $token; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <strong><label for="newPass">New Password</label></strong>
                                        <input type="password" class="form-control" name="newPass" placeholder="Enter New Password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <strong><label for="confirmPass">Confirm Password</label></strong>
                                        <input type="password" class="form-control" name="confirmPass" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" name="change">Change Password</button> 
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: header('location: ../login/'); ?>

                        <?php endif; ?>
                        </div>
                    </div>
                </div>  
            </form>  
        </div>

        <script type="text/javascript">

        
        var div = document.getElementById('messageAlert');

        function loading(){
          var loader = document.getElementById("loader");
          loader.style.display = "none";
          var pageSystem = "<?php $_SESSION['pageSystem'] = 1; ?>";
          var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";
        }

            var message = "<?php if(!isset($_SESSION['message'])){ echo 'true'; }  ?>"

            if($("#messageAlert").length){     
                if(message == "true"){
                setInterval(function(){  
                    div.style.display = "none";
                }, 3000);
                }
            }

            function showPassword(){
                if(document.getElementById("password").type == "text"){
                    document.getElementById("password").type = "password";
                }
                else{
                    document.getElementById("password").type = "text";
                }
               
            }

        </script>
</body>
</html>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->