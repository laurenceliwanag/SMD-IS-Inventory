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

        <!---------------TITLE--------------->
        <div class="row">
          <div class="col" id="accountTitle">
            <h1 align="center">List of Systems</h1>
            <hr>
          </div>
        </div>

        <!---------------FILTERS---------------> 
        <form action="../systems/" method="POST" style="display: grid; justify-items: center;">
          <div class="row" id="systemFilters" style="width: 70%;">
            <div class="col-xl-6" style="margin-top: 1rem;">
              <div class="form-group">
                <input type="text" name="searchValue" class="form-control" placeholder="Search Information System">
              </div> 
            </div>
            <div class="col-xl-3" style="margin-top: 1rem">
              <div class="form-group">
                <select class="custom-select" name="statusValue">
                  <option value="" selected>-Select IS Status-</option>
                  <option value="">All</option>
                  <option value="Operational">Operational</option>
                  <option value="Non-Operational">Non-Operational</option>
                  <option value="For Development">For Development</option>
                  <option value="For Enhancement">For Enhancement</option>
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

        <?php if($_SESSION['authorityLevel'] == 'admin' || $_SESSION['authorityLevel'] == 'researcher'): ?> 
          <div class="row">   
            <!---------------MESSAGES ALERT--------------->
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
      
            <!---------------BUTTONS--------------->
            <div class="col-2" id="accountButtons">
              <button id="addAccountButton" type="button" class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#addAccount"><image src="../images/addsystem.png" height="20" width="22" style="float: left; margin-top: 3px; margin-right: .5vw; margin-left: .4vw;"></image><a class="d-none d-lg-block">ADD SYSTEM</a></button>
            </div>
          </div>
        <?php endif; ?>
          
        <!---------------ACCOUNT TABLE--------------->
        <div class="row">
          <div class="col" id="accountTable">
            <?php 
              require '../connection.php';
              $userId = $_SESSION['userId'];

              if(isset($_POST['search'])){
                $searchValue = $_POST['searchValue'];
                $statusValue = $_POST['statusValue'];

                if($searchValue != ""){
                  if($statusValue != ""){
                    $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND statusIS = '$statusValue' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC") or die($mysqli->error);
                    $rowCount = $result1->fetch_assoc();
                    $resultCount = 10;
                    $pageNumber = ceil($rowCount['count'] / $resultCount);
      
                    if(!isset($_GET['page'])){
                      $page = 1;  
                    }
                    else{
                      $page = $_GET['page'];
                      $_SESSION['pageSystem'] = $page;
                    }
      
                    $startLimit = ($page - 1) * $resultCount;
      
                    $result = $mysqli->query("SELECT * FROM tblsystems WHERE status != 'inactive' AND statusIS = '$statusValue' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC LIMIT 10") or die($mysqli->error);
                    $resultString = ("SELECT * FROM tblsystems WHERE status != 'inactive' AND statusIS = '$statusValue' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC");
                  }
                  else{
                    $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC") or die($mysqli->error);
                    $rowCount = $result1->fetch_assoc();
                    $resultCount = 10;
                    $pageNumber = ceil($rowCount['count'] / $resultCount);
      
                    if(!isset($_GET['page'])){
                      $page = 1;
                    }
                    else{
                      $page = $_GET['page'];
                      $_SESSION['pageSystem'] = $page;
                    }

                    $startLimit = ($page - 1) * $resultCount;
      
                    $result = $mysqli->query("SELECT * FROM tblsystems WHERE status != 'inactive' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC LIMIT 10") or die($mysqli->error);
                    $resultString = ("SELECT * FROM tblsystems WHERE status != 'inactive' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC");
                  }
                }
                else{
                  if($statusValue != ""){
                    $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND statusIS = '$statusValue' ORDER BY name ASC") or die($mysqli->error);
                    $rowCount = $result1->fetch_assoc();
                    $resultCount = 10;
                    $pageNumber = ceil($rowCount['count'] / $resultCount);
      
                    if(!isset($_GET['page'])){
                      $page = 1;
                    }
                    else{
                      $page = $_GET['page'];
                      $_SESSION['pageSystem'] = $page;
                    }
      
                    $startLimit = ($page - 1) * $resultCount;
      
                    $result = $mysqli->query("SELECT * FROM tblsystems WHERE status != 'inactive' AND statusIS = '$statusValue' ORDER BY name ASC LIMIT 10") or die($mysqli->error);
                    $resultString = ("SELECT * FROM tblsystems WHERE status != 'inactive' AND statusIS = '$statusValue' ORDER BY name ASC");
                  }
                  else{
                    $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                    $rowCount = $result1->fetch_assoc();
                    $resultCount = 10;
                    $pageNumber = ceil($rowCount['count'] / $resultCount);
      
                    if(!isset($_GET['page'])){
                      $page = 1; 
                    }
                    else{
                      $page = $_GET['page'];
                      $_SESSION['pageSystem'] = $page;
                    }
      
                    $startLimit = ($page - 1) * $resultCount;
      
                    $result = $mysqli->query("SELECT * FROM tblsystems WHERE status != 'inactive' ORDER BY name ASC LIMIT 10") or die($mysqli->error);
                    $resultString = ("SELECT * FROM tblsystems WHERE status != 'inactive' ORDER BY name ASC");
                  }
                }
              }
              else{
                $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                $rowCount = $result1->fetch_assoc();
                $resultCount = 10;
                $pageNumber = ceil($rowCount['count'] / $resultCount);

                if(!isset($_GET['page'])){
                  $page = 1; 
                }
                else{
                  $page = $_GET['page'];
                  $_SESSION['pageSystem'] = $page;
                }

                $startLimit = ($page - 1) * $resultCount;

                $result = $mysqli->query("SELECT * FROM tblsystems WHERE status != 'inactive' ORDER BY name ASC LIMIT $startLimit, $resultCount") or die($mysqli->error);
                $resultString = ("SELECT * FROM tblsystems WHERE status != 'inactive' ORDER BY name ASC LIMIT $startLimit, $resultCount");
              }
            ?>

            <?php if(isset($_POST['search'])): ?>
              <p align="center"><strong>Keyword Searched: </strong> <?php echo $searchValue . " | "; ?><strong>Status of IS: </strong> <?php echo $statusValue; ?></p>
            <?php endif; ?>
            <p align="center" ><strong>Total No. of Information Systems: </strong> <?php echo mysqli_num_rows($result); ?></p>
              
            <div id="divTable">
              <table class="table table-striped table-hover table-responsive">
                <thead>
                  <tr>
                    <th></th>
                    <th style="width: 20vw;">Name of IS</th>
                    <th style="width: 5vw;">Office</th>
                    <th style="width: 20vw;">Description</th>
                    <th style="width: 8vw;">Source</th>
                    <th style="width: 8vw;">Type of IS</th> 
                    <th style="width: 8vw;">Status of IS</th>
                    <th style="width: 16vw;" class="action">Action</th>
                  </tr>
                </thead>

                <?php if($result != ""):?>
                  <?php while($row = $result->fetch_assoc()): ?>
                    <tr ondblclick="systemView(<?php echo $row['id'] ?>)">
                      <?php if($row['logo'] == ''): ?>
                        <td><img src="../images/logo-pnp.png" height="50" width="50"></td>
                      <?php else: ?>
                        <td><img src="../images/system logo/<?php echo $row['logo'];?>" height="50" width="50"></td>
                      <?php endif; ?>
                      <td><?php echo $row['name'] ?></td>
                      <td><?php echo $row['office'] ?></td>
                      <td align="justify"><?php echo $row['description'] ?></td>
                      <td><?php echo $row['source'] ?></td>
                      <td><?php echo ucwords($row['typeIS']) ?></td>
                      <td><?php echo $row['statusIS'] ?></td>
                      <td class="action">

                      <?php
                        $resultResearchers = $mysqli->query("SELECT * FROM tblresearchers") or die($mysqli->error);
                        
                       ?>
                        <form action="../systems/" method="POST">
                          <a href="?view=<?php echo $row['id']; ?>" class="btn btn-success" id="btnView" data-toggle="tooltip" data-placement="top" title="View" style="margin-top: .4rem;"><image src="../images/view.png" height="20" width="20"></image></a>          
                          <?php if($_SESSION['authorityLevel'] == 'admin'): ?>
                            <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-info" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Edit" style="margin-top: .4rem;"><image src="../images/edit.png" height="20" width="20"></image></a>
                          <?php endif; ?>

                          <?php while($rowResearchers = $resultResearchers->fetch_assoc()): ?>
                            <?php if($_SESSION['authorityLevel'] == 'researcher' && $_SESSION['userId'] == $rowResearchers['accountId'] && $row['id'] == $rowResearchers['systemId']): ?>  
                              <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-info" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Edit" style="margin-top: .4rem;"><image src="../images/edit.png" height="20" width="20"></image></a>
                              <?php break; ?>
                            <?php else: ?> 

                            <?php endif; ?>
                          <?php endwhile; ?>

                          <?php if($_SESSION['authorityLevel'] == 'admin'): ?>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger" id="btnDelete" data-toggle="tooltip" data-placement="top" title="Delete" style="margin-top: .4rem;"><image src="../images/delete.png" height="20" width="20"></image></a>
                          <?php else: ?> 

                          <?php endif; ?>     
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
                  $("#divTable").load("viewMoreSystem.php", {
                    newQuery: query,
                    newDocCount: docCount
                  });
                });
              });
            </script>

            <?php if($_SESSION['authorityLevel'] == 'admin'): ?>
              <div class="row">
                <div class="col">
                  <a href="../deleted/" class="btn btn-link" name="deleted" style="float: right; margin: 0; padding: 0;">Deleted Systems</a>
                </div>
              </div>
            <?php else: ?> 

            <?php endif; ?> 
              
            <form action="../systems/" method="GET" id="accountsPagination">
              <?php if(isset($_POST['search'])): ?>
                <div class="row" style="display: grid; justify-items: center; margin-top: 1rem; <?php if($rowCount['count'] == 0 || $rowCount['count'] <= 10): ?>display: none;<?php endif; ?>" id="divViewMoreFilter">
                  <button class="btn btn-outline-primary" type="button" id="btnViewMoreFilter" style="width: 30vw;">View More</button>
                </div>
                <p><?php echo $rowCount['count'] ?> Search Result</p> 
              <?php else: ?>
                <?php if(mysqli_num_rows($result) > 0): ?>
                  <?php if($page == '1'): ?>
                    <button disabled class="btn btn-outline-primary"><</button>
                  <?php else: ?>
                    <a href="../systems/?page=<?php echo $page - 1 ?>" class="btn btn-outline-primary"><</a>
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
                      <a href="../systems/?page=<?php echo $page ?>" class="btn btn-primary"><?php echo $page ?></a>
                    <?php else: ?>
                      <a href="../systems/?page=<?php echo $page ?>" class="btn btn-outline-primary"><?php echo $page ?></a>
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
                    <a href="../systems/?page=<?php echo $page + 1 ?>" class="btn btn-outline-primary">></a>
                  <?php endif; ?>
                  <p><?php echo $startLimit + 1?> - <?php $total = $startLimit + $resultCount; if($total < $rowCount['count']){ echo $total; } else{ echo $rowCount['count']; } ?> / <?php echo $rowCount['count'] ?></p> 
                <?php else: ?>
                  <p>There are no existing systems</p>
                <?php endif; ?>
              <?php endif; ?>
            </form>
          </div>
        </div>
          
        <!---------------MODAL--------------->
        <div class="modal fade" id="addAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog <?php if($view == true): ?> modal-xxl <?php else: ?> modal-xl <?php endif; ?>" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <img src="../images/logo-itms.png" height="30" width="30" alt="" style="margin-left: .7vw;">
                <?php if($view == true): ?>
                  <h5 class="modal-title ml-auto">System Information</h5>
                <?php elseif($update == true): ?>
                  <h5 class="modal-title ml-auto">Edit System</h5>
                <?php else: ?> 
                  <h5 class="modal-title ml-auto">Add System</h5>
                <?php endif; ?>
                <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
              </div>

              <?php if($view == true): ?>
                <form action="process.php" method="POST">
                  <div class="modal-body" style="margin-left: 2vw; margin-right: 2vw;" id="modalBody">
                    <div class="row">
                      <?php if($logo == ''): ?>
                        <div class="col" style="display: grid; align-items: center;">
                          <div class="input-group mr-sm-2" id="systemLogo">
                            <img src="../images/logo-pnp.png" style="height: 13rem; width: 13rem;" alt=""> 
                          </div>
                        </div>
                      <?php else: ?>
                        <div class="col" style="display: grid; align-items: center;">
                          <div class="input-group mr-sm-2" id="systemLogo">
                            <img src="../images/system logo/<?php echo $logo ?>" style="height: 13rem; width: 13rem;" alt=""> 
                          </div>
                        </div>
                      <?php endif; ?>
                    </div>

                    <div class="row">
                      <div class="col">
                        <h4 align="center" style="font-weight: bold"><?php echo $name; ?></h4>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <h5 align="center"><?php echo $office; ?></h5>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-9">
                        <label style="font-weight: bold;">IT Officer/Personnel :</label>
                        <h6><?php preg_match('#\((.*?)\)#', $itOfficerRank, $rankAcronym); if(!empty($rankAcronym)){ $rankAcronym[0] = str_replace("(", "", $rankAcronym[0]); $rankAcronym[0] = str_replace(")", "", $rankAcronym[0]); echo $rankAcronym[0]; }else{ echo $itOfficerRank; } echo ' ' . $itOfficer; if($itOfficerEmail != ''){ echo ' - '; } echo $itOfficerEmail;if($itOfficerContact != ''){ echo ' - '; }echo $itOfficerContact; ?></h6>
                      </div>
                      <div class="col">
                  
                      </div>
                      <div class="col">
                     
                      </div>
                      <div class="col">
                          
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Description :</label>
                        <h6 align="justify"><?php echo $description; ?></h6>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Environment :</label>
                        <h6><?php echo $environment ; ?></h6>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Application Functionality :</label>
                        <h6><?php echo $appFunction ; ?></h6>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Operating System :</label>
                        <h6><?php echo $operatingSystem ; ?></h6>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Development Tool :</label>
                        <h6><?php echo $devTool; ?></h6>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Back-End :</label>
                        <h6><?php echo $backEnd; ?></h6>
                      </div>   
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Total No. of Records :</label>
                        <h6><?php echo $numRecords; ?></h6>
                      </div>   
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Database Security :</label>
                        <h6><?php echo $dbSecurity; ?></h6>
                      </div>  
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Source :</label>
                        <h6><?php echo $source; ?></h6>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">With Contract :</label>
                        <h6><?php echo ucwords($withContract) ?></h6>
                      </div>
                      <div class="col" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">DICTM Certified :</label>
                        <h6><?php echo ucwords($dictmCertified); ?></h6>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Type of IS :</label>
                        <h6><?php echo $typeIS; ?></h6>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Status of IS :</label>
                        <h6><?php echo $statusIS; ?></h6>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">System Document :</label>
                        <h6><?php echo ucwords($withContract) ?></h6>
                      </div>
                      <div class="col" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">User Manual :</label>
                        <h6><?php echo ucwords($dictmCertified); ?></h6>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">User Acceptance :</label>
                        <h6><?php echo ucwords($userAcceptance); ?></h6>
                      </div>
                      <div class="col">
                          
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Remarks :</label>
                        <h6 align="justify"><?php echo $remarks; ?></h6>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-9" style="margin-top: 1rem;">
                        <label style="font-weight: bold;">Developed By :</label>
                        <h6><?php echo $developedBy; if($developedByEmail != ''){ echo ' - '; } echo $developedByEmail; if($developedByContact != ''){ echo ' - '; }echo $developedByContact; ?></h6>
                      </div>
                      <div class="col">
                    
                      </div>
                      <div class="col">
                      
                      </div>
                      <div class="col">
                            
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Date Initiated :</label>
                        <?php if($dateInitiated == ''): ?>
                          <h6 style="margin-left: 3rem;"><?php echo '-' ?></h6>
                        <?php else: ?>
                          <h6><?php echo ucwords($dateInitiated) ?></h6>
                        <?php endif; ?>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Development Date :</label>
                        <?php if($developmentDate == ''): ?>
                          <h6 style="margin-left: 3rem;"><?php echo '-' ?></h6>
                        <?php else: ?>
                          <h6><?php echo ucwords($developmentDate) ?></h6>
                        <?php endif; ?>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Turn-Over Date :</label>
                        <?php if($turnOverDate == ''): ?>
                          <h6 style="margin-left: 3rem;"><?php echo '-' ?></h6>
                        <?php else: ?>
                          <h6><?php echo ucwords($turnOverDate) ?></h6>
                        <?php endif; ?>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label  style="font-weight: bold;">Implementation Date :</label>
                        <?php if($implementDate == ''): ?>
                          <h6 style="margin-left: 4rem;"><?php echo '-' ?></h6>
                        <?php else: ?>
                          <h6><?php echo ucwords($implementDate) ?></h6>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md" style="margin-top: 1rem;">
                        <label style="font-weight: bold;">Year Last Cleansed :</label>
                        <h6><?php echo $cleansedDate; ?></h6>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label style="font-weight: bold;">Date Added :</label>
                        <h6><?php echo $dateAdded; ?></h6>
                      </div>
                      <div class="col-md" style="margin-top: 1rem;">
                        <label style="font-weight: bold;">Prepared By :</label>
                        <h6><?php echo $preparedBy; ?></h6>
                      </div>
                      <div class="col">
                            
                      </div>
                    </div>

                    <script>                   
                      $(document).ready(function(){
                        var folder = "";
                        var id = "<?php echo $id; ?>";
                        var docCount = 8;
                        $("#folderSOA").click(function(){
                          folder = "Schedule of Activities";
                          var div = document.getElementById("divViewMore");
                          var btn = document.createElement('button');

                          btn.innerHTML = "View More";
                          btn.type = "button";
                          btn.className = "btn btn-outline-primary";
                          btn.style.width = "30vw";
                          
                          btn.onclick = function(){             
                            docCount = docCount + 8;
                            $("#divDocuments").load("viewMoreDoc1.php", {
                              newFolder: folder,
                              systemId: id,
                              newDocCount: docCount
                            });
                          }

                          if (div.hasChildNodes()){
                            div.removeChild(div.childNodes[0]);
                          }
                          div.append(btn);

                          $("#divDocuments").load("viewFolder.php", {
                            newFolder: folder,
                            systemId: id
                          });

                          var docFoldersSOA = document.getElementById("docFoldersSOA");
                          var docFoldersIOC = document.getElementById("docFoldersIOC");
                          var docFoldersCN = document.getElementById("docFoldersCN");
                          var docFoldersDocument = document.getElementById("docFoldersDocument");
                          var docFoldersReference = document.getElementById("docFoldersReference");

                          docFoldersSOA.style.background = "white";
                          docFoldersSOA.style.color = "#007bff";

                          if(docFoldersSOA.style.background == "white"){
                            docFoldersIOC.style.background = "#007bff";
                            docFoldersCN.style.background = "#007bff";
                            docFoldersDocument.style.background = "#007bff";
                            docFoldersReference.style.background = "#007bff";

                            docFoldersIOC.style.color = "white";
                            docFoldersCN.style.color = "white";
                            docFoldersDocument.style.color = "white";
                            docFoldersReference.style.color = "white";

                            docFoldersIOC.style.borderRadius = "10px 10px 0px 10px";
                            docFoldersCN.style.borderRadius = "10px 10px 0px 0px";
                            docFoldersDocument.style.borderRadius = "10px 10px 0px 0px";
                            docFoldersReference.style.borderRadius = "10px 10px 0px 0px";   

                            docFoldersSOA.style.borderRight = "none"; 

                            docFoldersIOC.style.borderRight = "1px solid white"; 
                            docFoldersIOC.style.borderLeft = "1px solid white"; 
                            docFoldersCN.style.borderRight = "1px solid white"; 
                            docFoldersCN.style.borderLeft = "1px solid white"; 
                            docFoldersDocument.style.borderRight = "1px solid white"; 
                            docFoldersDocument.style.borderLeft = "1px solid white"; 
                            docFoldersReference.style.borderLeft = "1px solid white"; 

                          }
                        });
                      });

                      $(document).ready(function(){
                        var folder = "";
                        var id = "<?php echo $id; ?>";
                        var docCount = 8;
                        $("#folderIOC").click(function(){
                          folder = "Incoming/Outgoing Communications";
                          var div = document.getElementById("divViewMore");
                          var btn = document.createElement('button');

                          btn.innerHTML = "View More";
                          btn.type = "button";
                          btn.className = "btn btn-outline-primary";
                          btn.style.width = "30vw";
                          
                          btn.onclick = function(){             
                            docCount = docCount + 8;
                            $("#divDocuments").load("viewMoreDoc1.php", {
                              newFolder: folder,
                              systemId: id,
                              newDocCount: docCount
                            });
                          }
                              
                          if (div.hasChildNodes()){
                            div.removeChild(div.childNodes[0]);
                          }
                          div.append(btn);

                          $("#divDocuments").load("viewFolder.php", {
                            newFolder: folder,
                            systemId: id
                          });

                          var docFoldersSOA = document.getElementById("docFoldersSOA");
                          var docFoldersIOC = document.getElementById("docFoldersIOC");
                          var docFoldersCN = document.getElementById("docFoldersCN");
                          var docFoldersDocument = document.getElementById("docFoldersDocument");
                          var docFoldersReference = document.getElementById("docFoldersReference");

                          docFoldersIOC.style.background = "white";
                          docFoldersIOC.style.color = "#007bff";

                          if(docFoldersIOC.style.background == "white"){
                            docFoldersSOA.style.background = "#007bff";
                            docFoldersCN.style.background = "#007bff";
                            docFoldersDocument.style.background = "#007bff";
                            docFoldersReference.style.background = "#007bff";

                            docFoldersSOA.style.color = "white";
                            docFoldersCN.style.color = "white";
                            docFoldersDocument.style.color = "white";
                            docFoldersReference.style.color = "white";
                           
                            docFoldersSOA.style.borderRadius = "10px 10px 10px 0px";
                            docFoldersCN.style.borderRadius = "10px 10px 0px 10px";
                            docFoldersDocument.style.borderRadius = "10px 10px 0px 0px";
                            docFoldersReference.style.borderRadius = "10px 10px 0px 0px";

                            docFoldersIOC.style.borderLeft = "none";
                            docFoldersIOC.style.borderRight = "none";

                            docFoldersSOA.style.borderRight = "1px solid white";
                            docFoldersCN.style.borderLeft = "1px solid white";
                            docFoldersCN.style.borderRight = "1px solid white";
                            docFoldersDocument.style.borderLeft = "1px solid white";
                            docFoldersDocument.style.borderRight = "1px solid white";
                            docFoldersReference.style.borderLeft = "1px solid white";
                          }
                        });
                      });

                      $(document).ready(function(){
                        var folder = "";
                        var id = "<?php echo $id; ?>";
                        var docCount = 8;
                        $("#folderCN").click(function(){
                          folder = "Conference Notice/AAR";
                          var div = document.getElementById("divViewMore");
                          var btn = document.createElement('button');

                          btn.innerHTML = "View More";
                          btn.type = "button";
                          btn.className = "btn btn-outline-primary";
                          btn.style.width = "30vw";
                          
                          btn.onclick = function(){             
                            docCount = docCount + 8;
                            $("#divDocuments").load("viewMoreDoc1.php", {
                              newFolder: folder,
                              systemId: id,
                              newDocCount: docCount
                            });
                          }

                          if (div.hasChildNodes()){
                            div.removeChild(div.childNodes[0]);
                          }
                          div.append(btn);

                          $("#divDocuments").load("viewFolder.php", {
                            newFolder: folder,
                            systemId: id
                          });

                          var docFoldersSOA = document.getElementById("docFoldersSOA");
                          var docFoldersIOC = document.getElementById("docFoldersIOC");
                          var docFoldersCN = document.getElementById("docFoldersCN");
                          var docFoldersDocument = document.getElementById("docFoldersDocument");
                          var docFoldersReference = document.getElementById("docFoldersReference");

                          docFoldersCN.style.background = "white";
                          docFoldersCN.style.color = "#007bff";

                          if(docFoldersCN.style.background == "white"){
                            docFoldersSOA.style.background = "#007bff";
                            docFoldersIOC.style.background = "#007bff";
                            docFoldersDocument.style.background = "#007bff";
                            docFoldersReference.style.background = "#007bff";
                           
                            docFoldersSOA.style.color = "white";
                            docFoldersIOC.style.color = "white";
                            docFoldersDocument.style.color = "white";
                            docFoldersReference.style.color = "white";

                            docFoldersIOC.style.borderRadius = "10px 10px 10px 0px";
                            docFoldersDocument.style.borderRadius = "10px 10px 0px 10px";
                            docFoldersReference.style.borderRadius = "10px 10px 0px 0px";
                            docFoldersSOA.style.borderRadius = "10px 10px 0px 0px";

                            docFoldersCN.style.borderLeft = "none";
                            docFoldersCN.style.borderRight = "none";

                            
                            docFoldersIOC.style.borderLeft = "1px solid white";
                            docFoldersIOC.style.borderRight = "1px solid white";
                            docFoldersDocument.style.borderLeft = "1px solid white";
                            docFoldersDocument.style.borderRight = "1px solid white";
                            docFoldersReference.style.borderLeft = "1px solid white";
                            docFoldersSOA.style.borderRight = "1px solid white";
                          }
                        });
                      });

                      $(document).ready(function(){
                        var folder = "";
                        var id = "<?php echo $id; ?>";
                        var docCount = 8;
                        $("#folderDocument").click(function(){
                          folder = "Documentation";
                          var div = document.getElementById("divViewMore");
                          var btn = document.createElement('button');

                          btn.innerHTML = "View More";
                          btn.type = "button";
                          btn.className = "btn btn-outline-primary";
                          btn.style.width = "30vw";
                          
                          btn.onclick = function(){        
                            docCount = docCount + 8;
                            $("#divDocuments").load("viewMoreDoc1.php", {
                              newFolder: folder,
                              systemId: id,
                              newDocCount: docCount
                            });
                          }

                          if (div.hasChildNodes()){
                            div.removeChild(div.childNodes[0]);
                          }
                          div.append(btn);

                          $("#divDocuments").load("viewFolder.php", {
                            newFolder: folder,
                            systemId: id
                          });

                          var docFoldersSOA = document.getElementById("docFoldersSOA");
                          var docFoldersIOC = document.getElementById("docFoldersIOC");
                          var docFoldersCN = document.getElementById("docFoldersCN");
                          var docFoldersDocument = document.getElementById("docFoldersDocument");
                          var docFoldersReference = document.getElementById("docFoldersReference");

                          docFoldersDocument.style.background = "white";
                          docFoldersDocument.style.color = "#007bff";

                          if(docFoldersDocument.style.background == "white"){
                            docFoldersSOA.style.background = "#007bff";
                            docFoldersIOC.style.background = "#007bff";
                            docFoldersCN.style.background = "#007bff";
                            docFoldersReference.style.background = "#007bff";

                            docFoldersSOA.style.color = "white";
                            docFoldersIOC.style.color = "white";
                            docFoldersCN.style.color = "white";
                            docFoldersReference.style.color = "white";

                            docFoldersCN.style.borderRadius = "10px 10px 10px 0px";
                            docFoldersReference.style.borderRadius = "10px 10px 0px 10px";
                            docFoldersIOC.style.borderRadius = "10px 10px 0px 0px";
                            docFoldersSOA.style.borderRadius = "10px 10px 0px 0px";

                            docFoldersDocument.style.borderLeft = "none";
                            docFoldersDocument.style.borderRight = "none";

                            docFoldersCN.style.borderLeft = "1px solid white";
                            docFoldersCN.style.borderRight = "1px solid white";
                            docFoldersReference.style.borderLeft = "1px solid white";
                            docFoldersIOC.style.borderLeft = "1px solid white";
                            docFoldersIOC.style.borderRight = "1px solid white";
                            docFoldersSOA.style.borderRight = "1px solid white";
                          }

                        });
                      });

                      $(document).ready(function(){
                        var folder = "";
                        var id = "<?php echo $id; ?>";
                        var docCount = 8;
                        $("#folderReference").click(function(){
                          folder = "References";
                          var div = document.getElementById("divViewMore");
                          var btn = document.createElement('button');

                          btn.innerHTML = "View More";
                          btn.type = "button";
                          btn.className = "btn btn-outline-primary";
                          btn.style.width = "30vw";
                          
                          btn.onclick = function(){             
                            docCount = docCount + 8;
                            $("#divDocuments").load("viewMoreDoc1.php", {
                              newFolder: folder,
                              systemId: id,
                              newDocCount: docCount
                            });
                          }

                          if (div.hasChildNodes()){
                            div.removeChild(div.childNodes[0]);
                          }   
                          div.append(btn);

                          $("#divDocuments").load("viewFolder.php", {
                            newFolder: folder,
                            systemId: id
                          });

                          var docFoldersSOA = document.getElementById("docFoldersSOA");
                          var docFoldersIOC = document.getElementById("docFoldersIOC");
                          var docFoldersCN = document.getElementById("docFoldersCN");
                          var docFoldersDocument = document.getElementById("docFoldersDocument");
                          var docFoldersReference = document.getElementById("docFoldersReference");

                          docFoldersReference.style.background = "white";
                          docFoldersReference.style.color = "#007bff";

                          if(docFoldersReference.style.background == "white"){
                            docFoldersSOA.style.background = "#007bff";
                            docFoldersIOC.style.background = "#007bff";
                            docFoldersCN.style.background = "#007bff";
                            docFoldersDocument.style.background = "#007bff";

                            docFoldersSOA.style.color = "white";
                            docFoldersIOC.style.color = "white";
                            docFoldersCN.style.color = "white";
                            docFoldersDocument.style.color = "white";

                            docFoldersDocument.style.borderRadius = "10px 10px 10px 0px";
                            docFoldersSOA.style.borderRadius = "10px 10px 0px 0px";
                            docFoldersIOC.style.borderRadius = "10px 10px 0px 0px";
                            docFoldersCN.style.borderRadius = "10px 10px 0px 0px";      

                            docFoldersReference.style.borderLeft = "none";

                            docFoldersDocument.style.borderLeft = "1px solid white";
                            docFoldersDocument.style.borderRight = "1px solid white";

                            docFoldersSOA.style.borderRight = "1px solid white";
                            docFoldersIOC.style.borderLeft = "1px solid white";
                            docFoldersIOC.style.borderRight = "1px solid white";
                            docFoldersCN.style.borderLeft = "1px solid white";
                            docFoldersCN.style.borderRight = "1px solid white";
                          }
                        });
                      });
                    </script>        

                    <?php if($_SESSION['authorityLevel'] == 'admin' || $_SESSION['authorityLevel'] == 'researcher' ): ?>
                      <div class="row" id="folders">
                        <div class="col-xl" style="margin-top: 1rem;">
                          <label style="font-weight: bold;">Attached Documents :</label>
                        </div>           
                      </div>
                      <div class="row" style="padding-left: 1rem; padding-right: 1rem;">
                        <div class="col-xl" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderSOA">
                            <div id="docFoldersSOA">
                              Schedule of Activities
                            </div>
                          </a>
                        </div>
                        <div class="col-xl-3" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderIOC">
                            <div id="docFoldersIOC">
                              Incoming/Outgoing Communications
                            </div>
                          </a>
                        </div>
                        <div class="col-xl" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderCN">
                            <div id="docFoldersCN">
                              Conference Notice/AAR
                            </div>
                          </a>
                        </div>
                        <div class="col-xl-2" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderDocument">
                            <div id="docFoldersDocument">
                            Documentation
                            </div>
                          </a>
                        </div>
                        <div class="col-xl-2" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderReference">
                            <div id="docFoldersReference">
                              References
                            </div>
                          </a>
                        </div>
                      </div> 
                      <div class="row" id="divDocuments" style="margin-top: 1rem;">
                      
                      </div>
                      <div class="row" style="display: grid; justify-items: center; display:none;" id="divViewMore">
                    
                      </div>
                    <?php endif; ?>
                      
                    <?php if($_SESSION['authorityLevel'] == 'user' && $_SESSION['office'] == $office ): ?>
                    <div class="row" id="folders">
                        <div class="col-xl" style="margin-top: 1rem;">
                          <label style="font-weight: bold;">Attached Documents :</label>
                        </div>           
                      </div>
                      <div class="row" style="padding-left: 1rem; padding-right: 1rem;">
                        <div class="col-xl" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderSOA">
                            <div id="docFoldersSOA">
                              Schedule of Activities
                            </div>
                          </a>
                        </div>
                        <div class="col-xl-3" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderIOC">
                            <div id="docFoldersIOC">
                              Incoming/Outgoing Communications
                            </div>
                          </a>
                        </div>
                        <div class="col-xl" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderCN">
                            <div id="docFoldersCN">
                              Conference Notice/AAR
                            </div>
                          </a>
                        </div>
                        <div class="col-xl-2" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderDocument">
                            <div id="docFoldersDocument">
                            Documentation
                            </div>
                          </a>
                        </div>
                        <div class="col-xl-2" style="text-align: center; padding: 0;">
                          <a href="#divDocuments" id="folderReference">
                            <div id="docFoldersReference">
                              References
                            </div>
                          </a>
                        </div>
                      </div> 
                      <div class="row" id="divDocuments" style="margin-top: 1rem;">
                      
                      </div>
                      <div class="row" style="display: grid; justify-items: center; display:none;" id="divViewMore">
                    
                      </div>
                    <?php endif; ?>
                  </div>

                  <div class="modal-footer"> 
                    <?php if($_SESSION['authorityLevel'] == 'admin' || $_SESSION['authorityLevel'] == 'researcher'): ?>
                      <a href="?edit=<?php echo $id; ?>" class="btn btn-info" id="btnEdit">Edit</a>
                    <?php endif; ?>
                    <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="btn btn-danger">Close</a>
                  </div>
                </form>

                <?php else: ?>
                  <form action="process.php" method="POST" enctype="multipart/form-data">
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
                      <div class="row">
                        <div class="col-xl">
                          <div class="form-group">
                            <strong><label for="name">NAME OF IS</label></strong>
                            <strong><label style ="color: red;">*</label></strong>
                            <textarea style="height: 7.5rem;" type="text" name="name" class="form-control" rows="5" id="name" placeholder="Enter Name of IS" pattern="[a-zA-Z 0-9()-]{1,255}" title="Letters and Numbers only"  required><?php if(!isset($_COOKIE["name"])){echo $name;}else{echo $_COOKIE["name"]; setcookie("name", "");} ?></textarea>
                          </div>
                        </div>
                        <div class="col-xl">
                          <div class="row">
                            <div class="col-xl">
                              <div class="form-group">
                                <strong><label for="file">SYSTEM LOGO</label></strong>
                                <div class="custom-file">  
                                    <input type="file" class="custom-file-input" name="file" id="inputLogo" accept=".png, .jpg, .jpeg" aria-describedby="inputGroupFileAddon04">
                                    <?php if($logo == ''): ?>
                                      <label class="custom-file-label" for="inputLogo">Choose File</label>
                                    <?php else: ?>
                                      <label class="custom-file-label" for="inputLogo"><?php echo $logo ?></label>
                                    <?php endif; ?>
                                </div>
                              </div>
                            </div> 
                          </div>
                          <div class="row">
                            <div class="col-xl">
                                <div class="form-group" id="formGroup" <?php if($office != ""): ?>style="display: none;"<?php endif; ?>>
                                  <strong><label for="group">GROUPS</label></strong>
                                  <strong><label style ="color: red;">*</label></strong>
                                  <select class="custom-select" name="group" id="group" <?php if($office == ''): ?>required<?php endif; ?>>
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
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col">
                          <div class="row">
                            <div class="col-xl-5">
                              <div class="form-group">
                                <strong><label for="itOfficer">IT OFFICER/PERSONNEL</label></strong>
                                <strong><label style ="color: red;">*</label></strong>
                                <select class="custom-select" id="rank" name="rank" required onchange="modifyRanks(<?php echo $id ?>)">
                                  <?php if($itOfficerRank == ''): ?>
                                    <?php if(isset($_COOKIE['itOfficerRank'])): ?>
                                      <?php 
                                        $itOfficerRank = $_COOKIE['itOfficerRank'];
                                        setcookie("itOfficerRank", "");
                                        $result = $mysqli->query("SELECT * FROM tblranks WHERE id != '$itOfficerRank'") or die($mysqli->error());
                                        $resultSelected = $mysqli->query("SELECT * FROM tblranks WHERE id = '$itOfficerRank'") or die($mysqli->error());
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
                                      $result = $mysqli->query("SELECT * FROM tblranks WHERE id != '$itOfficerRank'") or die($mysqli->error());
                                      $resultSelected = $mysqli->query("SELECT * FROM tblranks WHERE id = '$itOfficerRank'") or die($mysqli->error());
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
                              <div class="form-group">
                                <strong><label for="itOfficerContact" style="visibility: hidden">IT OFFICER/PERSONNEL NAME</label></strong>
                                <input type="text" name="itOfficer" class="form-control" placeholder="Enter Name" pattern="[a-zA-Z 0-9.]{1,30}" title="Letters and Numbers only" required value="<?php if(!isset($_COOKIE["itOfficer"])){echo $itOfficer;}else{echo $_COOKIE["itOfficer"]; setcookie("itOfficer", "");} ?>">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-3">
                          <div class="form-group">
                            <strong><label for="itOfficerContact" style="visibility: hidden">IT OFFICER/PERSONNEL CONTACT</label></strong>
                            <input type="text" name="itOfficerContact" class="form-control" placeholder="Enter Contact No." pattern="[0-9]{1,11}" title="Numbers only" value="<?php if(!isset($_COOKIE["itOfficerContact"])){echo $itOfficerContact;}else{echo $_COOKIE["itOfficerContact"]; setcookie("itOfficerContact", "");} ?>">
                          </div>
                        </div>
                        <div class="col-xl-3">
                          <div class="form-group">
                            <strong><label for="itOfficerEmail" style="visibility: hidden">IT OFFICER/PERSONNEL EMAIL</label></strong>
                            <input type="email" name="itOfficerEmail" class="form-control" placeholder="Enter Email Address" value="<?php if(!isset($_COOKIE["itOfficerEmail"])){echo $itOfficerEmail;}else{echo $_COOKIE["itOfficerEmail"]; setcookie("itOfficerEmail", "");} ?>">
                          </div>
                        </div>
                      </div>
                      
                    <div class="row">
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="description">DESCRIPTION</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <textarea style="height: 12.7rem;" type="text" name="description" rows="8" class="form-control" id="description" placeholder="Enter Description" required><?php if(!isset($_COOKIE["description"])){echo $description;}else{echo $_COOKIE["description"]; setcookie("description", "");} ?></textarea>
                        </div>
                      </div>
                      <div class="col-xl">
                        <div class="row">
                          <div class="col-xl">
                            <div class="form-group">
                              <strong><label for="environment">ENVIRONMENT</label></strong>
                              <strong><label style ="color: red;">*</label></strong>
                              <select class="custom-select" name="environment" required>
                                <option value="" selected>-Select Environment Level-</option>
                                <option <?php if(!isset($_COOKIE["lanBased"])){echo $lanBased;}else{echo $_COOKIE["lanBased"]; setcookie("lanBased", "");} ?> value="LAN-Based">LAN-Based</option>
                                <option <?php if(!isset($_COOKIE["webBased"])){echo $webBased;}else{echo $_COOKIE["webBased"]; setcookie("webBased", "");} ?> value="WEB-Based">Web-Based</option>
                                <option <?php if(!isset($_COOKIE["cloudBased"])){echo $cloudBased;}else{echo $_COOKIE["cloudBased"]; setcookie("cloudBased", "");} ?> value="CLOUD-Based">Cloud-Based</option>
                                <option <?php if(!isset($_COOKIE["others"])){echo $others;}else{echo $_COOKIE["others"]; setcookie("others", "");} ?> value="Others">Others</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-xl">
                            <div class="form-group">
                              <strong><label for="appFunction">APPLICATION FUNCTIONALITY</label></strong>
                                <select class="custom-select" id="appFunction" name="appFunction" onchange="modifyAppFunctions(<?php echo $id ?>)">
                                <?php if($appFunction == ''): ?>
                                  <?php if(isset($_COOKIE['appFunction'])): ?>
                                    <?php 
                                      $appFunction = $_COOKIE['appFunction'];
                                      setcookie("appFunction", "");
                                      $result = $mysqli->query("SELECT * FROM tblappfunction WHERE id != '$appFunction'") or die($mysqli->error());
                                      $resultSelected = $mysqli->query("SELECT * FROM tblappfunction WHERE id = '$appFunction'") or die($mysqli->error());
                                      $rowSelected = $resultSelected->fetch_assoc();
                                    ?>
                                    <option value="<?php echo $rowSelected['id']; ?>" selected><?php echo $rowSelected['appFunctionality']; ?></option>
                                  <?php else: ?>
                                    <?php 
                                      $result = $mysqli->query("SELECT * FROM tblappfunction") or die($mysqli->error());
                                    ?>
                                    <option value="" selected>-Select Application Functionality-</option>
                                  <?php endif; ?>
                                  <?php while($row = $result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['appFunctionality']; ?></option>
                                  <?php endwhile; ?>
                                  <option value="Modify Application Functionality">-Modify Application Functionality-</option>
                                <?php else: ?>
                                  <?php 
                                    $result = $mysqli->query("SELECT * FROM tblappfunction WHERE id != '$appFunction'") or die($mysqli->error());
                                    $resultSelected = $mysqli->query("SELECT * FROM tblappfunction WHERE id = '$appFunction'") or die($mysqli->error());
                                    $rowSelected = $resultSelected->fetch_assoc();
                                  ?>
                                  <option value="<?php echo $rowSelected['id']; ?>" selected><?php echo $rowSelected['appFunctionality']; ?></option>
                                  <?php while($row = $result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['appFunctionality']; ?></option>
                                  <?php endwhile; ?>
                                  <option value="Modify Application Functionality">-Modify Application Functionality-</option>
                                <?php endif; ?>
                              </select>
                            </div> 
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl">
                            <div class="form-group">
                              <strong><label for="operatingSystem">OPERATING SYSTEM</label></strong>
                              <strong><label style ="color: red;">*</label></strong>
                              <input type="text" name="operatingSystem" class="form-control" id="operatingSystem" placeholder="Enter Operations System" required value="<?php if(!isset($_COOKIE["operatingSystem"])){echo $operatingSystem;}else{echo $_COOKIE["operatingSystem"]; setcookie("operatingSystem", "");} ?>">
                            </div> 
                          </div>
                          <div class="col-xl">
                            <div class="form-group">
                              <strong><label for="devTool">DEVELOPMENT TOOL</label></strong>
                              <strong><label style ="color: red;">*</label></strong>
                              <input type="text" name="devTool" class="form-control" id="devTool" placeholder="Enter Development Tool" required value="<?php if(!isset($_COOKIE["devTool"])){echo $devTool;}else{echo $_COOKIE["devTool"]; setcookie("devTool", "");} ?>">
                            </div> 
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xl">
                            <div class="form-group">
                              <strong><label for="backEnd">BACK-END</label></strong>
                              <strong><label style ="color: red;">*</label></strong>
                              <input type="text" name="backEnd" class="form-control" id="backEnd" placeholder="Enter Back-End" required value="<?php if(!isset($_COOKIE["backEnd"])){echo $backEnd;}else{echo $_COOKIE["backEnd"]; setcookie("backEnd", "");} ?>">
                            </div>
                          </div>
                          <div class="col-xl">
                            <div class="form-group">
                              <strong><label for="numRecords">TOTAL NO. OF RECORDS</label></strong>
                              <strong><label style ="color: red;">*</label></strong>
                              <input type="number" name="numRecords" class="form-control" id="numRecords" placeholder="Enter Total No. of Records" required value="<?php if(!isset($_COOKIE["numRecords"])){echo $numRecords;}else{echo $_COOKIE["numRecords"]; setcookie("numRecords", "");} ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                   
                        </div>     
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="dbSecurity">DATABASE SECURITY</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <input type="text" name="dbSecurity" class="form-control" id="dbSecurity" placeholder="Enter Database Security" required value="<?php if(!isset($_COOKIE["dbSecurity"])){echo $dbSecurity;}else{echo $_COOKIE["dbSecurity"]; setcookie("dbSecurity", "");} ?>">
                        </div>
                      </div>
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="source">SOURCE</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <select class="custom-select" name="source" required>
                            <option value="" selected>-Select Source-</option>
                            <option <?php if(!isset($_COOKIE["inHouseITMS"])){echo $inHouseITMS;}else{echo $_COOKIE["inHouseITMS"]; setcookie("inHouseITMS", "");} ?> value="In-House (by ITMS)">In-House (by ITMS)</option>
                            <option <?php if(!isset($_COOKIE["inHouseUnit"])){echo $inHouseUnit;}else{echo $_COOKIE["inHouseUnit"]; setcookie("inHouseUnit", "");} ?> value="In-House (c/o Unit)">In-House (c/o Unit)</option>
                            <option <?php if(!isset($_COOKIE["outsource"])){echo $outsource;}else{echo $_COOKIE["outsource"]; setcookie("outsource", "");} ?> value="Outsource">Outsource</option>
                          </select>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <strong><label for="withContract">WITH CONTRACT</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <div class="form-group">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="withContract" id="yesContract" required value="yes" <?php if(!isset($_COOKIE["yesContract"])){echo $yesContract;}else{echo $_COOKIE["yesContract"]; setcookie("yesContract", "");} ?>>
                              <label class="form-check-label" for="yesContract" id="yesContractLabel">
                                Yes
                              </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="withContract" id="noContract" required value="no" <?php if(!isset($_COOKIE["noContract"])){echo $noContract;}else{echo $_COOKIE["noContract"]; setcookie("noContract", "");} ?>>
                              <label class="form-check-label" for="noContract" id="noContractLabel">
                                No
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <strong><label for="dictmCertified">DICTM CERTIFIED</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <div class="form-group">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="dictmCertified" id="yesCertified" required value="yes" <?php if(!isset($_COOKIE["yesCertified"])){echo $yesCertified;}else{echo $_COOKIE["yesCertified"]; setcookie("yesCertified", "");} ?>>
                              <label class="form-check-label" for="yesCertified" id="yesCertifiedLabel">
                                Yes
                              </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="dictmCertified" id="noCertified" required value="no" <?php if(!isset($_COOKIE["noCertified"])){echo $noCertified;}else{echo $_COOKIE["noCertified"]; setcookie("noCertified", "");} ?>>
                              <label class="form-check-label" for="noCertified" id="noCertifiedLabel">
                                No
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xl">
                        <div class="row">
                          <div class="col-xl">
                            <div class="form-group">
                              <strong><label for="typeIS">TYPE OF IS</label></strong>
                              <strong><label style ="color: red;">*</label></strong>
                              <select class="custom-select" name="typeIS" required>
                                <option value="" selected>-Select Type of IS-</option>
                                <option <?php if(!isset($_COOKIE["administrative"])){echo $administrative;}else{echo $_COOKIE["administrative"]; setcookie("administrative", "");} ?> value="Administrative">Administrative</option>
                                <option <?php if(!isset($_COOKIE["operationsIS"])){echo $operationsIS;}else{echo $_COOKIE["operationsIS"]; setcookie("operationsIS", "");} ?> value="Operations IS">Operations IS</option>
                                <option <?php if(!isset($_COOKIE["supportOperationsIS"])){echo $supportOperationsIS;}else{echo $_COOKIE["supportOperationsIS"]; setcookie("supportOperationsIS", "");} ?> value="Support to Operations IS">Support to Operations IS</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-xl">
                            <div class="form-group">
                              <strong><label for="statusIS">STATUS OF IS</label></strong>
                              <strong><label style ="color: red;">*</label></strong>
                              <select class="custom-select" name="statusIS" required>
                                <option value="" selected>-Select Status-</option>
                                <option <?php if(!isset($_COOKIE["operational"])){echo $operational;}else{echo $_COOKIE["operational"]; setcookie("operational", "");} ?> value="Operational">Operational</option>
                                <option <?php if(!isset($_COOKIE["nonOperational"])){echo $nonOperational;}else{echo $_COOKIE["nonOperational"]; setcookie("nonOperational", "");} ?> value="Non-Operational">Non-Operational</option>
                                <option <?php if(!isset($_COOKIE["forDevelopment"])){echo $forDevelopment;}else{echo $_COOKIE["forDevelopment"]; setcookie("forDevelopment", "");} ?> value="For Development">For Development</option>
                                <option <?php if(!isset($_COOKIE["forEnhancement"])){echo $forEnhancement;}else{echo $_COOKIE["forEnhancement"]; setcookie("forEnhancement", "");} ?> value="For Enhancement">For Enhancement</option>
                              </select>
                            </div>                             
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl">
                            <div class="form-group">
                              <div class="form-group" style="margin:0;">
                                <strong><label for="source">DOCUMENTATION</label></strong>
                              </div>
                              <div class="form-check form-check-inline" id="docCheck">
                                <input class="form-check-input" type="checkbox" id="systemDoc" name="systemDoc" <?php if(!isset($_COOKIE["yesSystemDoc"])){echo $yesSystemDoc;}else{echo $_COOKIE["yesSystemDoc"]; setcookie("yesSystemDoc", "");} ?>>
                                <label class="form-check-label" for="systemDoc">System Document</label>
                              </div>
                              <div class="form-check form-check-inline" id="docCheck">
                                <input class="form-check-input" type="checkbox" id="userManual" name="userManual" <?php if(!isset($_COOKIE["yesUserManual"])){echo $yesUserManual;}else{echo $_COOKIE["yesUserManual"]; setcookie("yesUserManual", "");} ?>>
                                <label class="form-check-label" for="userManual">User Manual</label>
                              </div>
                              <div class="form-check form-check-inline" id="docCheck">
                                <input class="form-check-input" type="checkbox" id="userAcceptance" name="userAcceptance" <?php if(!isset($_COOKIE["yesUserAcceptance"])){echo $yesUserAcceptance;}else{echo $_COOKIE["yesUserAcceptance"]; setcookie("yesUserAcceptance", "");} ?>>
                                <label class="form-check-label" for="userAcceptance">User Acceptance</label>
                              </div>
                            </div>
                          </div>    
                        </div>
                      </div>
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="remarks">REMARKS</label></strong>
                          <textarea type="text" name="remarks"  rows="4" class="form-control" placeholder="Enter Remarks"><?php if(!isset($_COOKIE["remarks"])){echo $remarks;}else{echo $_COOKIE["remarks"]; setcookie("remarks", "");}?></textarea>
                        </div>
                      </div>
                    </div>
                         
                    <div class="row">
                      <div class="col-xl-6">
                        <div class="form-group">
                          <strong><label for="developedBy">DEVELOPED BY</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <input type="text" name="developedBy" class="form-control" placeholder="Enter Name" pattern="[a-zA-Z 0-9.]{1,30}" title="Letters and Numbers only" required value="<?php if(!isset($_COOKIE["developedBy"])){echo $developedBy;}else{echo $_COOKIE["developedBy"]; setcookie("developedBy", "");} ?>">
                        </div>
                      </div>
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="developedByContact" style="visibility: hidden">DEVELOPED CONTACT</label></strong>
                          <input type="text" name="developedByContact" class="form-control" placeholder="Enter Contact No." pattern="[0-9]{1,11}" title="Numbers only" value="<?php if(!isset($_COOKIE["developedByContact"])){echo $developedByContact;}else{echo $_COOKIE["developedByContact"]; setcookie("developedByContact", "");} ?>">
                        </div>
                      </div>
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="developedByEmail" style="visibility: hidden">DEVELOPED EMAIL</label></strong>
                          <input type="email" name="developedByEmail" class="form-control" placeholder="Enter Email Address" value="<?php if(!isset($_COOKIE["developedByEmail"])){echo $developedByEmail;}else{echo $_COOKIE["developedByEmail"]; setcookie("developedByEmail", "");} ?>">
                         </div>
                      </div> 
                    </div>

                    <div class="row">
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="dateInitiated">DATE INITIATED</label></strong>
                          <input type="text" name="dateInitiated" id="dateInitiated" class="form-control" placeholder="Enter Date Initiated" pattern="[-/ .0-9]{1,30}" title="Please enter valid date format"  value="<?php if(!isset($_COOKIE["dateInitiated"])){echo $dateInitiated;}else{echo $_COOKIE["dateInitiated"]; setcookie("dateInitiated", "");} ?>" style="background: white;">
                        </div>
                      </div>
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="developmentDate">DEVELOPMENT DATE</label></strong>
                          <input type="text" name="developmentDate" id="developmentDate" class="form-control" placeholder="Enter Development Date" pattern="[-/ .0-9]{1,30}" title="Please enter valid date format"  value="<?php if(!isset($_COOKIE["developmentDate"])){echo $developmentDate;}else{echo $_COOKIE["developmentDate"]; setcookie("developmentDate", "");} ?>" style="background: white;">
                        </div>
                      </div>
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="turnOverDate">TURN-OVER DATE</label></strong>
                          <input type="text" name="turnOverDate" id="turnOverDate" class="form-control" placeholder="Enter Turn-Over Date" pattern="[-/ .0-9]{1,30}" title="Please enter valid date format"  value="<?php if(!isset($_COOKIE["turnOverDate"])){echo $turnOverDate;}else{echo $_COOKIE["turnOverDate"]; setcookie("turnOverDate", "");} ?>" style="background: white;">
                        </div>
                      </div>
                      <div class="col-xl">
                        <div class="form-group">
                          <strong><label for="implementDate">IMPLEMENTATION DATE</label></strong>
                          <input type="text" name="implementDate" id="implementDate" class="form-control" placeholder="Enter Implementation Date" pattern="[-/ .0-9]{1,30}" title="Please enter valid date format" value="<?php if(!isset($_COOKIE["implementDate"])){echo $implementDate;}else{echo $_COOKIE["implementDate"]; setcookie("implementDate", "");} ?>" style="background: white;">
                        </div>
                      </div>
                    </div>
                      
                    <div class="row">
                      <div class="col-xl-3">
                        <div class="form-group">
                          <strong><label for="cleansedDate">CLEANSED DATE</label></strong>
                          <input type="text" name="cleansedDate" id="cleansedDate" class="form-control" placeholder="Enter Year Last Cleansed" pattern="[-/ .0-9]{1,30}" title="Please enter valid date format" value="<?php if(!isset($_COOKIE["cleansedDate"])){echo $cleansedDate;}else{echo $_COOKIE["cleansedDate"]; setcookie("cleansedDate", "");} ?>" style="background: white;">
                        </div>
                      </div>
                      <div class="col-xl-3">
                        <div class="form-group">
                          <strong><label for="preparedBy">PREPARED BY</label></strong>
                          <strong><label style ="color: red;">*</label></strong>
                          <input type="text" name="preparedBy" class="form-control" placeholder="Enter Name" pattern="[a-zA-Z 0-9.]{1,30}" title="Letters and Numbers only" required value="<?php if(!isset($_COOKIE["preparedBy"])){echo $preparedBy;}else{echo $_COOKIE["preparedBy"]; setcookie("preparedBy", "");} ?>">
                        </div>
                      </div>
                      <?php if($id != ''): ?>
                        <div class="col-xl-3">
                          <div class="form-group">
                            <strong><label for="documents">DOCUMENTS</label></strong>
                            <a href="../systems/?folder=<?php echo $id;  ?>" class="form-control" style="border: 0; color: blue;">View Attached Documents</a>
                          </div> 
                        </div>
                        <div class="col-xl-3">
                        <?php if($_SESSION['authorityLevel'] == "admin"): ?>
                          <div class="form-group">
                            <strong><label for="researchers">RESEARCHERS</label></strong>
                            <a href="../systems/?researchers=<?php echo $id;  ?>&office=<?php echo $office ?>" class="form-control" style="border: 0; color: blue;">View Assigned Researchers</a>
                          </div> 
                        <?php endif; ?>
                        </div>
                      <?php endif; ?>
                  </div>
                </div>

                <div class="modal-footer"> 
                  <?php if($update == true): ?>
                    <?php if($_SESSION['authorityLevel'] == 'admin'): ?>
                      <a href="?delete=<?php echo $id; ?>" class="btn btn-outline-dark mr-auto" id="btnDelete">Delete</a>
                    <?php else: ?>
                        
                    <?php endif; ?>
                      <button type="submit" class="btn btn-success" id="btnUpdate" name="update">Update</button>
                      <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="btn btn-danger">Cancel</a>
                    <?php else: ?> 
                      <button type="submit" class="btn btn-success" id="btnSave" name="save">Save</button>
                      <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="btn btn-danger">Cancel</a>
                    <?php endif; ?>
                  </div>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!---------------MODAL RESEARCHERS--------------->
        <div class="modal fade" id="viewResearchers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <img src="../images/logo-itms.png" height="30" width="30" alt="" style="margin-left: .7vw;">
                  <h5 class="modal-title ml-auto">Researchers</h5>
                  <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
                </div>

                <?php
                  $resultResearchers = $mysqli->query("SELECT tblresearchers.id, tblresearchers.accountId, tblresearchers.systemId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblranks.rank FROM tblresearchers JOIN tblaccounts ON tblresearchers.accountId = tblaccounts.id JOIN tblranks ON tblaccounts.rank = tblranks.id WHERE systemId = $id LIMIT 8") or die($mysqli->error());

                  $resultResearchers2 = $mysqli->query("SELECT COUNT(*) AS count FROM tblresearchers WHERE systemId = $id") or die($mysqli->error());
                  $rowResearchers2 = $resultResearchers2->fetch_assoc();


          
                ?>

                <script>
                  $(document).ready(function(){
                    var researcherCount = 8;
                    var id = '<?php echo $id; ?>';
                    var office = '<?php echo $systemOffice; ?>';


                    $("#btnViewMoreResearchers").click(function(){
                      researcherCount = researcherCount + 8;
                      $("#divResearcher").load("viewMoreResearcher.php", {
                        newResearcherCount: researcherCount,
                        systemId : id,
                        systemOffice : office

                      });
                    });
                  });
                </script>

                <form action="process.php" method="POST" enctype="multipart/form-data">
                  <div class="modal-body" id="modalBody">
                    <div class="row">
                      <div class="col-xl">
                        <div class="form-group" style="text-align: right;">
                          <button type="button" class="btn btn-primary" onclick = "newResearcher()"><image src="../images/addsystem.png" height="20" width="22" style="float: left; margin-top: 3px; margin-right: .5rem; "></image>Assign Researcher</button>
                        </div>
                   
                        <input type="hidden" name="systemId" value="<?php echo $id; ?>">
                        <input type="hidden" name="systemOffice" value="<?php echo $systemOffice; ?>">
                   

                        <div class="col" id="errorDocumentAlert">
                          <?php if(isset($_SESSION['researcherMessage'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['researcherMessageType'] ?>" id="researcherMessageAlert">
                              <?php 
                                echo $_SESSION['researcherMessage'];
                                unset($_SESSION['researcherMessage']);
                              ?>
                            </div>
                          <?php endif; ?>
                          <?php if(isset($_SESSION['unassignMessage'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['unassignMessageType'] ?>" id="unassignMessageAlert">
                              <?php 
                                echo $_SESSION['unassignMessage'];
                                unset($_SESSION['unassignMessage']);
                              ?>
                            </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex flex-row"> 
                      <div class="col p-1" id="divResearchers">
                        <input type="hidden" class="form-control" id="inputResearcherCount" name="inputResearcherCount" value="" style="background: white;">
                      </div> 
                      <div class="p-1" id="divResearchersButton">

                      </div>
                    </div>

                    <div class="row" style="margin-top: .4rem;">
                      <div class="col-xl" id ="divResearcher">
                        <?php if($rowResearchers2['count'] == '0'): ?>
                          <p align="center">No Researchers Assigned</p>
                        <?php else: ?>
                          <ul class="list-group">
                            <?php while($rowResearchers = $resultResearchers->fetch_assoc()): ?>
                              <li class="list-group-item"><?php echo $rowResearchers['fname'] . " "; if($rowResearchers['mname'] != ""){ echo $rowResearchers['mname'][0] . ". "; } echo $rowResearchers['lname'] . " " . $rowResearchers['qualifier']?><a href="../systems/?unassignResearcher=<?php echo $id; ?>&office=<?php echo $systemOffice; ?>&unassign=<?php echo $rowResearchers['id']; ?>" class="close"><span aria-hidden="true">&times;</span></a></li>
                            <?php endwhile; ?>
                          </ul>
                        <?php endif; ?> 
                      </div>
                    </div>
                    <div class="row" style="display: grid; justify-items: center; margin-top: 1rem; <?php if($rowResearchers2['count'] == '0' || $rowResearchers2['count'] <= 8): ?>display: none;<?php endif; ?>" id="divViewMoreResearcher">
                      <button class="btn btn-outline-primary" type="button" id="btnViewMoreResearchers" style="width: 25vw;">View More</button>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnUpdate" name="updateResearcher">Update</button>
                    <a href="../systems/?edit=<?php echo $id; ?>" class="btn btn-info" name="btnBack">Back</a>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!---------------MODAL UNASSIGN--------------->

          <div class="modal fade" id="unassignResearcher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Unassign Researcher</h5>
                  <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
                </div>

                <form action="process.php" method="POST">
                  <div class="modal-body">
                    Are you sure you want to unassign this researcher?
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="systemIdResearcher" value="<?php echo $systemIdResearcher; ?>">
                    <input type="hidden" name="systemOffice" value="<?php echo $systemOffice; ?>">
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="btnYesUnassign">Yes</button>
                    <a href="../systems/?researchers=<?php echo $systemIdResearcher; ?>&office=<?php echo $systemOffice; ?>" class="btn btn-danger" name="btnNoUnassign">No</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
         
          <!---------------MODAL FOLDER--------------->
          <div class="modal fade" id="viewFolder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <img src="../images/logo-itms.png" height="30" width="30" alt="" style="margin-left: .7vw;">
                  <h5 class="modal-title ml-auto">Documents</h5>
                  <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
                </div>

                <form action="process.php" method="POST">
                  <div class="modal-body" id="modalBody">
                    <div class="row">
                      <div class="col xl">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <img src="../images/folder.png" alt="" style="margin-right: .5rem;">
                            <a href="../systems/?documents=<?php echo $id; ?>&folder=Schedule of Activities">Schedule of Activities</a>
                          </li>
                          <li class="list-group-item">
                            <img src="../images/folder.png" alt="" style="margin-right: .5rem;">
                            <a href="../systems/?documents=<?php echo $id; ?>&folder=Incoming/Outgoing Communications">Incoming/Outgoing Communications</a>
                          </li>
                          <li class="list-group-item">
                            <img src="../images/folder.png" alt="" style="margin-right: .5rem;">
                            <a href="../systems/?documents=<?php echo $id; ?>&folder=Conference Notice/AAR">Conference Notice/AAR</a>
                          </li>
                          <li class="list-group-item">
                            <img src="../images/folder.png" alt="" style="margin-right: .5rem;">
                            <a href="../systems/?documents=<?php echo $id; ?>&folder=Documentation">Documentation</a>
                          </li>
                          <li class="list-group-item">
                            <img src="../images/folder.png" alt="" style="margin-right: .5rem;">
                            <a href="../systems/?documents=<?php echo $id; ?>&folder=References">References</a>
                          </li>   
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <a href="../systems/?edit=<?php echo $id; ?>" class="btn btn-info" name="btnBack">Back</a>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!---------------MODAL DOCUMENTS--------------->
          <div class="modal fade" id="viewDocuments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <img src="../images/logo-itms.png" height="30" width="30" alt="" style="margin-left: .7vw;">
                  <h5 class="modal-title ml-auto">Documents</h5>
                  <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
                </div>

                <?php
                  $resultDocument = $mysqli->query("SELECT * FROM tbldocuments WHERE systemId = $id AND folder='$folder' LIMIT 8") or die($mysqli->error());

                  $resultDocument2 = $mysqli->query("SELECT COUNT(*) AS count FROM tbldocuments WHERE systemId = $id AND folder='$folder' LIMIT 8") or die($mysqli->error());
                  $rowDocument2 = $resultDocument2->fetch_assoc();
                ?>

                <script>
                  $(document).ready(function(){
                    var folder = "<?php echo $folder; ?>";
                    var id = "<?php echo $id; ?>";
                    var docCount = 8;
                    $("#btnViewMore").click(function(){
                      docCount = docCount + 8;
                      $("#divDocuments2").load("viewMoreDoc2.php", {
                        newFolder: folder,
                        systemId: id,
                        newDocCount: docCount
                      });
                    });
                  });
                </script>

                <form action="process.php" method="POST" enctype="multipart/form-data">
                  <div class="modal-body" id="modalBody">
                    <div class="row">
                      <div class="col xl">
                        <input type="hidden" name="systemId" value="<?php echo $id; ?>">
                        <input type="hidden" name="folder" value="<?php echo $folder; ?>">
                        <div class="custom-file">  
                          <input type="file" class="form-control" style="border: 0; padding-top: 4px;" name="fileDocuments[]" id="inputDocuments" accept=".png, .jpg, .jpeg" multiple onChange="makeFileList();">
                        </div>
                        <ul id="fileList" class="list-group" style="margin-top: .35vw; margin-bottom: .3vw;">

                        </ul>
                      </div>
                    </div>
                    <div class="row"> 
                      <div class="col" id="errorDocumentAlert">
                        <?php if(isset($_SESSION['documentMessage'])): ?>
                          <div class="alert alert-<?php echo $_SESSION['documentMessageType'] ?>" id="removeMessageAlert">
                            <?php 
                              echo $_SESSION['documentMessage'];
                              unset($_SESSION['documentMessage']);
                            ?>
                          </div>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['removeMessage'])): ?>
                          <div class="alert alert-<?php echo $_SESSION['removeMessageType'] ?>" id="removeMessageAlert">
                            <?php 
                              echo $_SESSION['removeMessage'];
                              unset($_SESSION['removeMessage']);
                            ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="row" style="margin-top: .4rem;">
                      <div class="col-xl" id ="divDocuments2">
                        <?php if($rowDocument2['count'] == '0'): ?>
                          <p align="center">No Documents Attached</p>
                        <?php else: ?>
                          <ul class="list-group">
                            <?php while($rowDocument = $resultDocument->fetch_assoc()): ?>
                            <a href="../document/?document=<?php echo $rowDocument['id']; ?>&folder=<?php echo $folder; ?>"><li class="list-group-item"><img src="../images/system documents/<?php echo $rowDocument['filename']?>" height="50vw" width="50vw" alt="" style="margin-right: 1vw;"><?php echo $rowDocument['filename'] ?><a href="../systems/?removeDocuments=<?php echo $id; ?>&removeFolder=<?php echo $folder; ?>&remove=<?php echo $rowDocument['id']; ?>" class="close"  style="margin-top: 12px;"><span aria-hidden="true">&times;</span></a></li>
                            <?php endwhile; ?></a>
                          </ul>
                        <?php endif; ?> 
                      </div>
                    </div>
                    <div class="row" style="display: grid; justify-items: center; margin-top: 1rem; <?php if($rowDocument2['count'] == '0' || $rowDocument2['count'] <= 8): ?>display: none;<?php endif; ?>" id="divViewMore2">
                        <button class="btn btn-outline-primary" type="button" id="btnViewMore" style="width: 25vw;">View More</button>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnUpdate" name="updateFolder">Update</button>
                    <a href="../systems/?folder=<?php echo $id; ?>" class="btn btn-info" name="btnBack">Back</a>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!---------------MODAL REMOVE--------------->

          <div class="modal fade" id="removeDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Remove Document</h5>
                  <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
                </div>

                <form action="process.php" method="POST">
                  <div class="modal-body">
                    Are you sure you want to remove this document?
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="documents" value="<?php echo $documents; ?>">
                    <input type="hidden" name="folder" value="<?php echo $folder; ?>">
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="btnYesRemove">Yes</button>
                    <a href="../systems/?documents=<?php echo $documents; ?>&folder=<?php echo $folder; ?>" class="btn btn-danger" name="btnNoRemove">No</a>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!---------------MODAL DELETE--------------->
          <div class="modal fade" id="deleteAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete System</h5>
                  <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
                </div>

                <form action="process.php" method="POST">
                  <div class="modal-body">
                    Are you sure you want to delete this system?
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="btnYes">Yes</button>
                    <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="btn btn-danger" name="btnNo">No</a>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!---------------MODAL RANKS--------------->
          <div class="modal fade" id="modifyRanks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <img src="../images/logo-itms.png" height="30" width="30" alt="" style="margin-left: .7vw;">
                  <h5 class="modal-title ml-auto">Modify Ranks</h5>
                  <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
                </div>

                <?php
                  $resultRanks = $mysqli->query("SELECT * FROM tblranks") or die($mysqli->error());

                  $resultRanksCount = $mysqli->query("SELECT COUNT(*) AS count FROM tblranks") or die($mysqli->error());
                  $rowRanksCount = $resultRanksCount->fetch_assoc();
                ?>


                <form action="process.php" method="POST">
                  <div class="modal-body" id="modalBody">
                    <div class="row">
                      <div class="col">
                        <div class="form-group" style="text-align: right;">
                          <button type="button" class="btn btn-primary" onclick = "newRank()"><img src="../images/addsystem.png" height="20" width="22" style="float: left; margin-top: 3px; margin-right: .5rem; ">New Rank</button>
                        </div>
                    
                        <input type="hidden" class="form-control" name="systemIdRank" value="<?php echo $id; ?>" style="background: white;">
                        
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
                    </div>
                    
                    <div class="d-flex flex-row">
                      <div class="col p-1" id="divRanks">
                        <input type="hidden" class="form-control" id="inputRankCount" name="inputRankCount" value="" style="background: white;">
                      </div>
                      <div class="p-1" id="divRanksButton" style="padding: 0; display: grid; justify-items: center;">
 
                      </div>
                    </div>
                  
                    <div class="row">
                      <div class="col" id ="divRank">
                          <?php $i = 1; while($rowRanks = $resultRanks->fetch_assoc()): ?>
                            <div class="form-group">
                              <input type="hidden" class="form-control" value="<?php echo mysqli_num_rows($resultRanks); ?>" id="existingRankCount" name="existingRankCount" value="" style="background: white;">
                              <input type="hidden" class="form-control" name="existingRankId<?php echo $i; ?>" value="<?php echo $rowRanks['id']; ?>" style="background: white;">
                              <input type="text" class="form-control" name="existingRank<?php echo $i; ?>" value="<?php echo $rowRanks['rank']; ?>" style="background: white;">
                            </div>
                          <?php $i++; endwhile; ?>
                      </div>
                    </div>  
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnUpdate" name="updateRank">Update</button>
                    <?php if($id != 0): ?>
                      <a href="../systems/?edit=<?php echo $id; ?>" class="btn btn-info" name="btnBack">Back</a>
                    <?php else: ?>
                      <button type="button" class="btn btn-info" id="btnBack" name="btnBack" onclick="backNewAccount()">Back</button>
                    <?php endif; ?>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!---------------MODAL APPLICATION FUNCTIONALITY--------------->
          <div class="modal fade" id="modifyAppFunctions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <img src="../images/logo-itms.png" height="30" width="30" alt="" style="margin-left: .7vw;">
                  <h5 class="modal-title ml-auto">Modify Application Functionality</h5>
                  <a href="../systems/?page=<?php echo $_SESSION['pageSystem']; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
                </div>

                <?php
                  $resultAppFunctions = $mysqli->query("SELECT * FROM tblappfunction") or die($mysqli->error());

                  $resultAppFunctionsCount = $mysqli->query("SELECT COUNT(*) AS count FROM tblappfunction") or die($mysqli->error());
                  $rowAppFunctionsCount = $resultAppFunctionsCount->fetch_assoc();
                ?>


                <form action="process.php" method="POST">
                  <div class="modal-body" id="modalBody">
                    <div class="row">
                      <div class="col">
                        <div class="form-group" style="text-align: right;">
                          <button type="button" class="btn btn-primary" onclick = "newAppFunction()"><img src="../images/addsystem.png" height="20" width="22" style="float: left; margin-top: 3px; margin-right: .5rem; ">New Application Functionality</button>
                        </div>
                    
                        <input type="hidden" class="form-control" name="systemIdAppFunction" value="<?php echo $id; ?>" style="background: white;">
                        
                        <div class="col" id="errorDocumentAlert">
                          <?php if(isset($_SESSION['appFunctionMessage'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['appFunctionMessageType'] ?>" id="appFunctionMessageAlert">
                              <?php 
                                echo $_SESSION['appFunctionMessage'];
                                unset($_SESSION['appFunctionMessage']);
                              ?>
                            </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    
                    <div class="d-flex flex-row">
                      <div class="col p-1" id="divAppFunctions">
                        <input type="hidden" class="form-control" id="inputAppFunctionCount" name="inputAppFunctionCount" value="" style="background: white;">
                      </div>
                      <div class="p-1" id="divAppFunctionsButton" style="padding: 0; display: grid; justify-items: center;">
 
                      </div>
                    </div>
                  
                    <div class="row">
                      <div class="col" id ="divAppFunction">
                          <?php $i= 1; while($rowAppFunctions = $resultAppFunctions->fetch_assoc()): ?>
                            <div class="form-group">
                              <input type="hidden" class="form-control" value="<?php echo mysqli_num_rows($resultAppFunctions); ?>" id="existingAppFunctionCount" name="existingAppFunctionCount" value="" style="background: white;">
                              <input type="hidden" class="form-control" name="existingAppFunctionId<?php echo $i; ?>"  value="<?php echo $rowAppFunctions['id']; ?>" style="background: white;">
                              <input type="text" class="form-control" name="existingAppFunction<?php echo $i; ?>" value="<?php echo $rowAppFunctions['appFunctionality']; ?>" style="background: white;">
                            </div>
                          <?php $i++; endwhile; ?>
                      </div>
                    </div>  
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnUpdate" name="updateAppFunction">Update</button>
                    <?php if($id != 0): ?>
                      <a href="../systems/?edit=<?php echo $id; ?>" class="btn btn-info" name="btnBack">Back</a>
                    <?php else: ?>
                      <button type="button" class="btn btn-info" id="btnBack" name="btnBack" onclick="backNewAccount()">Back</button>
                    <?php endif; ?>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <?php $pageCookie = $_SESSION['pageSystem']; ?>
      </div>

  
      
      
      <script type="text/javascript">
        var div = document.getElementById('messageAlert');
        var errorDiv = document.getElementById('errorMessageAlert');
        var docDiv = document.getElementById('removeMessageAlert');
        var rankDiv = document.getElementById('rankMessageAlert');
        var appFunctionDiv = document.getElementById('appFunctionMessageAlert');
        var researcherDiv = document.getElementById('researcherMessageAlert');
        var unassignDiv = document.getElementById('unassignMessageAlert');


        var id = "<?php echo $id; ?>";
        var update = "<?php echo $update; ?>";
        var view = "<?php echo $view; ?>";
        var dele = "<?php echo $delete; ?>";
        var folder = "<?php echo $folder; ?>";
        var documents = "<?php echo $documents; ?>";
        var researchers = "<?php echo $researchers; ?>";
        var unassign = "<?php echo $unassign; ?>";
        var remove = "<?php echo $remove; ?>";
        var activate = "<?php echo $activate; ?>";
        var ranks = "<?php echo $ranks; ?>";
        var appFunctionality = "<?php echo $appFunctionality; ?>";
        var error = "<?php echo $error; ?>";
        var add = "<?php echo $add; ?>";
        var page = "<?php echo $pageCookie; ?>";

        function makeFileList() {
          var input = document.getElementById("inputDocuments");
          var ul = document.getElementById("fileList");

          while (ul.hasChildNodes()) {
            ul.removeChild(ul.firstChild);
          }

          for (var i = 0; i < input.files.length; i++) {
            var li = document.createElement("li");
            li.className = "list-group-item";
            li.innerHTML = input.files[i].name;
            ul.appendChild(li);
          }

          if(!ul.hasChildNodes()) {

          }
        }

        function newResearcher() {
          var divResearchers = document.getElementById("divResearchers");
          var divResearchersButton = document.getElementById("divResearchersButton");
          var inputResearcherCount = document.getElementById("inputResearcherCount");
          var newResearcher = document.createElement("select");
          var removeNewResearcher = document.createElement("button");
          var newResearcherForm = document.createElement("div");
          var removeNewResearcherForm = document.createElement("div");
          var divResearcherCount = divResearchers.childElementCount;

          inputResearcherCount.value = divResearcherCount;

          newResearcherForm.className = "form-group";
          newResearcherForm.id = "newResearcher" + divResearcherCount;

          removeNewResearcherForm.className = "form-group";
          removeNewResearcherForm.id = "removeNewResearcher" + divResearcherCount;

          removeNewResearcher.innerHTML = "X";
          removeNewResearcher.type = "button";
          removeNewResearcher.className = "btn btn-danger";
          removeNewResearcher.onclick = function(){
            document.getElementById("newResearcher" + divResearcherCount).remove();
            document.getElementById("removeNewResearcher" + divResearcherCount).remove();
          }

          newResearcher.name = "newResearcher" + divResearcherCount;
          newResearcher.className = "form-control";
          newResearcher.style.overflowY = "Initial !important";

          var researchersId = [''];
          var researchersName = ['-Select Researcher-'];
          <?php if(isset($_GET['office'])){ $result = $mysqli->query("SELECT * from tblaccounts WHERE authorityLevel = 'Researcher' and office = '$systemOffice' and status = 'activated'"); 
          while($row = $result->fetch_assoc()){ ?>
              researchersId.push(<?php echo $row['id']; ?>);
              researchersName.push("<?php echo $row['fname'] . " "; if($row['mname'] != "") {echo $row['mname'][0]; echo ". ";} echo $row['lname'] . $row['qualifier']; ?>");
          <?php } }?>
        
          for(var i = 0; i < researchersId.length; i++){
            var option = document.createElement("option");
            option.value = researchersId[i];
            option.innerHTML = researchersName[i];
            newResearcher.appendChild(option);
          }
          
          newResearcherForm.appendChild(newResearcher); 
          removeNewResearcherForm.appendChild(removeNewResearcher);  

          divResearchers.appendChild(newResearcherForm);  
          divResearchersButton.appendChild(removeNewResearcherForm);  
         
        }

        function newRank() {
          var divRank = document.getElementById("divRanks");
          var divRanksButton = document.getElementById("divRanksButton");
          var inputRankCount = document.getElementById("inputRankCount");
          var newRank = document.createElement("input");
          var removeNewRank = document.createElement("button");
          var newRankForm = document.createElement("div");
          var removeNewRankForm = document.createElement("div");
          var divRankCount = divRank.childElementCount;

          inputRankCount.value = divRankCount;

          newRankForm.className = "form-group";
          newRankForm.marginTop = "1rem";
          newRankForm.id = "newRank" + divRankCount;


          removeNewRankForm.className = "form-group";
          removeNewRankForm.marginTop = "1rem";
          removeNewRankForm.id = "removeNewRank" + divRankCount;

          removeNewRank.innerHTML = "X";
          removeNewRank.type = "button";
          removeNewRank.className = "btn btn-danger";
          removeNewRank.onclick = function(){
            document.getElementById("newRank" + divRankCount).remove();
            document.getElementById("removeNewRank" + divRankCount).remove();
          }

          newRank.name = "newRank" + divRankCount;
          newRank.className = "form-control";
          newRank.placeholder = "Enter Rank";

                   
          newRankForm.appendChild(newRank); 
          removeNewRankForm.appendChild(removeNewRank);  

          divRank.appendChild(newRankForm);  
          divRanksButton.appendChild(removeNewRankForm);  
        }

        function newAppFunction() {
          var divAppFunction = document.getElementById("divAppFunctions");
          var divAppFunctionsButton = document.getElementById("divAppFunctionsButton");
          var inputAppFunctionCount = document.getElementById("inputAppFunctionCount");
          var newAppFunction = document.createElement("input");
          var removeNewAppFunction = document.createElement("button");
          var newAppFunctionForm = document.createElement("div");
          var removeNewAppFunctionForm = document.createElement("div");
          var divAppFunctionCount = divAppFunction.childElementCount;

          inputAppFunctionCount.value = divAppFunctionCount;

          newAppFunctionForm.className = "form-group";
          newAppFunctionForm.marginTop = "1rem";
          newAppFunctionForm.id = "newAppFunction" + divAppFunctionCount;


          removeNewAppFunctionForm.className = "form-group";
          removeNewAppFunctionForm.marginTop = "1rem";
          removeNewAppFunctionForm.id = "removeNewAppFunction" + divAppFunctionCount;

          removeNewAppFunction.innerHTML = "X";
          removeNewAppFunction.type = "button";
          removeNewAppFunction.className = "btn btn-danger";
          removeNewAppFunction.onclick = function(){
            document.getElementById("newAppFunction" + divAppFunctionCount).remove();
            document.getElementById("removeNewAppFunction" + divAppFunctionCount).remove();
          }

          newAppFunction.name = "newAppFunction" + divAppFunctionCount;
          newAppFunction.className = "form-control";
          newAppFunction.placeholder = "Enter Application Functionality";

                   
          newAppFunctionForm.appendChild(newAppFunction); 
          removeNewAppFunctionForm.appendChild(removeNewAppFunction);  

          divAppFunction.appendChild(newAppFunctionForm);  
          divAppFunctionsButton.appendChild(removeNewAppFunctionForm);  
        }

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
            document.getElementById("formOffice").size=3;
          });
      });
      
        function loading(){
          var loader = document.getElementById("loader");
          loader.style.display = "none";
          var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";

          document.getElementById("systems").style.color = "black";    
          document.getElementById("systems").style.fontWeight = "bold";
        }

        var rank = document.getElementById("rank");

        function modifyRanks(id){
          if(rank.value == 'Modify Ranks'){
            location.href = "../systems/?ranks=" + id;
          }
        };

        var appFunction = document.getElementById("appFunction");

        function modifyAppFunctions(id){
          if(appFunction.value == 'Modify Application Functionality'){
            location.href = "../systems/?appFunction=" + id;
          }
        };

        function backNewAccount(){
          location.href = "../systems/?page=" + page + "&add=1";
        } 

        function systemView(id){
          location.href = "../systems/?view=" + id;
        }

        $('#addAccount').on('hidden.bs.modal', function () {
          location.href = "../systems/?page=" + page;
        })

        $('#deleteAccount').on('hidden.bs.modal', function () {
          location.href = "../systems/?page=" + page;
        })

        $('#activateAccount').on('hidden.bs.modal', function () {
          location.href = "../systems/?page=" + page;
        })

        $('#viewDocuments').on('hidden.bs.modal', function () {
          location.href = "../systems/?page=" + page;
        })

        $('#removeDocument').on('hidden.bs.modal', function () {
          location.href = "../systems/?page=" + page;
        })

        $('#modifyRanks').on('hidden.bs.modal', function () {
          location.href = "../systems/?page=" + page;
        })

        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });

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
        
        else if(id != 0 && folder == true){
          $(window).on('load',function(){
            $('#viewFolder').modal('show');
          });
        }

        else if(id != 0 && documents == true){
          $(window).on('load',function(){
            $('#viewDocuments').modal('show');
          });
        }

        else if(id != 0 && researchers == true){
          $(window).on('load',function(){
            $('#viewResearchers').modal('show');
          });
        }

        else if(id != 0 && unassign == true){
          $(window).on('load',function(){
            $('#unassignResearcher').modal('show');
          });
        }

        else if(id != 0 && remove == true){
          $(window).on('load',function(){
            $('#removeDocument').modal('show');
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

        else if(appFunctionality == true){
          $(window).on('load',function(){
            $('#modifyAppFunctions').modal('show');
          });
        }

        var message = "<?php if(!isset($_SESSION['message'])){ echo 'true'; }  ?>"
        var errMessage = "<?php if(!isset($_SESSION['errorMessage'])){ echo 'true'; }  ?>"
        var docMessage = "<?php if(!isset($_SESSION['removeMessage'])){ echo 'true'; }  ?>"
        var rankMessage = "<?php if(!isset($_SESSION['rankMessage'])){ echo 'true'; }  ?>"
        var appFunctionMessage = "<?php if(!isset($_SESSION['appFunctionMessage'])){ echo 'true'; }  ?>"
        var researcherMessage = "<?php if(!isset($_SESSION['researcherMessage'])){ echo 'true'; }  ?>"
        var unassignMessage = "<?php if(!isset($_SESSION['unassignMessage'])){ echo 'true'; }  ?>"

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

        if($("#removeMessageAlert").length){     
          if(docMessage == "true"){
            setInterval(function(){  
              docDiv.style.display = "none";
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

        
        if($("#appFunctionMessageAlert").length){     
          if(appFunctionMessage == "true"){
            setInterval(function(){  
              appFunctionDiv.style.display = "none";
            }, 3000);
          }
        }

        if($("#researcherMessageAlert").length){     
          if(researcherMessage == "true"){
            setInterval(function(){  
              researcherDiv.style.display = "none";
            }, 3000);
          }
        }

        if($("#unassignMessageAlert").length){     
          if(unassignMessage == "true"){
            setInterval(function(){  
              unassignDiv.style.display = "none";
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