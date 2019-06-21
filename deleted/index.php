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
            <h1 align="center">Deleted Systems</h1>
            <hr>
          </div>
        </div>

          <!-----FILTERS-----> 
          <form action="../deleted/" method="POST" style="display: grid; justify-items: center;">
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
                $statusValue = $_POST['statusValue'];

                if($searchValue != ""){
                  if($statusValue != ""){
                    $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status = 'inactive' AND statusIS = '$statusValue' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC") or die($mysqli->error);
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
    
                    $result = $mysqli->query("SELECT * FROM tblsystems WHERE status = 'inactive' AND statusIS = '$statusValue' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC LIMIT 10") or die($mysqli->error);
                    $resultString = ("SELECT * FROM tblsystems WHERE status = 'inactive' AND statusIS = '$statusValue' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC");
                  }
                  else{
                    $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status = 'inactive' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC") or die($mysqli->error);
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
    
                    $result = $mysqli->query("SELECT * FROM tblsystems WHERE status = 'inactive' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC LIMIT 10") or die($mysqli->error);
                    $resultString = ("SELECT * FROM tblsystems WHERE status = 'inactive' AND (name LIKE '%$searchValue%' OR office LIKE '%$searchValue%') ORDER BY name ASC");
                  }
                }
                else{
                  if($statusValue != ""){
                    $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status = 'inactive' AND statusIS = '$statusValue' ORDER BY name ASC") or die($mysqli->error);
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
    
                    $result = $mysqli->query("SELECT * FROM tblsystems WHERE status = 'inactive' AND statusIS = '$statusValue' ORDER BY name ASC LIMIT 10") or die($mysqli->error);
                    $resultString = ("SELECT * FROM tblsystems WHERE status = 'inactive' AND statusIS = '$statusValue' ORDER BY name ASC");
                  }
                  else{
                    $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status = 'inactive'") or die($mysqli->error);
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
    
                    $result = $mysqli->query("SELECT * FROM tblsystems WHERE status = 'inactive' ORDER BY name ASC LIMIT 10") or die($mysqli->error);
                    $resultString = ("SELECT * FROM tblsystems WHERE status = 'inactive' ORDER BY name ASC");
                  }
                }
              }
              else{
                $result1 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status = 'inactive' ORDER BY name ASC") or die($mysqli->error);
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

                $result = $mysqli->query("SELECT * FROM tblsystems WHERE status = 'inactive' ORDER BY name ASC LIMIT $startLimit, $resultCount") or die($mysqli->error);
                $resultString = ("SELECT * FROM tblsystems WHERE status = 'inactive' ORDER BY name ASC LIMIT $startLimit, $resultCount");
              }
              
            ?>
            
            <?php if(isset($_POST['search'])): ?>
              <p align="center"><strong>Keyword Searched: </strong> <?php echo $searchValue . " | "; ?><strong>Status of IS: </strong> <?php echo $statusValue; ?></p>
            <?php endif; ?>
            <p align="center" ><strong>Total No. of Deleted Information Systems: </strong> <?php echo mysqli_num_rows($result); ?></p>
          
            <div id = "divTable">
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
                

                <?php if($result != ""): ?>
                  <?php while($row = $result->fetch_assoc()): ?>
                    <tr ondblclick="systemView(<?php echo $row['id'] ?>)">
                      <?php if($row['logo'] == ''): ?>
                        <td><img src="../images/logo-pnp.png" height="50" width="50"></td>
                      <?php else: ?>
                        <td><img src="../images/system logo/<?php echo $row['logo'];?>" height="50" width="50"></td>
                      <?php endif; ?>
                      <td align="justify"><?php echo $row['name'] ?></td>
                      <td><?php echo $row['office'] ?></td>
                      <td align="justify"><?php echo $row['description'] ?></td>
                      <td><?php echo $row['source'] ?></td>
                      <td><?php echo ucwords($row['typeIS']) ?></td>
                      <td><?php echo $row['statusIS'] ?></td>
                      <td class="action">
                        <form action="process.php" method="POST">
                          <div>
                            <a href="?view=<?php echo $row['id']; ?>" class="btn btn-success" id="btnView" data-toggle="tooltip" data-placement="top" title="View" style="margin-top: .4rem;"><image src="../images/view.png" height="20" width="20"></image></a>
                            <a href="?activate=<?php echo $row['id']; ?>" class="btn" data-toggle="tooltip" data-placement="top" title="Recover" style="background: #07666d; margin-top: .4rem;" id="btnDelete"><image src="../images/recover.png" height="20" width="20"></image></a>
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
                        $("#divTable").load("viewMoreDeleted.php", {
                          newQuery: query,
                          newDocCount: docCount
                        });
                      });
                  });
              </script>



            <div class="row">
              <div class="col">
                <a href="../systems/" class="btn btn-link" name="deleted" style="float: right; margin: 0; padding: 0;">List of System</a>
              </div>
            </div>
            
            <form action="../deleted/" method="GET" id="accountsPagination">
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
                        <a href="../deleted/?page=<?php echo $page - 1 ?>" class="btn btn-outline-primary"><</a>
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
                          <a href="../deleted/?page=<?php echo $page ?>" class="btn btn-primary"><?php echo $page ?></a>
                        <?php else: ?>
                          <a href="../deleted/?page=<?php echo $page ?>" class="btn btn-outline-primary"><?php echo $page ?></a>
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
                        <a href="../deleted/?page=<?php echo $page + 1 ?>" class="btn btn-outline-primary">></a>
                      <?php endif; ?>
                      <p><?php echo $startLimit + 1?> - <?php $total = $startLimit + $resultCount; if($total < $rowCount['count']){ echo $total; } else{ echo $rowCount['count']; } ?> / <?php echo $rowCount['count'] ?></p> 
                    <?php else: ?>
                      <p>There are no deleted systems</p>
                    <?php endif; ?>
                  <?php endif; ?>
                </form>
  
          </div>
        </div>
        
        <!-----MODAL----->
        <div class="modal fade" id="addAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog <?php if($view == true): ?> modal-xxl <?php else: ?> modal-xl <?php endif; ?>" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <img src="../images/logo-itms.png" height="30" width="30" alt="" style="margin-left: .7vw;">
                <h5 class="modal-title ml-auto">System Information</h5>
                <a href="../deleted/?page=<?php echo $_COOKIE["page"]; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
              </div>

                <form action="process.php" method="POST">
                <div class="modal-body" style="margin-left: 2vw; margin-right: 2vw;" id="modalBody">
                      <div class="row">
                        <?php if($logo == ''): ?>
                          <div class="col" style="display: grid; align-items: center;">
                            <div class="input-group mr-sm-2" id="systemLogo">
                              <img src="../images/logo-pnp.png" style="height: 9vw; width: 9vw;" alt=""> 
                            </div>
                          </div>
                        <?php else: ?>
                          <div class="col" style="display: grid; align-items: center;">
                            <div class="input-group mr-sm-2" id="systemLogo">
                              <img src="../images/system logo/<?php echo $logo ?>" style="height: 9vw; width: 9vw;" alt=""> 
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

                      <div class="row" style="margin-top: 1vw;">
                        <div class="col-9">
                          <label style="font-weight: bold;">IT Officer/Personnel :</label>
                          <h6 style="font-size: .9vw"><?php echo $itOfficerRank . ' ' . $itOfficer; if($itOfficerEmail != ''){ echo ' - '; } echo $itOfficerEmail; if($itOfficerContact != ''){ echo ' - '; }echo $itOfficerContact; ?></h6>
                        </div>
                        <div class="col">
                  
                        </div>
                        <div class="col">
                     
                        </div>
                        <div class="col">
                          
                        </div>
                      </div>

                      <div class="row" style="margin-top: 1vw;">
                        <div class="col">
                          <label  style="font-weight: bold;">Description :</label>
                          <h6 align="justify" style="font-size: .9vw"><?php echo $description; ?></h6>
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

                      <div class="row" style="margin-top: 1vw;">
                        <div class="col">
                          <label  style="font-weight: bold;">With Contract :</label>
                          <h6 style="font-size: .9vw"><?php echo ucwords($withContract) ?></h6>
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">DICTM Certified :</label>
                          <h6 style="font-size: .9vw"><?php echo ucwords($dictmCertified); ?></h6>
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">Type of IS :</label>
                          <h6 style="font-size: .9vw"><?php echo $typeIS; ?></h6>
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">Status of IS :</label>
                          <h6 style="font-size: .9vw"><?php echo $statusIS; ?></h6>
                        </div>
                      </div>

                      <div class="row" style="margin-top: 1vw;">
                        <div class="col">
                          <label  style="font-weight: bold;">System Document :</label>
                          <h6 style="font-size: .9vw"><?php echo ucwords($withContract) ?></h6>
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">User Manual :</label>
                          <h6 style="font-size: .9vw"><?php echo ucwords($dictmCertified); ?></h6>
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">User Acceptance :</label>
                          <h6 style="font-size: .9vw"><?php echo ucwords($userAcceptance); ?></h6>
                        </div>
                        <div class="col">
                          
                        </div>
                      </div>

                      <div class="row" style="margin-top: 1vw;">
                        <div class="col">
                          <label  style="font-weight: bold;">Remarks :</label>
                          <h6 align="justify" style="font-size: .9vw"><?php echo $remarks; ?></h6>
                        </div>
                      </div>

                      <div class="row" style="margin-top: 1vw;">
                        <div class="col-9">
                          <label style="font-weight: bold;">Developed By :</label>
                          <h6 style="font-size: .9vw"><?php echo $developedBy; if($developedByEmail != ''){ echo ' - '; } echo $developedByEmail; if($developedByContact != ''){ echo ' - '; }echo $developedByContact; ?></h6>
                        </div>
                        <div class="col">
                  
                        </div>
                        <div class="col">
                     
                        </div>
                        <div class="col">
                          
                        </div>
                      </div>

                      <div class="row" style="margin-top: 1vw;">
                        <div class="col">
                          <label  style="font-weight: bold;">Date Initiated :</label>
                          <?php if($dateInitiated == ''): ?>
                            <h6 style="margin-left: 2.5vw; font-size: .9vw"><?php echo '-' ?></h6>
                          <?php else: ?>
                            <h6 style="font-size: .9vw"><?php echo ucwords($dateInitiated) ?></h6>
                          <?php endif; ?>
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">Development Date :</label>
                          <?php if($developmentDate == ''): ?>
                            <h6 style="margin-left: 2.5vw; font-size: .9vw"><?php echo '-' ?></h6>
                          <?php else: ?>
                            <h6 style="font-size: .9vw"><?php echo ucwords($developmentDate) ?></h6>
                          <?php endif; ?>
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">Turn-Over Date :</label>
                          <?php if($turnOverDate == ''): ?>
                            <h6 style="margin-left: 2.5vw; font-size: .9vw"><?php echo '-' ?></h6>
                          <?php else: ?>
                            <h6 style="font-size: .9vw"><?php echo ucwords($turnOverDate) ?></h6>
                          <?php endif; ?>
                        </div>
                        <div class="col">
                          <label  style="font-weight: bold;">Implementation Date :</label>
                          <?php if($implementDate == ''): ?>
                            <h6 style="margin-left: 3.5vw; font-size: .9vw"><?php echo '-' ?></h6>
                          <?php else: ?>
                            <h6 style="font-size: .9vw"><?php echo ucwords($implementDate) ?></h6>
                          <?php endif; ?>
                        </div>
                      </div>

                      <div class="row" style="margin-top: 1vw;">
                        <div class="col">
                          <label style="font-weight: bold;">Last Year Cleansed :</label>
                          <h6 style="font-size: .9vw"><?php echo $cleansedDate; ?></h6>
                        </div>
                        <div class="col">
                          <label style="font-weight: bold;">Date Added :</label>
                          <h6 style="font-size: .9vw"><?php echo $dateAdded; ?></h6>
                        </div>
                        <div class="col">
                          <label style="font-weight: bold;">Prepared By :</label>
                          <h6 style="font-size: .9vw"><?php echo $preparedBy; ?></h6>
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
                      <a href="../deleted/?page=<?php echo $_SESSION['pageSystem']; ?>" class="btn btn-danger">Close</a>
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
                
                <h5 class="modal-title" id="exampleModalLabel">Recover System</h5>
                <a href="../deleted/?page=<?php echo $_COOKIE["page"]; ?>" class="close"><span aria-hidden="true" style="color:white;">&times;</span></a>
              </div>

              <form action="process.php" method="POST">
                <div class="modal-body">
                  Are you sure you want to recover this system?
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-success" name="btnYesA">Yes</button>
                  <a href="../deleted/?page=<?php echo $_COOKIE["page"]; ?>" class="btn btn-danger" name="btnNo">No</a>
                </div>
              </form>
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
          
          document.getElementById("systems").style.color = "black";
          document.getElementById("systems").style.fontWeight = "bold";
      }

      function systemView(id){
        location.href = "../deleted/?view=" + id;
      }

      $('#addAccount').on('hidden.bs.modal', function () {
        location.href = "../deleted/"
      })

      $('#deleteAccount').on('hidden.bs.modal', function () {
        location.href = "../deleted/"
      })

      $('#activateAccount').on('hidden.bs.modal', function () {
        location.href = "../deleted/"
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