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
            <h1 align="center">Active Accounts</h1>
            <hr>
          </div>
        </div>
          
          <!-----FILTERS-----> 
          <form action="../accounts/" method="POST" style="display: grid; justify-items: center;">
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
            <?php if(isset($_SESSION['message'])): ?>
              <div class="alert alert-<?php echo $_SESSION['messageType'] ?>" id="messageAlert">
                <?php 
                  echo $_SESSION['message'];
                  unset($_SESSION['message']);
                ?>
              </div>
            <?php endif; ?>
          </div>

          <!-----BUTTONS----->
          <div class="col-2" id="accountButtons">
            <button id="addAccountButton" type="button" class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#addAccount"><image src="../images/adduser.png" height="20" width="22" style="float: left; margin-top: 3px; margin-right: .5vw; margin-left: .4vw;"></image><a class="d-none d-lg-block">NEW ACCOUNT</a></button>
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
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC") or die($mysqli->error);
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
                        $_SESSION['pageAccount'] = $page;
                      }
        
                      $startLimit = ($page - 1) * $resultCount;
                      
                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC");

                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC") or die($mysqli->error);
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
                        $_SESSION['pageAccount'] = $page;
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC");
                    }
                  }
                  else{
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC") or die($mysqli->error);
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
                        $_SESSION['pageAccount'] = $page;
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC") or die($mysqli->error);
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
                        $_SESSION['pageAccount'] = $page;
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY fname ASC");
                    }
                  }
                }
                else{
                  if($rankValue != ""){
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' ORDER BY fname ASC") or die($mysqli->error);
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
                        $_SESSION['pageAccount'] = $page;
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' AND authorityLevel = '$authorityValue' ORDER BY fname ASC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' ORDER BY fname ASC") or die($mysqli->error);
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
                        $_SESSION['pageAccount'] = $page;
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND rank = '$rankValue' ORDER BY fname ASC");
                    }
                  }
                  else{
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND authorityLevel = '$authorityValue' ORDER BY fname ASC") or die($mysqli->error);
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
                        $_SESSION['pageAccount'] = $page;
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND authorityLevel = '$authorityValue' ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' AND authorityLevel = '$authorityValue' ORDER BY fname ASC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status != 'deactivated' ORDER BY fname ASC") or die($mysqli->error);
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
                        $_SESSION['pageAccount'] = $page;
                      }
        
                      $startLimit = ($page - 1) * $resultCount;

                      $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' ORDER BY fname ASC LIMIT 10") or die($mysqli->error);
                      $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' ORDER BY fname ASC");
                    }
                  }
                }
              }
              else{
                $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblaccounts WHERE id != $userId AND status != 'deactivated' ORDER BY fname ASC") or die($mysqli->error);
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
                  $_SESSION['pageAccount'] = $page;
                }
  
                $startLimit = ($page - 1) * $resultCount;
                
                $result = $mysqli->query("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' ORDER BY fname ASC LIMIT $startLimit, $resultCount") or die($mysqli->error);
                $resultString = ("SELECT * FROM tblaccounts WHERE id != $userId AND status != 'deactivated' ORDER BY fname ASC LIMIT $startLimit, $resultCount");
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
          <p align="center" ><strong>Total No. of Accounts: </strong> <?php echo mysqli_num_rows($result); ?></p>

          <div id = "divTable">
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
                            <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-info" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Edit" style="margin-top: .4rem;"><image src="../images/edit.png" height="20" width="20"></image></a>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger" id="btnDelete" data-toggle="tooltip" data-placement="top" title="Deactivate" style="margin-top: .4rem;"><image src="../images/delete.png" height="20" width="20"></image></a>
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
                        $("#divTable").load("viewMoreAccounts.php", {
                          newQuery: query,
                          newDocCount: docCount
                        });
                      });
                  });
              </script>

            <div class="row">
              <div class="col">
                <a href="../deactivated/" class="btn btn-link" name="deleted" style="float: right; margin: 0; padding: 0;">Deactivated Accounts</a>
              </div>
            </div>
   
            <form action="../accounts/" method="GET" id="accountsPagination">
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
                          <a href="../accounts/?page=<?php echo $page - 1 ?>" class="btn btn-outline-primary"><</a>
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
                            <a href="../accounts/?page=<?php echo $page ?>" class="btn btn-primary"><?php echo $page ?></a>
                          <?php else: ?>
                            <a href="../accounts/?page=<?php echo $page ?>" class="btn btn-outline-primary"><?php echo $page ?></a>
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
                          <a href="../accounts/?page=<?php echo $page + 1 ?>" class="btn btn-outline-primary">></a>
                        <?php endif; ?>
                        <p><?php echo $startLimit + 1?> - <?php $total = $startLimit + $resultCount; if($total < $rowCount['count']){ echo $total; } else{ echo $rowCount['count']; } ?> / <?php echo $rowCount['count'] ?></p> 
                      <?php else: ?>
                          <p>There are no existing accounts</p>
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
                <img src="../images/logo-itms.png" height="30" width="30" alt="" style="margin-left: .7vw;">
                <?php if($view == true): ?>
                  <h5 class="modal-title ml-auto">Account Information</h5>
                <?php elseif($update == true): ?>
                  <h5 class="modal-title ml-auto">Edit Account</h5>
                <?php else: ?> 
                  <h5 class="modal-title ml-auto">Add Account</h5>
                <?php endif; ?>
                <a href="../accounts/?page=<?php echo $_SESSION['pageAccount']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
              </div>

              <?php if($view == true): ?>
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
                      <a href="?edit=<?php echo $id; ?>" class="btn btn-info" id="btnEdit">Edit</a>
                      <a href="../accounts/?page=<?php echo $_SESSION['pageAccount']; ?>" class="btn btn-danger">Close</a>
                  </div>
                </form>

              <?php else: ?>
                <form action="process.php" method="POST">
                  <div class="modal-body" id="modalBody">
    
                    <div class="row"> 
                      <div class="col" id="errorAccountAlert">
                        <?php if(isset($_SESSION['errorMessage'])): ?>
                          <div class="alert alert-<?php echo $_SESSION['errorMessageType'] ?>" id="errorMessageAlert">
                            <?php 
                              echo $_SESSION['errorMessage'];
                              unset($_SESSION['errorMessage']);
                              $error = true;
                            ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                      <strong><label for="fname">FIRST NAME</label></strong>
                      <strong><label style ="color: red;">*</label></strong>
                      <input type="text" name="fname" class="form-control" id="fname" pattern="[a-zA-Z ]{1,30}" title="Letters only" placeholder="Enter First Name" required value="<?php if(!isset($_COOKIE["fname"])){echo $fname;}else{echo $_COOKIE["fname"]; setcookie("fname", "");} ?>">
                    </div>  
                    <div class="form-group">
                      <strong><label for="mname">MIDDLE NAME</label></strong>
                      <input type="text" name="mname" class="form-control" placeholder="Enter Middle Name" pattern="[a-zA-Z ]{1,30}" title="Letters only" value="<?php if(!isset($_COOKIE["mname"])){echo $mname;}else{echo $_COOKIE["mname"]; setcookie("mname", "");} ?>">
                    </div>  
                    <div class="row">
                      <div class="col"> 
                        <div class="form-group">
                          <strong><label for="lname">LAST NAME</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <input type="text" name="lname" class="form-control" id="lname" pattern="[a-zA-Z ]{1,30}" title="Letters only" placeholder="Enter Last Name" required value="<?php if(!isset($_COOKIE["lname"])){echo $lname;}else{echo $_COOKIE["lname"]; setcookie("lname", "");} ?>">
                        </div>
                      </div>
                      <div class="col-3"> 
                        <div class="form-group">
                          <strong><label for="qualifier">QUALIFIER</label></strong>
                          <input type="text" name="qualifier" class="form-control" id="qualifier" pattern="[a-zA-Z .]{1,30}" title="Letters only" placeholder="Enter Qualifier" value="<?php if(!isset($_COOKIE["qualifier"])){echo $qualifier;}else{echo $_COOKIE["qualifier"]; setcookie("qualifier", "");} ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xl">
                        <div class="form-group" id="accountRank">
                          <strong><label for="rank">RANK</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <select class="custom-select" id="rank" name="rank" required onchange="modifyRanks(<?php echo $id; ?>)">
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
                      </div> 
                      <div class="col-xl">
                        <div class="form-group" id="formGroup" <?php if($office != ""): ?>style="display: none;"<?php endif; ?>>
                          <strong><label for="group">GROUPS</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <select class="custom-select" name="group" id="group" <?php if($office == ""): ?>required<?php endif;?>>
                            <option value="" selected>-Select Group-</option>
                            <option value="Command Group">Command Group</option>
                            <option value="P-Staff/Other Staff">P-Staff/Other Staff</option>
                            <option value="D-Staff">D-Staff</option>
                            <option value="NASU">NASU</option>
                            <option value="NOSU">NOSU</option>
                            <option value="NCRPO">NCRPO</option>
                            <option value="PROs">PROs</option>
                          </select>
                        </div> 
                        <div class="form-group" id="formOffice" <?php if($office == ""): ?>style="display: none;"<?php endif; ?>>
                          <strong><label for="office">PNP OFFICE/UNIT</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <select class="custom-select" name="office" id="office" required>
                            <?php if(!isset($_COOKIE["office"])): ?>
                              <?php if($office == ''): ?>
                                <option value="" selected>-Select Office/Unit-</option>
                              <?php else: ?>
                                <option value="<?php echo $office; ?>" selected><?php echo $office; ?></option>
                                <option value="-Select Group-">-Select Group-</option>
                            <?php endif; ?>
                              <?php else: ?>
                               <option value="<?php echo $_COOKIE["office"]; setcookie("office", ""); ?>" selected><?php echo $_COOKIE["office"]; setcookie("office", ""); ?></option>
                               <option value="-Select Group-">-Select Group-</option>
                            <?php endif; ?>
                          </select> 
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <strong><label for="email">EMAIL ADDRESS</label></strong>
                      <strong><label style ="color: red;">*</label></strong>
                      <input type="email" name="email" class="form-control" placeholder="Enter your email address" required value="<?php if(!isset($_COOKIE["email"])){echo $email;}else{echo $_COOKIE["email"]; setcookie("email", "");} ?>">
                    </div>
                    <div class="form-group">
                      <strong><label for="username">USERNAME</label></strong>
                      <input type="text" name="username" class="form-control" id="username" placeholder="Default Username" readonly value="<?php if(!isset($_COOKIE["username"])){echo $username;}else{echo $_COOKIE["username"]; setcookie("username", "");} ?>">
                    </div>
                    <?php if($id == 0): ?>
                      <div class="form-group">
                        <strong><label for="password">PASSWORD</label></strong>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Default Password" readonly value="<?php if(!isset($_COOKIE["password"])){echo $password;}else{echo $_COOKIE["password"]; setcookie("password", "");} ?>">
                      </div>
                    <?php else: ?>
                      <div class="form-group">
                        <strong><label for="password">PASSWORD</label></strong>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Default Password" pattern="[a-zA-Z0-9]{1,50}" title="Letters and numbers only"  value="<?php echo $password ?>" required maxlength="16" minlength="8">
                      </div>
                    <?php endif; ?>
                    <div class="form-group">
                      <strong><label for="userLevel">AUTHORITY LEVEL</label></strong>
                      <strong><label style ="color: red;">*</label></strong>
                      <select class="custom-select" id="authorityLevel" name="authorityLevel" required>
                        <?php if($authorityLevel == ''): ?>
                          <option value="" selected>-Select Authority Level-</option>
                        <?php endif; ?>
                        <option <?php if(!isset($_COOKIE["admin"])){echo $admin;}else{echo $_COOKIE["admin"]; setcookie("admin", "");} ?> value="Admin">Admin</option>
                        <option <?php if(!isset($_COOKIE["researcher"])){echo $researcher;}else{echo $_COOKIE["researcher"]; setcookie("researcher", "");} ?> value="Researcher">Researcher</option>
                        <option <?php if(!isset($_COOKIE["user"])){echo $user;}else{echo $_COOKIE["user"]; setcookie("user", "");} ?> value="User">User</option>
                      </select>
                    </div>       
                  </div>


                  <div class="modal-footer"> 
                    <?php if($view == true): ?>
                      <a href="?edit=<?php echo $id; ?>" class="btn btn-info" id="btnEdit">Edit</a>
                      <a href="../accounts/?page=<?php echo $_SESSION['pageAccount']; ?>" class="btn btn-danger">Cancel</a>
                    <?php elseif($update == true): ?>
                      <?php if($status == 'activated'): ?>
                        <a href="?delete=<?php echo $id; ?>" class="btn btn-outline-dark mr-auto" id="btnDelete">Deactivate</a>
                      <?php else: ?>
                        <a href="?activate=<?php echo $id; ?>" class="btn btn-outline-dark  mr-auto" id="btnActivate">Activate</a>
                      <?php endif; ?>
                      <button type="submit" class="btn btn-success" id="btnUpdate" name="update">Update</button>
                      <a href="../accounts/?page=<?php echo $_SESSION['pageAccount']; ?>" class="btn btn-danger">Cancel</a>
                    <?php else: ?> 
                      <button type="submit" class="btn btn-success" id="btnSave" name="save">Save</button>
                      <a href="../accounts/?page=<?php echo $_SESSION['pageAccount']; ?>" class="btn btn-danger">Cancel</a>
                    <?php endif; ?>
                  </div>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-----MODAL DELETE----->
        <div class="modal fade" id="deleteAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                
                <h5 class="modal-title" id="exampleModalLabel">Deactivate Account</h5>
                <a href="../accounts/?page=<?php echo $_SESSION['pageAccount']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
              </div>

              <form action="process.php" method="POST">
                <div class="modal-body">
                  Are you sure you want to deactivate this account?
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-success" name="btnYes">Yes</button>
                  <a href="../accounts/?page=<?php echo $_SESSION['pageAccount']; ?>" class="btn btn-danger" name="btnNo">No</a>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-----MODAL RANKS----->
        <div class="modal fade" id="modifyRanks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <img src="../images/logo-itms.png" height="30" width="30" alt="" style="margin-left: .7vw;">
                    <h5 class="modal-title ml-auto">Modify Ranks</h5>
                    <a href="../accounts/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
                  </div>

                  <?php
                      $resultRanks = $mysqli->query("SELECT * FROM tblranks") or die($mysqli->error());
                  ?>

                  <script>
       
                  </script>

                  <form action="process.php" method="POST">
                    <div class="modal-body" id="modalBody">
                      <div class="row">
                        <div class="col">
                          <div class="form-group" style="text-align: right;">
                            <button type="button" class="btn btn-primary" onclick = "newRank()"><image src="../images/addsystem.png" height="20" width="22" style="float: left; margin-top: 3px; margin-right: .5rem; "></image>New Rank</button>
                          </div>
                      
                          <div class="form-group" id="divRanks">
                            <input type="hidden" class="form-control" id="inputRankCount" name="inputRankCount" value="" style="background: white;">
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col" id="errorDocumentAlert">
                          <?php if(isset($_SESSION['rankMessage'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['rankMessageType'] ?>" id="rankMessageAlert">
                              <?php 
                                echo $_SESSION['rankMessage'];
                                unset($_SESSION['rankMessage']);
                              ?>
                            </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    
                      <div class="row">
                        <div class="col">
                          <?php while($rowRanks = $resultRanks->fetch_assoc()): ?>
                              <div class="form-group">
                                <input type="hidden" class="form-control" name="systemIdRank" value="<?php echo $id; ?>" style="background: white;">
                                <input type="hidden" class="form-control" name="<?php echo $rowRanks['id']; ?>" value="<?php echo $rowRanks['id']; ?>" style="background: white;">
                                <input type="text" class="form-control" name="<?php echo str_replace(' ', '', $rowRanks['rank']); ?>" value="<?php echo $rowRanks['rank']; ?>" style="background: white;">
                              </div>
                            <?php endwhile; ?>
                        </div>
                      </div>  
                    </div>

                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success" id="btnUpdate" name="updateRank">Update</button>
                      <?php if($id != 0): ?>
                        <a href="../accounts/?edit=<?php echo $id; ?>" class="btn btn-info" name="btnBack">Back</a>
                      <?php else: ?>
                        <button type="button" class="btn btn-info" id="btnBack" name="btnBack" onclick="backNewAccount()">Back</button>
                      <?php endif; ?>
                    </div>
                  </form>
                </div>
              </div>
            </div>
      </div>

      <?php $pageCookie = $_SESSION['pageAccount']; ?>
   
      <script type="text/javascript">

      var div = document.getElementById('messageAlert');
      var errorDiv = document.getElementById('errorMessageAlert');
      var rankDiv = document.getElementById('rankMessageAlert');

      var id = "<?php echo $id; ?>";
      var update = "<?php echo $update; ?>";
      var view = "<?php echo $view; ?>";
      var dele = "<?php echo $delete; ?>";
      var activate = "<?php echo $activate; ?>";
      var ranks = "<?php echo $ranks; ?>";
      var error = "<?php echo $error; ?>";
      var add = "<?php echo $add; ?>";
      var page = "<?php echo $pageCookie; ?>";

      var username = document.getElementById('username');
      var password = document.getElementById('password');
      var lname = document.getElementById('lname');
      var fname = document.getElementById('fname');

      function newRank() {
        var divRank = document.getElementById("divRanks");
        var inputRankCount = document.getElementById("inputRankCount");
        var newRank = document.createElement("input");
        var divRankCount = divRank.childElementCount;

        inputRankCount.value = divRankCount;
        newRank.name = "newRank" + divRankCount;
        newRank.className = "form-control";
        newRank.placeholder = "Enter Rank";
        newRank.style.marginTop = "1rem";
        divRank.appendChild(newRank);  
      }

      $(document).ready(function(){
      $('#password').bind("cut copy paste",function(e) {
      e.preventDefault();
      });
      });

      function loading(){
          var loader = document.getElementById("loader");
          loader.style.display = "none";
          var pageSystem = "<?php $_SESSION['pageSystem'] = 1; ?>";

          document.getElementById("accounts").style.color = "black";
          document.getElementById("accounts").style.fontWeight = "bold";
        }

        var rank = document.getElementById("rank");

        function modifyRanks(id){
          if(rank.value == 'Modify Ranks'){
            location.href = "../accounts/?ranks=" + id;
          }
        };

      function backNewAccount(){
        location.href = "../accounts/?page=" + page + "&add=1";
      }
      
      function accountView(id){
        location.href = "../accounts/?view=" + id;
      }

      $('#addAccount').on('hidden.bs.modal', function () {
        location.href = "../accounts/?page=" + page;
      })

      $('#deleteAccount').on('hidden.bs.modal', function () {
        location.href = "../accounts/?page=" + page;
      })

      $('#activateAccount').on('hidden.bs.modal', function () {
        location.href = "../accounts/?page=" + page;
      })

      $('#modifyRanks').on('hidden.bs.modal', function () {
        location.href = "../accounts/?page=" + page;
      })

      if(error == true){
        $(window).on('load',function(){
            $('#addAccount').modal('show');
          });
      }

      if(add == true){
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

      else if(ranks == true){
        $(window).on('load',function(){
          $('#modifyRanks').modal('show');
        });
      }

      var message = "<?php if(!isset($_SESSION['message'])){ echo 'true'; }  ?>"
      var errMessage = "<?php if(!isset($_SESSION['errorMessage'])){ echo 'true'; }  ?>"
      var rankMessage = "<?php if(!isset($_SESSION['rankMessage'])){ echo 'true'; }  ?>"

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

      if($("#rankMessageAlert").length){     
          if(rankMessage == "true"){
            setInterval(function(){  
              rankDiv.style.display = "none";
            }, 3000);
          }
        }

      fname.addEventListener('input', function () {
          username.value = (lname.value + "." + this.value).toLowerCase().replace(/\s/g, "");
          password.value = (lname.value + this.value + "pnp").toLowerCase().replace(/\s/g, "");
      });

      lname.addEventListener('input', function () {
          username.value = (this.value + "." + fname.value).toLowerCase().replace(/\s/g, "");
          password.value = (this.value + fname.value + "pnp").toLowerCase().replace(/\s/g, "");
      });
      
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })

      $(document).ready(function () {
        $("#office").change(function () {
            var val = $(this).val();
          if (val == "-Select Group-") {
            document.getElementById("formGroup").style.display = "block";
            document.getElementById("group").selectedIndex = "0";
            document.getElementById("formOffice").style.display = "none";
            document.getElementById("group").required = "true";
          }
        });
      });

      $(document).ready(function () {
        $("#group").change(function () {
          var val = $(this).val();
          if (val == "Command Group") {
                $("#office").html("<option selected value=''>-Select Command Group-</option><option value='OCPNP'>OCPNP</option><option value='TDCA'>TDCA</option><option value='TDCO'>TDCO</option><option value='TDCS/SDS'>TDCS/SDS</option><option value='-Select Group-'>-Select Group-</option>");
                document.getElementById("formGroup").style.display = "none";
                document.getElementById("formOffice").style.display = "block";
            } else if (val == "P-Staff/Other Staff") {
                $("#office").html("<option selected value=''>-Select P-Staff/Other Staff-</option><option value='SILG'>SILG</option><option value='PIO'>PIO</option><option value='CPSM'>CPSM</option><option value='CESPO'>CESPO</option><option value='IAS'>IAS</option><option value='HRAO'>HRAO</option><option value='WCPC'>WCPC</option><option value='ITG(DI)'>ITG(DI)</option><option value='CITF'>CITF</option><option value='-Select Group-'>-Select Group-</option>");
                document.getElementById("formGroup").style.display = "none";
                document.getElementById("formOffice").style.display = "block";
            } else if (val == "D-Staff") {
                $("#office").html("<option selected value=''>-Select D-Staff-</option><option value='DPRM'>DPRM</option><option value='DI'>DI</option><option value='DO'>DO</option><option value='DL'>DL</option><option value='DPL'>DPL</option><option value='DC'>DC</option><option value='DPCR'>DPCR</option><option value='DIDM'>DIDM</option><option value='DHRDD'>DHRDD</option><option value='DRD'>DRD</option><option value='DICTM'>DICTM</option><option value='WM'>WM</option><option value='EM'>EM</option><option value='VIS'>VIS</option><option value='NL'>NL</option><option value='SL'>SL</option><option value='-Select Group-'>-Select Group-</option>");
                document.getElementById("formGroup").style.display = "none";
                document.getElementById("formOffice").style.display = "block";
            } else if (val == "NASU") {
                $("#office").html("<option selected value=''>-Select NASU-</option><option value='LS'>LS</option><option value='ITMS'>ITMS</option><option value='FS'>FS</option><option value='HS'>HS</option><option value='CES'>CES</option><option value='PRBS'>PRBS</option><option value='CHS'>CHS</option><option value='LSS'>LSS</option><option value='HSS'>HSS</option><option value='ES'>ES</option><option value='TS'>TS</option><option value='-Select Group-'>-Select Group-</option>");
                document.getElementById("formGroup").style.display = "none";
                document.getElementById("formOffice").style.display = "block";
            } else if (val == "NOSU") {
                $("#office").html("<option selected value=''>-Select NOSU-</option><option value='MG'>MG</option><option value='IG'>IG</option><option value='PSPG'>PSPG</option><option value='CIDG'>CIDG</option><option value='SAF'>SAF</option><option value='ACG'>ACG</option><option value='ASG'>ASG</option><option value='HPG'>HPG</option><option value='PCRG'>PCRG</option><option value='CSG'>CSG</option><option value='CLG'>CLG</option><option value='AKG'>AKG</option><option value='-Select Group-'>-Select Group-</option>");
                document.getElementById("formGroup").style.display = "none";
                document.getElementById("formOffice").style.display = "block";
            } else if (val == "NCRPO") {
                $("#office").html("<option selected value=''>-Select NCRPO-</option><option value='MPD'>MPD</option><option value='SPD'>SPD</option><option value='NPD'>NPD</option><option value='EPD'>EPD</option><option value='QCPD'>QCPD</option><option value='NCRPO'>NCRPO</option><option value='-Select Group-'>-Select Group-</option>");
                document.getElementById("formGroup").style.display = "none";
                document.getElementById("formOffice").style.display = "block";
            } else if (val == "PROs") {
                $("#office").html("<option selected value=''>-Select PROs-</option><option value='PRO1'>PRO1</option><option value='PRO2'>PRO2</option><option value='PRO3'>PRO3</option><option value='PRO4A'>PRO4A</option><option value='PRO4B'>PRO4B</option><option value='PRO5'>PRO5</option><option value='PRO6'>PRO6</option><option value='PRO7'>PRO7</option><option value='PRO8'>PRO8</option><option value='PRO9'>PRO9</option><option value='PRO10'>PRO10</option><option value='PRO11'>PRO11</option><option value='PRO12'>PRO12</option><option value='PRO13'>PRO13</option><option value='PROCOR'>PROCOR</option><option value='PROARMM'>PROARMM</option><option value='-Select Group-'>-Select Group-</option>");
                document.getElementById("formGroup").style.display = "none";
                document.getElementById("formOffice").style.display = "block";
            } else {
                $("#office").html("<option selected value=''>-Select Office/Unit-</option>");
            }
        });
    });

      </script>

    </body>
</html>



<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->