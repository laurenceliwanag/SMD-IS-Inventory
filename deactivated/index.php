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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link rel="icon" href="../images/logo-itms.png">
    </head>
    <body onload="loading()">

      <?php require_once 'process.php' ?>
      <?php include '../navbar.php' ?>

      <div class="loader" id="loader"></div>

      <div class="custom-container">
      
        <!-----TITLE----->
        <div class="row">
          <div class="col" id="accountTitle">
            <h1 align="center">Deactivated Accounts</h1>
            <hr>
          </div>
        </div>

          <!-----FILTERS-----> 
          <form action="../deactivated/" method="POST" style="display: grid; justify-items: center;">
            <div class="row" id="accountFilters" style="width: 80%;">
              <div class="col-xl-4" style="margin-top: 1rem;">
                <div class="form-group">
                  <input type="text" name="searchValue" class="form-control" placeholder="Search Account">
                </div> 
              </div>
              <div class="col-xl-3" style="margin-top: 1rem;">
                <div class="form-group">
                  <select  class="custom-select" name="rankValue">
                    <option value="" selected>-Select Rank-</option>
                    <option value="">All</option>
                    <?php 
                      $result = $mysqli->query("SELECT * FROM tblranks") or die($mysqli->error());
                    ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['rank']; ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>  
              </div>
              <div class="col-xl-2" style="margin-top: 1rem;">
                  <div class="form-group">
                    <select class="custom-select" name="authorityValue"> 
                      <option value="" selected>-Select Authority Level-</option>
                      <option value="">All</option>
                      <option value="admin">Admin</option>
                      <option value="researcher">Researcher</option>
                      <option value="user">User</option>
                    </select>
                  </div> 
              </div>
              <div class="col-xl-3" style="text-align: center;">
                <div class="form-group">
                  <button class="btn btn-outline-info" name="search" style="margin-right: .25rem; margin-top: 1rem">Search</button>
                  <button class="btn btn-outline-info" name="clear" style="margin-right: .25rem; margin-top: 1rem;">Clear</button>
                </div>
              </div>
            </div>
          </form>
          
          <hr>

        <!-----MESSAGES ALERT----->
        <div class="row">   
          <div class="col" id="accountAlert">
            <?php if(isset($_SESSION['errorMessage'])): ?>
              <div class="alert alert-<?php echo $_SESSION['errorMessageType'] ?>" id="errorMessageAlert">
                <?php 
                  echo $_SESSION['errorMessage'];
                  unset($_SESSION['errorMessage']);
                ?>
              </div>
            <?php endif; ?>
          </div>

           <!-----BUTTONS----->
           <div class="col-2" id="accountButtons">
           
          </div>
        </div>
        
        <!-----ACCOUNT TABLE----->
        <div class="row">
          <div class="col" id="accountTable">
            <?php 
              require '../connection.php';
              $userId = $_SESSION['userId'];

              if (isset($_POST['search'])){
                $searchValue = $_POST['searchValue'];
                $rankValue = $_POST['rankValue'];
                $authorityValue = $_POST['authorityValue'];

                if($searchValue != ""){
                  if($rankValue != ""){
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC") or die($mysqli->error);
                      $rowCount = $result1->fetch_assoc();
                      $resultCount = 10;
                      $pageNumber = ceil($rowCount['count'] / $resultCount);
        
                      if(!isset($_GET['page'])){
                        $page = 1;
                        setcookie("page", $page);
                      }
                      else{
                        $page = $_GET['page'];
                        setcookie("page", $page);
                        
                      }
        
                      $startLimit = ($page - 1) * $resultCount;
                      
                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC") or die($mysqli->error);
                      $rowCount = $result1->fetch_assoc();
                      $resultCount = 10;
                      $pageNumber = ceil($rowCount['count'] / $resultCount);
        
                      if(!isset($_GET['page'])){
                        $page = 1;
                        setcookie("page", $page);
                      }
                      else{
                        $page = $_GET['page'];
                        setcookie("page", $page);
                        
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC");
                    }
                  }
                  else{
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC") or die($mysqli->error);
                      $rowCount = $result1->fetch_assoc();
                      $resultCount = 10;
                      $pageNumber = ceil($rowCount['count'] / $resultCount);
        
                      if(!isset($_GET['page'])){
                        $page = 1;
                        setcookie("page", $page);
                      }
                      else{
                        $page = $_GET['page'];
                        setcookie("page", $page);
                        
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC") or die($mysqli->error);
                      $rowCount = $result1->fetch_assoc();
                      $resultCount = 10;
                      $pageNumber = ceil($rowCount['count'] / $resultCount);
        
                      if(!isset($_GET['page'])){
                        $page = 1;
                        setcookie("page", $page);
                      }
                      else{
                        $page = $_GET['page'];
                        setcookie("page", $page);
                        
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC");
                    }
                  }
                }
                else{
                  if($rankValue != ""){
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' ORDER BY fname ASC") or die($mysqli->error);
                      $rowCount = $result1->fetch_assoc();
                      $resultCount = 10;
                      $pageNumber = ceil($rowCount['count'] / $resultCount);
        
                      if(!isset($_GET['page'])){
                        $page = 1;
                        setcookie("page", $page);
                      }
                      else{
                        $page = $_GET['page'];
                        setcookie("page", $page);
                        
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' ORDER BY fname ASC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' ORDER BY fname ASC") or die($mysqli->error);
                      $rowCount = $result1->fetch_assoc();
                      $resultCount = 10;
                      $pageNumber = ceil($rowCount['count'] / $resultCount);
        
                      if(!isset($_GET['page'])){
                        $page = 1;
                        setcookie("page", $page);
                      }
                      else{
                        $page = $_GET['page'];
                        setcookie("page", $page);
                        
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND rank = '$rankValue' ORDER BY fname ASC");
                    }
                  }
                  else{
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND authorityLevel = '$authorityValue' ORDER BY fname ASC") or die($mysqli->error);
                      $rowCount = $result1->fetch_assoc();
                      $resultCount = 10;
                      $pageNumber = ceil($rowCount['count'] / $resultCount);
        
                      if(!isset($_GET['page'])){
                        $page = 1;
                        setcookie("page", $page);
                      }
                      else{
                        $page = $_GET['page'];
                        setcookie("page", $page);
                        
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND authorityLevel = '$authorityValue' ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' AND authorityLevel = '$authorityValue' ORDER BY fname ASC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status = 'deactivated' ORDER BY fname ASC") or die($mysqli->error);
                      $rowCount = $result1->fetch_assoc();
                      $resultCount = 10;
                      $pageNumber = ceil($rowCount['count'] / $resultCount);
        
                      if(!isset($_GET['page'])){
                        $page = 1;
                        setcookie("page", $page);
                      }
                      else{
                        $page = $_GET['page'];
                        setcookie("page", $page);
                        
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' ORDER BY fname ASC");
                    }
                  }
                }
              }
              else{
                $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status = 'deactivated' ORDER BY fname ASC") or die($mysqli->error);
                $rowCount = $result1->fetch_assoc();
                $resultCount = 10;
                $pageNumber = ceil($rowCount['count'] / $resultCount);
  
                if(!isset($_GET['page'])){
                  $page = 1;
                  setcookie("page", $page);
                }
                else{
                  $page = $_GET['page'];
                  setcookie("page", $page);
                  
                }
  
                $startLimit = ($page - 1) * $resultCount;
                
                $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' ORDER BY fname ASC LIMIT $startLimit, $resultCount") or die($mysqli->error);
                $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status = 'deactivated' ORDER BY fname ASC LIMIT $startLimit, $resultCount");
              }
            ?>

          <?php if(isset($_POST['search'])): ?>        
            <?php                           
              $tblRank = $rankValue;
              $resultRank = $mysqli->query("SELECT * FROM tblranks WHERE id = '$tblRank'") or die($mysqli->error());
              $rowRank = $resultRank->fetch_array(); 
            ?>
            <p align="center"><strong>Keyword Searched: </strong> <?php echo $searchValue . " | "; ?><strong>Rank: </strong> <?php echo $rowRank['rank'] . " | "; ?><strong>Authority Level : </strong> <?php echo $authorityValue; ?></p>
          <?php endif; ?>

          <div id="divTable">
            <table class="table table-striped table-hover table-responsive" id="tblAccounts">
            <thead>
                  <tr>
                    <th style="width: 13vw;">First Name</th>
                    <th style="width: 10vw;">Middle Name</th>
                    <th style="width: 13vw;">Last Name</th>
                    <th style="width: 5vw;">Qualifier</th>
                    <th style="width: 20vw;">Rank</th>
                    <th style="width: 10vw;">Authority Level</th>
                    <th style="width: 7vw;">Status</th>
                    <th style="width: 8vw;">Date Added</th> 
                    <th style="width: 16vw;"class="action">Action</th>
                  </tr>
                </thead>
                
                <?php if($result != ""): ?>
                  <?php while($row = $result->fetch_assoc()): ?>
                    <tr ondblclick="accountView(<?php echo $row['id'] ?>)">
                      <td><?php echo $row['fname'] ?></td>
                      <td><?php echo $row['mname'] ?></td>
                      <td><?php echo $row['lname'] ?></td>
                      <td><?php echo $row['qualifier'] ?></td>
                      <td>
                        <?php 
                          $tblRank = $row['rank'];
                          $resultRank = $mysqli->query("SELECT * FROM tblranks WHERE id = '$tblRank'") or die($mysqli->error());
                          $rowRank = $resultRank->fetch_array();
                          echo $rowRank['rank']; 
                        ?>
                      </td>
                      <td><?php echo ucwords($row['authorityLevel']) ?></td>
                      <td><?php echo ucwords($row['status']) ?></td>
                      <td><?php echo date("Y-m-d", strtotime($row['dateAdded'])); ?></td>
                      <td class="action">
                        <form action="process.php" method="POST">
                          <div>
                            <a href="?view=<?php echo $row['id']; ?>" class="btn btn-success" id="btnView" data-toggle="tooltip" data-placement="top" title="View" style="margin-top: .4rem;"><image src="../images/view.png" height="20" width="20"></image></a>
                            <a href="?activate=<?php echo $row['id']; ?>" class="btn" data-toggle="tooltip" data-placement="top" title="Activate" style="background: #07666d; margin-top: .4rem;" id="btnDelete"><image src="../images/recover.png" height="20" width="20"></image></a>
                          </div>      
                        </form>
                      </td>
                    </tr>   
                  <?php endwhile; ?>
      
                <?php endif ?>
              </table>
            </div>

            <script>
                  $(document).ready(function(){
                      var query = "<?php echo $resultString; ?>";
                      var docCount = 10;
                      $("#btnViewMoreFilter").click(function(){
                        docCount = docCount + 10;
                        $("#divTable").load("viewMoreDeactivated.php", {
                          newQuery: query,
                          newDocCount: docCount
                        });
                      });
                  });
              </script>

            <div class="row">
              <div class="col">
                <a href="../accounts/" class="btn btn-link" name="deleted" style="float: right; margin: 0; padding: 0;">List of Accounts</a>
              </div>
            </div>
   
            <form action="../deactivated/" method="GET" id="accountsPagination">
                  <?php if(isset($_POST['search'])): ?>
                    <div class="row" style="display: grid; justify-items: center; margin-top: 1rem; <?php if($rowCount['count'] == 0 || $rowCount['count'] <= 10): ?>display: none;<?php endif; ?>" id="divViewMore">
                        <button class="btn btn-outline-primary" type="button" id="btnViewMoreFilter" style="width: 30vw;">View More</button>
                    </div>
                    <p><?php echo $rowCount['count'] ?> Search Result</p> 
                  <?php else: ?>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                      <?php if($page == '1'): ?>
                        <button disabled class="btn btn-outline-primary"><</button>
                      <?php else: ?>
                        <a href="../deactivated/?page=<?php echo $page - 1 ?>" class="btn btn-outline-primary"><</a>
                      <?php endif; ?>

                      <?php 
                        if(!isset($_GET['page'])){
                          $currentPage = 1;
                        }
                        else{
                          $currentPage = $_GET['page'];
                        }
                      ?>

                      <?php for($page= max(1, $page - 2); $page <= min($currentPage + 2, $pageNumber) ; $page++):?>   
                        <?php if($currentPage == $page): ?>
                          <a href="../deactivated/?page=<?php echo $page ?>" class="btn btn-primary"><?php echo $page ?></a>
                        <?php else: ?>
                          <a href="../deactivated/?page=<?php echo $page ?>" class="btn btn-outline-primary"><?php echo $page ?></a>
                        <?php endif; ?>
                      <?php endfor; ?>

                      <?php 
                        if(!isset($_GET['page'])){
                          $page = 1;
                        }
                        else{
                          $page = $_GET['page'];
                        }
                      ?>

                      <?php if($page == $pageNumber): ?>
                        <button disabled class="btn btn-outline-primary">></button>
                      <?php else: ?>
                        <a href="../deactivated/?page=<?php echo $page + 1 ?>" class="btn btn-outline-primary">></a>
                      <?php endif; ?>
                      <p><?php echo $startLimit + 1?> - <?php $total = $startLimit + $resultCount; if($total < $rowCount['count']){ echo $total; } else{ echo $rowCount['count']; } ?> / <?php echo $rowCount['count'] ?></p> 
                    <?php else: ?>
                        <p>There are no deactivated accounts</p>
                    <?php endif; ?>
                  <?php endif; ?>
                </form>
          </div>
        </div>
        
        <!-----MODAL----->
        <div class="modal fade" id="addAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title ml-auto">Account Information</h5>
                <a href="../deactivated/?page=<?php echo $_COOKIE["page"]; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
              </div>

                <form action="process.php" method="POST">
                    <div class="modal-body" style="margin-left: 2vw; margin-right: 2vw;" id="modalBody">
                      <div class="row">
                        <div class="col" style="display: grid; align-items: center;">
                          <div class="input-group mr-sm-2" id="systemLogo">
                            <img src="../images/logo-itms.png" style="height: 9vw; width: 9vw;" alt=""> 
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-top: 2vw; margin-left: 1vw;">
                        <div class="col">
                          <label  style="font-weight: bold;">Full Name :</label>
                          <h6 align="justify" style="font-size: .9vw"><?php echo $fname . ' ' . $mname . ' ' . $lname . ' ' . $qualifier; ?></h6>    
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">Email Address :</label>
                          <h6 align="justify" style="font-size: .9vw"><?php echo $email; ?></h6>  
                        </div> 
                      </div>
                      <div class="row" style="margin-top: 1vw; margin-left: 1vw;">
                        <div class="col">
                          <label  style="font-weight: bold;">Rank :</label>
                          <h6 align="justify" style="font-size: .9vw"><?php echo $rank; ?></h6>  
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">PNP Office/Unit :</label>
                          <h6 align="justify" style="font-size: .9vw"><?php echo $office; ?></h6>  
                        </div>  
                      </div> 
                      <div class="row" style="margin-top: 1vw; margin-left: 1vw;">
                        <div class="col">
                          <label  style="font-weight: bold;">Username :</label>
                          <h6 align="justify" style="font-size: .9vw"><?php echo $username; ?></h6>  
                        </div> 
                        <div class="col"> 
                          <label  style="font-weight: bold;">Authority Level :</label>
                          <h6 align="justify" style="font-size: .9vw"><?php echo $authorityLevel; ?></h6> 
                        </div> 
                      </div>
                      <div class="row" style="margin-top: 1vw; margin-left: 1vw;">
                        <div class="col">
                          <label  style="font-weight: bold;">Date Added :</label>
                          <h6 align="justify" style="font-size: .9vw"><?php echo $dateAdded; ?></h6>  
                        </div> 
                      </div>  
                    </div>

                    <div class="modal-footer"> 
                        <a href="../deactivated/?page=<?php echo $_SESSION['pageAccount']; ?>" class="btn btn-danger">Close</a>
                    </div>
                  </div>
                </form>
            </div>
          </div>
        </div>

          <!-----MODAL ACTIVATE----->
          <div class="modal fade" id="activateAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                
                <h5 class="modal-title" id="exampleModalLabel">Activate Account</h5>
                <a href="../deactivated/?page=<?php echo $_COOKIE["page"]; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
              </div>

              <form action="process.php" method="POST">
                <div class="modal-body">
                  Are you sure you want to activate this account?
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-success" name="btnYesA">Yes</button>
                  <a href="../deactivated/?page=<?php echo $_COOKIE["page"]; ?>" class="btn btn-danger" name="btnNo">No</a>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>

   
      <script type="text/javascript">

      var div = document.getElementById('messageAlert');
      var errorDiv = document.getElementById('errorMessageAlert');

      var id = "<?php echo $id; ?>";
      var update = "<?php echo $update; ?>";
      var view = "<?php echo $view; ?>";
      var dele = "<?php echo $delete; ?>";
      var activate = "<?php echo $activate; ?>";
      var error = "<?php echo $error; ?>";

      function loading(){
          var loader = document.getElementById("loader");
          loader.style.display = "none";
          var pageSystem = "<?php $_SESSION['pageSystem'] = 1; ?>";
          var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";

          document.getElementById("accounts").style.color = "black";
          document.getElementById("accounts").style.fontWeight = "bold";
        }

      function accountView(id){
        location.href = "../deactivated/?view=" + id;
      }

      $('#addAccount').on('hidden.bs.modal', function () {
        location.href = "../deactivated/"
      })

      $('#deleteAccount').on('hidden.bs.modal', function () {
        location.href = "../deactivated/"
      })

      $('#activateAccount').on('hidden.bs.modal', function () {
        location.href = "../deactivated/"
      })

      if(error == true){
        $(window).on('load',function(){
            $('#addAccount').modal('show');
          });
      }

      if(id != 0 && update == true){
        $(window).on('load',function(){
          $('#addAccount').modal('show');
        });
      }

      else if(id != 0 && view == true){
        $(window).on('load',function(){
          $('#addAccount').modal('show');
        });
      }

      else if(id != 0 && dele == true){
        $(window).on('load',function(){
          $('#deleteAccount').modal('show');
        });
      }

      else if(id != 0 && activate == true){
        $(window).on('load',function(){
          $('#activateAccount').modal('show');
        });
      }

      var message = "<?php if(!isset($_SESSION['message'])){ echo 'true'; }  ?>"
      var errMessage = "<?php if(!isset($_SESSION['errorMessage'])){ echo 'true'; }  ?>"

      if($("#messageAlert").length){     
        if(message == "true"){
          setInterval(function(){  
            div.style.display = "none";
          }, 3000);
        }
      }

      if($("#errorMessageAlert").length){     
        if(errMessage == "true"){
          setInterval(function(){  
            errorDiv.style.display = "none";
          }, 3000);
        }
      }

      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })


      </script>

    </body>
</html>



<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->