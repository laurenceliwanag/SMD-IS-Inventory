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
            <h1 align="center">Login History</h1>
            <hr>
          </div>
        </div>

           <!-----FILTERS----->
            <form action="../loginhistory/" method = "POST"  style="display: grid; justify-items: center;">
              <div class="row"  id="accountFilters" style="width: 80%;">   
                <div class="col-xl-4" style="margin-top: 1rem">
                  <div class="form-group">
                    <input type="text" name="searchValue" class="form-control" placeholder="Search Account">
                  </div> 
                </div>
                <div class="col-xl-3"  style="margin-top: 1rem">
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
                <div class="col-xl-2" style="margin-top: 1rem">
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
  
                <div class="col-xl-3">
                    <div class="form-group">
                      <button class="btn btn-outline-info" name="search"  style="margin-right: .25rem; margin-top: 1rem">Search</button>
                      <button class="btn btn-outline-info" name="clear"  style="margin-right: .25rem; margin-top: 1rem">Clear</a></button>
                    </div>
                </div>
              </div>
            </form>
        
        <hr>

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
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC") or die($mysqli->error);
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
                      
                      $result = $mysqli->query("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC LIMIT 10") or die($mysqli->error);

                      $resultString = ("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' AND authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC") or die($mysqli->error);
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

                      $result = $mysqli->query("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC LIMIT 10") or die($mysqli->error);

                      $resultString = ("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC");
                    }
                  }
                  else{
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC") or die($mysqli->error);
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

                      $result = $mysqli->query("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC LIMIT 10") or die($mysqli->error);

                      $resultString = ("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  authorityLevel = '$authorityValue' AND (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC") or die($mysqli->error);
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

                      $result = $mysqli->query("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC LIMIT 10") or die($mysqli->error);

                      $resultString = ("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  (fname LIKE '%$searchValue%' OR mname LIKE '%$searchValue%' OR lname LIKE '%$searchValue%' OR fname LIKE '%$searchValue%' OR username LIKE '%$searchValue%') ORDER BY timeIn DESC");
                    }
                  }
                }
                else{
                  if($rankValue != ""){
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' AND authorityLevel = '$authorityValue' ORDER BY timeIn DESC") or die($mysqli->error);
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

                      $result = $mysqli->query("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' AND authorityLevel = '$authorityValue' ORDER BY timeIn DESC LIMIT 10") or die($mysqli->error);

                      $resultString = ("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' AND authorityLevel = '$authorityValue' ORDER BY timeIn DESC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' ORDER BY timeIn DESC") or die($mysqli->error);
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

                      $result = $mysqli->query("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' ORDER BY timeIn DESC LIMIT 10") or die($mysqli->error);

                      $resultString = ("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  tblaccounts.rank = '$rankValue' ORDER BY timeIn DESC");
                    }
                  }
                  else{
                    if($authorityValue != ""){
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  authorityLevel = '$authorityValue' ORDER BY timeIn DESC") or die($mysqli->error);
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

                      $result = $mysqli->query("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  authorityLevel = '$authorityValue' ORDER BY timeIn DESC LIMIT 10") or die($mysqli->error);

                      $resultString = ("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id WHERE  authorityLevel = '$authorityValue' ORDER BY timeIn DESC");
                    }
                    else{
                      $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id  ORDER BY timeIn DESC") or die($mysqli->error);
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

                      $result = $mysqli->query("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id  ORDER BY timeIn DESC LIMIT 10") or die($mysqli->error);

                      $resultString = ("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id  ORDER BY timeIn DESC");
                    }
                  }
                }
              }
              else{
                $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblloginhistory ORDER BY timeIn DESC") or die($mysqli->error);
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
                  $_SESSION['page'] = $page;
                }

                $startLimit = ($page - 1) * $resultCount;

                $result = $mysqli->query("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id ORDER BY timeIn DESC LIMIT $startLimit, $resultCount") or die($mysqli->error);

                $resultString = ("SELECT tblloginhistory.id, tblloginhistory.userId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblaccounts.rank, tblaccounts.authorityLevel, tblloginhistory.timeIn, tblloginhistory.timeOut FROM tblloginhistory JOIN tblaccounts ON tblloginhistory.userId=tblaccounts.id ORDER BY timeIn DESC LIMIT $startLimit, $resultCount");
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
                <table class="table table-striped table-hover table-responsive">
                  <thead>
                    <tr>
                      <th style="width: 12vw;">First Name</th>
                      <th style="width: 12vw;">Middle Name</th>
                      <th style="width: 12vw;">Last Name</th>
                      <th style="width: 5vw;">Qualifier</th>
                      <th style="width: 15vw;">Rank</th>
                      <th style="width: 10vw;">Authority Level</th>
                      <th style="width: 12vw;">Time In</th>
                      <th style="width: 12vw;">Time Out</th>
                    </tr>
                  </thead>
            
                  <?php if($result != ""): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                      <tr ondblclick="systemView(<?php echo $row['id'] ?>)">
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
                        <td><?php echo date('Y-d-m h:i:s a', strtotime($row['timeIn'])) ?></td>
                        <td><?php if(date('Y-d-m h:i:s a', strtotime($row['timeOut'])) == '1970-01-01 01:00:00 am' || date('Y-d-m h:i:s a', strtotime($row['timeOut'])) == '1970-01-01 01:00:00 pm'){ echo '0000-00-00 00:00:00'; }else{ echo date('Y-d-m h:i:s a', strtotime($row['timeOut'])); } ?></td>
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
                        $("#divTable").load("viewMoreLogin.php", {
                          newQuery: query,
                          newDocCount: docCount
                        });
                      });
                  });
              </script>

              <form action="../loginhistory/" method="GET" id="accountsPagination">
                  <?php if(isset($_POST['search'])): ?>
                    <div class="row" style="display: grid; justify-items: center; margin-top: 1rem; <?php if($rowCount['count'] == 0 || $rowCount['count'] <= 10): ?>display: none;<?php endif; ?>" id="divViewMore">
                        <button class="btn btn-outline-primary" type="button" id="btnViewMoreFilter" style="width: 25vw;">View More</button>
                    </div>
                    <p><?php echo $rowCount['count'] ?> Search Result</p> 
                  <?php else: ?>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                      <?php if($page == '1'): ?>
                        <button disabled class="btn btn-outline-primary"><</button>
                      <?php else: ?>
                        <a href="../loginhistory/?page=<?php echo $page - 1 ?>" class="btn btn-outline-primary"><</a>
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
                          <a href="../loginhistory/?page=<?php echo $page ?>" class="btn btn-primary"><?php echo $page ?></a>
                        <?php else: ?>
                          <a href="../loginhistory/?page=<?php echo $page ?>" class="btn btn-outline-primary"><?php echo $page ?></a>
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
                        <a href="../loginhistory/?page=<?php echo $page + 1 ?>" class="btn btn-outline-primary">></a>
                      <?php endif; ?>
                      <p><?php echo $startLimit + 1?> - <?php $total = $startLimit + $resultCount; if($total < $rowCount['count']){ echo $total; } else{ echo $rowCount['count']; } ?> / <?php echo $rowCount['count'] ?></p> 
                    <?php else: ?>
                      <p>There are no login history</p>
                    <?php endif; ?>
                  <?php endif; ?>
                </form>
    
            </div>
          </div>
          
        

              

        </div>

      <script type="text/javascript">
    
        function loading(){
          var loader = document.getElementById("loader");
          loader.style.display = "none";
          var pageSystem = "<?php $_SESSION['pageSystem'] = 1; ?>";
          var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";

          document.getElementById("accounts").style.color = "black";
          document.getElementById("accounts").style.fontWeight = "bold";
        }

    

      </script>

    </body>
</html>



<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->