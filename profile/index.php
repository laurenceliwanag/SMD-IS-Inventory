<?php
session_start();
if(!isset($_SESSION['userId'])){
        header('Location: ../login/');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <link rel="icon" href="../images/logo-itms.png">
    </head>
    <body onload="loading()">

    <?php require_once 'process.php' ?>
    <?php include '../navbar.php' ?>

    <div class="loader" id="loader"></div>

    <div class="custom-container">

        <?php
            $id = $_SESSION['userId']; 
            require '../connection.php';
            $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id = $id") or die($mysqli->error);
        ?>
    
        <div class="profileFields">
          <img src="../images/logo-itms.png" width="250" height="250" alt="">
            <form action="process.php" method="POST">
              
                <div class="col" id="profileAlert">
                    <?php if(isset($_SESSION['message'])): ?>
                        <div class="alert alert-<?=$_SESSION['messageType']?>" id="messageAlert">
                            <?php 
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
                

                <?php while($row = $result->fetch_assoc()): ?>

                    <?php if($edit == true): ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend" >
                                <div class="input-group-text">First Name</div>
                            </div>
                            <input type="text" class="form-control" name="fname" id= "fname" pattern="[a-zA-Z ]{1,30}" title="Letters only" value="<?php echo $fname ?>" required>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Middle Name</div>
                            </div>
                            <input type="text" class="form-control" name="mname" pattern="[a-zA-Z ]{1,30}" title="Letters only" value="<?php echo $mname ?>">
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Last Name</div>
                            </div>
                            <input type="text" class="form-control" name="lname" id= "lname" pattern="[a-zA-Z ]{1,30}" title="Letters only" value="<?php echo $lname ?>" required>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Qualifier</div>
                            </div>
                            <input type="text" class="form-control" name="qualifier" pattern="[a-zA-Z .]{1,30}" title="Letters only" value="<?php echo $qualifier ?>">
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rank</div>
                            </div>
                            <select class="custom-select" id="rank" name="rank" name="rank" required>
                            <?php if($rank == ''): ?>
                                    <?php if(isset($_COOKIE['rank'])): ?>
                                      <?php 
                                        $rank = $_COOKIE['rank'];
                                        setcookie("rank", "");
                                        $result = $mysqli->query("SELECT * FROM tblranks WHERE id != '$rank'") or die($mysqli->error());
                                        $resultSelected = $mysqli->query("SELECT * FROM tblranks WHERE id = '$rank'") or die($mysqli->error());
                                        $rowSelected = $resultSelected->fetch_assoc();
                                      ?>
                                      <option value="<?php echo $rowSelected['id']; ?>" selected><?php echo $rowSelected['rank']; ?></option>
                                    <?php else: ?>
                                      <?php 
                                        $result = $mysqli->query("SELECT * FROM tblranks") or die($mysqli->error());
                                      ?>
                                      <option value="" selected>-Select Rank-</option>
                                    <?php endif; ?>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                      <option value="<?php echo $row['id']; ?>"><?php echo $row['rank']; ?></option>
                                    <?php endwhile; ?>
                                    <option value="Modify Ranks">-Modify Ranks-</option>
                                  <?php else: ?>
                                    <?php 
                                      $result = $mysqli->query("SELECT * FROM tblranks WHERE id != '$rank'") or die($mysqli->error());
                                      $resultSelected = $mysqli->query("SELECT * FROM tblranks WHERE id = '$rank'") or die($mysqli->error());
                                      $rowSelected = $resultSelected->fetch_assoc();
                                    ?>
                                    <option value="<?php echo $rowSelected['id']; ?>" selected><?php echo $rowSelected['rank']; ?></option>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                      <option value="<?php echo $row['id']; ?>"><?php echo $row['rank']; ?></option>
                                    <?php endwhile; ?>
                                    <option value="Modify Ranks">-Modify Ranks-</option>
                                  <?php endif; ?>
                            </select>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Email Address</div>
                            </div>
                            <input type="email" class="form-control" name="email" value="<?php echo $email ?>" required>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Username</div>
                            </div>
                            <input type="text" class="form-control" name="username" id= "username" value="<?php echo $username ?>" disabled>
                        </div>
                        <div class="form-group">          
                            <a href="../profile/" class="btn btn-danger mb-4" style="float:right;">Cancel</a>
                            <button type="submit" class="btn btn-success mb-4" name="save" style="float:right; margin-right: 5px;">Save</button>
                        </div>

                    <?php elseif($password == true): ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="currentPassword">Current Password</div>
                            </div>
                            <input type="password" class="form-control" name="currentPassword" required maxlength="16" minlength="8" pattern="[a-zA-Z0-9]{1,30}" title="Letters and numbers only" placeholder="Current Password">
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="newPassword">New Password</div>
                            </div>
                            <input type="password" class="form-control" name="newPassword" required maxlength="16" minlength="8" pattern="[a-zA-Z0-9]{1,30}" title="Letters and numbers only" placeholder="New Password">
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"  id="confirmPassword">Confirm Password</div>
                            </div>
                            <input type="password" class="form-control" name="confirmPassword" required maxlength="16" minlength="8" pattern="[a-zA-Z0-9]{1,30}" title="Letters and numbers only" placeholder="Confirm Password">
                        </div>
                           <div class="form-group">          
                            <a href="../profile/" class="btn btn-danger" style="float:right;">Cancel</a>
                            <button type="submit" class="btn btn-success" name="savePassword" style="float:right; margin-right: 5px;">Save</button>
                        </div>

                    <?php else: ?>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">First Name</div>
                            </div>
                            <input type="text" class="form-control" name="fname" value="<?php echo $row['fname'] ?>" disabled>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Middle Name</div>
                            </div>
                            <input type="text" class="form-control" name="mname" value="<?php echo $row['mname'] ?>" disabled>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Last Name</div>
                            </div>
                            <input type="text" class="form-control" name="lname" value="<?php echo $row['lname'] ?>" disabled>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Qualifier</div>
                            </div>
                            <input type="text" class="form-control" name="qualifier" value="<?php echo $row['qualifier'] ?>" disabled>
                        </div>
                        <?php 
                             $rank = $row['rank'];
    
                             $resultRank = $mysqli->query("SELECT * FROM tblranks WHERE id = $rank") or die($mysqli->error());
                             $rowRank = $resultRank->fetch_array();
                         
                             $rank = $rowRank['rank'];
                        ?>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rank</div>
                            </div>
                            <input type="text" class="form-control" name="rank" value="<?php echo $rank; ?>" disabled>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Email Address</div>
                            </div>
                            <input type="text" class="form-control" name="email" value="<?php echo $row['email'] ?>" disabled>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Username</div>
                            </div>
                            <input type="text" class="form-control" name="username" value="<?php echo $row['username'] ?>" disabled>
                        </div>
                        <div class="form-group mb-4" style="float:right;">
                            <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-info" style="float:right;">Edit</a>
                        </div>
                        <div class="form-group mb-4" style="float:right;">
                            <a href="?password=<?php echo $row['id']; ?>" class="btn btn-default" style="float:right; margin-right: 5px;">Change Password</a>
                        </div>
                <?php endif; ?>
                
                <?php endwhile; ?>
             
            </form>
        </div> 
    </div>

    
    <script type="text/javascript">

    var div = document.getElementById('messageAlert');
    var username = document.getElementById('username');
    var lname = document.getElementById('lname');
    var fname = document.getElementById('fname');

    if($('#messageAlert').css('display') != 'none'){
        setInterval(function(){  
          div.style.display = 'none';
        }, 2000);
      }
      else{
          //something else
      }

        function loading(){
            var loader = document.getElementById("loader");
            loader.style.display = "none";
            var pageSystem = "<?php $_SESSION['pageSystem'] = 1; ?>";
            var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";

            document.getElementById("profile").style.color = "black";
            document.getElementById("profile").style.fontWeight = "bold";
        }

    fname.addEventListener('input', function () {
          username.value = (lname.value + "." + this.value).toLowerCase().replace(/\s/g, "");
      });

      lname.addEventListener('input', function () {
          username.value = (this.value + "." + fname.value).toLowerCase().replace(/\s/g, "");
      });

    </script>

    </body>
</html>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->