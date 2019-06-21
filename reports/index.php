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

        <img src="..//images//logo-itms.png" id="logo" height="0" width="0" style="display: none;">
        
        <div class="loader" id="loader"></div>

        <div class="custom-container">
            <!-----TITLE----->
            <div class="row">
                <div class="col" id="accountTitle">
                    <h1 align="center">Reports</h1>
                    <hr>
                </div>
            </div>

            <!-----FILTERS-----> 
            <form action="../reports/" method="POST" style="display: grid; justify-items: center;">
                <div class="row" id="reportFilters" style="width: 70%;">
                    <strong><label for="fromValue">From</label></strong>
                    <div class="col-xl" style="margin-top: 1rem;">
                        <div class="form-group">
                            <input type="date" name="fromValue" class="form-control">
                        </div>  
                    </div>
                    <strong><label for="toValue">To</label></strong>
                    <div class="col-xl" style="margin-top: 1rem">
                        <div class="form-group">
                            <input type="date" name="toValue" class="form-control" >
                        </div> 
                    </div>
                    <div class="col-xl-3" style="text-align: center;">
                        <div class="form-group">
                            <button class="btn btn-outline-info" name="generate" id="btnGenerate" style="margin-right: .25rem; margin-top: 1rem">Generate</button>
                            <button class="btn btn-outline-info" name="clear" name="clear" id="btnClear" style="margin-right: .25rem; margin-top: 1rem;">Clear</button>
                        </div>
                    </div>
                </div>
            </form>
          
          <hr>

        <?php
            require '../connection.php';
            if(isset($_POST['generate'])){
                $from = $_POST['fromValue'];
                $to = $_POST['toValue'];
                $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND status != 'inactive' AND typeIS = 'Administrative' ORDER BY name ASC") or die($mysqli->error);
                $result2 = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND status != 'inactive' AND typeIS = 'Operations IS' ORDER BY name ASC") or die($mysqli->error);
                $result3 = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND status != 'inactive' AND typeIS = 'Support to Operations IS' ORDER BY name ASC") or die($mysqli->error);


                $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND status != 'inactive' AND typeIS = 'Administrative' ORDER BY name ASC") or die($mysqli->error);
                $rowCount = $resultCount->fetch_assoc();
                $resultCount2 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND status != 'inactive' AND typeIS = 'Operations IS' ORDER BY name ASC") or die($mysqli->error);
                $rowCount2 = $resultCount2->fetch_assoc();
                $resultCount3 = $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND status != 'inactive' AND typeIS = 'Support to Operations IS' ORDER BY name ASC") or die($mysqli->error);
                $rowCount3 = $resultCount3->fetch_assoc();
            }
            else{
                $result = "";
                $result2 = "";
                $result3 = "";
            }

        ?>
        

        <?php if(isset($_POST['generate'])): ?>
        <p align="center" style="font-size: 12pt; font-weight: bold;"><?php if($from != "" && $to != ""){ echo "As of ". $from . " to " . $to; }else{ echo "As of Today"; } ?></p>
        <p align="center"><?php echo "<strong>Total No. of IS: </strong>"; echo $rowCount['count'] + $rowCount2['count'] + $rowCount3['count'] ?></p>
        <?php endif; ?>
        <h5 align="center" <?php if($result == ""): ?> style="display:none;" <?php endif; ?>>ADMINISTRATIVE</h5>
        <table class="table table-striped table-bordered table-responsive" id="tblReports" <?php if($result == "" || $rowCount['count'] == 0): ?> style="display:none;" <?php endif; ?> style="font-size: 11pt;">
            <thead>
                <tr>
                    <th></th>
                    <th style="width: 20vw;">Name</th>
                    <th style="width: 10vw;">PNP Office/ Unit</th>
                    <th style="width: 10vw;">IT Officer/Personnel</th>
                    <th style="width: 40vw;">Description</th>
                    <th style="width: 40vw;">Environment</th>
                    <th style="width: 40vw;">Application Functionality</th>
                    <th style="width: 40vw;">Operating System</th>
                    <th style="width: 40vw;">Back-End</th>
                    <th style="width: 40vw;">Total No. of Records</th>
                    <th style="width: 40vw;">Database Security</th>
                    <th style="width: 40vw;">Source</th>
                    <th style="width: 40vw;">With Contract</th>
                    <th style="width: 40vw;">DICTM Certified</th>
                    <th style="width: 40vw;">Type of IS</th>
                    <th style="width: 40vw;">Status of IS</th>
                    <th style="width: 40vw;">System Document</th>
                    <th style="width: 40vw;">User Manual</th>
                    <th style="width: 40vw;">User Acceptance</th>
                    <th style="width: 40vw;">Remarks</th>
                    <th style="width: 40vw;">Developed By</th>
                    <th style="width: 40vw;">Date Initiated</th>
                    <th style="width: 40vw;">Development Date</th>
                    <th style="width: 40vw;">Turn-Over Date</th>
                    <th style="width: 40vw;">Implementation Date</th>
                    <th style="width: 40vw;">Last Year Cleansed</th>
                    <th style="width: 40vw;">Date Reported</th>
                    <th style="width: 40vw;">Prepared By</th>
                </tr>
            </thead>
              
            <?php if($result != ""): $i = 1; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td id="name"><?php echo $row['name'] ?></td>
                        <td id="office" align="center"><?php echo $row['office'] ?></td>
                        <td id="itOfficer"><?php echo $row['itOfficer'] ?></td>
                        <td id="description" align="justify"><?php echo $row['description'] ?></td> 
                        <td id="environment"><?php echo $row['environment'] ?></td>
                        <td id="appFunction">
                            <?php 
                                $appFunction = $row['appFunction'];
                                $resultAppFunction = $mysqli->query("SELECT * FROM tblappfunction WHERE id = '$appFunction'") or die($mysqli->error());
                                $rowAppFunction = $resultAppFunction->fetch_assoc();
                                echo $rowAppFunction['appFunctionality'] 
                            ?>
                        </td>
                        <td id="operatingSystem"><?php echo $row['operatingSystem'] ?></td>
                        <td id="backEnd"><?php echo $row['backEnd'] ?></td>
                        <td id="numRecords"><?php echo $row['numRecords'] ?></td>
                        <td id="dbSecurity"><?php echo $row['dbSecurity'] ?></td>
                        <td id="source"><?php echo $row['source'] ?></td>
                        <td id="withContract" align="center"><?php if($row['withContract'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td>
                        <td id="dictmCertified" align="center"><?php if($row['dictmCertified'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td>
                        <td id="typeIS"><?php echo $row['typeIS'] ?></td>
                        <td id="statusIS"><?php echo $row['statusIS'] ?></td>
                        <td id="systemDoc" align="center"><?php if($row['systemDoc'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td> 
                        <td id="userManual" align="center"><?php if($row['userManual'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td> 
                        <td id="userAcceptance" align="center"><?php if($row['userAcceptance'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td> 
                        <td id="remarks"><?php echo $row['remarks'] ?></td>
                        <td id="developedBy"><?php echo $row['developedBy'] ?></td>
                        <td id="dateInitiated"><?php echo $row['dateInitiated'] ?></td>
                        <td id="developmentDate"><?php echo $row['developmentDate'] ?></td>
                        <td id="turnOverDate"><?php echo $row['turnOverDate'] ?></td>
                        <td id="implementDate"><?php echo $row['implementDate'] ?></td>
                        <td id="cleansedDate"><?php if($row['cleansedDate'] != '0000'){ echo date('Y-d-m h:i:s a', strtotime($row['cleansedDate'])); } ?></td>
                        <td id="dateAdded"><?php echo date('Y-d-m h:i:s a', strtotime($row['dateAdded'])) ?></td>  
                        <td id="preparedBy"><?php echo $row['preparedBy'] ?></td> 
                    </tr> 
                <?php endwhile; ?>
     
              <?php endif ?>

            </table>

            <form method="GET" id="accountsPagination">
                <?php if(isset($_POST['generate'])): ?>
                    <p id="tableCount"><?php echo $rowCount['count'] ?> Search Result</p>
                <?php endif; ?>
            </form>

            <hr <?php if($result == ""): ?> style="display:none;" <?php endif; ?>>

            <h5 align="center" <?php if($result2 == ""): ?> style="display:none;" <?php endif; ?>>OPERATIONS INFORMATION SYSTEM</h5>
            <table class="table table-striped table-bordered table-responsive" id="tblReports2" <?php if($result2 == "" || $rowCount2['count'] == 0): ?> style="display:none;" <?php endif; ?> style="font-size: 11pt;">
                <thead>
                    <tr>
                        <th></th>
                        <th style="width: 20vw;">Name</th>
                        <th style="width: 10vw;">PNP Office/ Unit</th>
                        <th style="width: 10vw;">IT Officer/Personnel</th>
                        <th style="width: 40vw;">Description</th>
                        <th style="width: 40vw;">Environment</th>
                        <th style="width: 40vw;">Application Functionality</th>
                        <th style="width: 40vw;">Operating System</th>
                        <th style="width: 40vw;">Back-End</th>
                        <th style="width: 40vw;">Total No. of Records</th>
                        <th style="width: 40vw;">Database Security</th>
                        <th style="width: 40vw;">Source</th>
                        <th style="width: 40vw;">With Contract</th>
                        <th style="width: 40vw;">DICTM Certified</th>
                        <th style="width: 40vw;">Type of IS</th>
                        <th style="width: 40vw;">Status of IS</th>
                        <th style="width: 40vw;">System Document</th>
                        <th style="width: 40vw;">User Manual</th>
                        <th style="width: 40vw;">User Acceptance</th>
                        <th style="width: 40vw;">Remarks</th>
                        <th style="width: 40vw;">Developed By</th>
                        <th style="width: 40vw;">Date Initiated</th>
                        <th style="width: 40vw;">Development Date</th>
                        <th style="width: 40vw;">Turn-Over Date</th>
                        <th style="width: 40vw;">Implementation Date</th>
                        <th style="width: 40vw;">Last Year Cleansed</th>
                        <th style="width: 40vw;">Date Reported</th>
                        <th style="width: 40vw;">Prepared By</th>
                    </tr>
                </thead>
              
                <?php if($result2 != ""): $i = 1; ?>
                <?php while($row2 = $result2->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td id="name"><?php echo $row2['name'] ?></td>
                        <td id="office" align="center"><?php echo $row2['office'] ?></td>
                        <td id="itOfficer"><?php echo $row2['itOfficer'] ?></td>
                        <td id="description" align="justify"><?php echo $row2['description'] ?></td> 
                        <td id="environment"><?php echo $row2['environment'] ?></td>
                                  <td id="appFunction">
                            <?php 
                                $appFunction2 = $row2['appFunction'];
                                $resultAppFunction2 = $mysqli->query("SELECT * FROM tblappfunction WHERE id = '$appFunction2'") or die($mysqli->error());
                                $rowAppFunction2 = $resultAppFunction2->fetch_assoc();
                                echo $rowAppFunction2['appFunctionality'] 
                            ?>
                        </td>
                        <td id="operatingSystem"><?php echo $row2['operatingSystem'] ?></td>
                        <td id="backEnd"><?php echo $row2['backEnd'] ?></td>
                        <td id="numRecords"><?php echo $row2['numRecords'] ?></td>
                        <td id="dbSecurity"><?php echo $row2['dbSecurity'] ?></td>
                        <td id="source"><?php echo $row2['source'] ?></td>
                        <td id="withContract" align="center"><?php if($row2['withContract'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td>
                        <td id="dictmCertified" align="center"><?php if($row2['dictmCertified'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td>
                        <td id="typeIS"><?php echo $row2['typeIS'] ?></td>
                        <td id="statusIS"><?php echo $row2['statusIS'] ?></td>
                        <td id="systemDoc" align="center"><?php if($row2['systemDoc'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td> 
                        <td id="userManual" align="center"><?php if($row2['userManual'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td> 
                        <td id="userAcceptance" align="center"><?php if($row2['userAcceptance'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td> 
                        <td id="remarks"><?php echo $row2['remarks'] ?></td>
                        <td id="developedBy"><?php echo $row2['developedBy'] ?></td>
                        <td id="dateInitiated"><?php echo $row2['dateInitiated'] ?></td>
                        <td id="developmentDate"><?php echo $row2['developmentDate'] ?></td>
                        <td id="turnOverDate"><?php echo $row2['turnOverDate'] ?></td>
                        <td id="implementDate"><?php echo $row2['implementDate'] ?></td>
                        <td id="cleansedDate"><?php if($row2['cleansedDate'] != '0000'){ echo date('Y-d-m h:i:s a', strtotime($row2['cleansedDate'])); } ?></td>
                        <td id="dateAdded"><?php echo date('Y-d-m h:i:s a', strtotime($row2['dateAdded'])) ?></td>  
                        <td id="preparedBy"><?php echo $row2['preparedBy'] ?></td>
                    </tr> 
                <?php endwhile; ?>
     
              <?php endif ?>

            </table>

            <form method="GET" id="accountsPagination">
                <?php if(isset($_POST['generate'])): ?>
                    <p id="tableCount2"><?php echo $rowCount2['count'] ?> Search Result</p>
                <?php endif; ?>
            </form>

            <hr <?php if($result == ""): ?> style="display:none;" <?php endif; ?>>

            <h5 align="center" <?php if($result3 == ""): ?> style="display:none;" <?php endif; ?> id="title3">SUPPORT TO OPERATIONS INFORMATION SYSTEM</h5>
            <table class="table table-striped table-bordered table-responsive" id="tblReports3" <?php if($result3 == "" || $rowCount3['count'] == 0): ?> style="display:none;" <?php endif; ?> style="font-size: 11pt;">
                <thead>
                    <tr>
                        <th></th>
                        <th style="width: 20vw;">Name</th>
                        <th style="width: 10vw;">PNP Office/ Unit</th>
                        <th style="width: 10vw;">IT Officer/Personnel</th>
                        <th style="width: 40vw;">Description</th>
                        <th style="width: 40vw;">Environment</th>
                        <th style="width: 40vw;">Application Functionality</th>
                        <th style="width: 40vw;">Operating System</th>
                        <th style="width: 40vw;">Back-End</th>
                        <th style="width: 40vw;">Total No. of Records</th>
                        <th style="width: 40vw;">Database Security</th>
                        <th style="width: 40vw;">Source</th>
                        <th style="width: 40vw;">With Contract</th>
                        <th style="width: 40vw;">DICTM Certified</th>
                        <th style="width: 40vw;">Type of IS</th>
                        <th style="width: 40vw;">Status of IS</th>
                        <th style="width: 40vw;">System Document</th>
                        <th style="width: 40vw;">User Manual</th>
                        <th style="width: 40vw;">User Acceptance</th>
                        <th style="width: 40vw;">Remarks</th>
                        <th style="width: 40vw;">Developed By</th>
                        <th style="width: 40vw;">Date Initiated</th>
                        <th style="width: 40vw;">Development Date</th>
                        <th style="width: 40vw;">Turn-Over Date</th>
                        <th style="width: 40vw;">Implementation Date</th>
                        <th style="width: 40vw;">Last Year Cleansed</th>
                        <th style="width: 40vw;">Date Reported</th>
                        <th style="width: 40vw;">Prepared By</th>
                    </tr>
                </thead>
              
                <?php if($result3 != ""): $i = 1; ?>
                <?php while($row3 = $result3->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td id="name"><?php echo $row3['name'] ?></td>
                        <td id="office" align="center"><?php echo $row3['office'] ?></td>
                        <td id="itOfficer"><?php echo $row3['itOfficer'] ?></td>
                        <td id="description" align="justify"><?php echo $row3['description'] ?></td> 
                        <td id="environment"><?php echo $row3['environment'] ?></td>
                        <td id="appFunction">
                            <?php 
                                $appFunction3 = $row3['appFunction'];
                                $resultAppFunction3 = $mysqli->query("SELECT * FROM tblappfunction WHERE id = '$appFunction3'") or die($mysqli->error());
                                $rowAppFunction3 = $resultAppFunction3->fetch_assoc();
                                echo $rowAppFunction3['appFunctionality'] 
                            ?>
                        </td>
                        <td id="operatingSystem"><?php echo $row3['operatingSystem'] ?></td>
                        <td id="backEnd"><?php echo $row3['backEnd'] ?></td>
                        <td id="numRecords"><?php echo $row3['numRecords'] ?></td>
                        <td id="dbSecurity"><?php echo $row3['dbSecurity'] ?></td>
                        <td id="source"><?php echo $row3['source'] ?></td>
                        <td id="withContract" align="center"><?php if($row3['withContract'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td>
                        <td id="dictmCertified" align="center"><?php if($row3['dictmCertified'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td>
                        <td id="typeIS"><?php echo $row3['typeIS'] ?></td>
                        <td id="statusIS"><?php echo $row3['statusIS'] ?></td>
                        <td id="systemDoc" align="center"><?php if($row3['systemDoc'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td> 
                        <td id="userManual" align="center"><?php if($row3['userManual'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td> 
                        <td id="userAcceptance" align="center"><?php if($row3['userAcceptance'] == 'yes'){ echo '✔'; }else{ echo '✖'; } ?></td> 
                        <td id="remarks"><?php echo $row3['remarks'] ?></td>
                        <td id="developedBy"><?php echo $row3['developedBy'] ?></td>
                        <td id="dateInitiated"><?php echo $row3['dateInitiated'] ?></td>
                        <td id="developmentDate"><?php echo $row3['developmentDate'] ?></td>
                        <td id="turnOverDate"><?php echo $row3['turnOverDate'] ?></td>
                        <td id="implementDate"><?php echo $row3['implementDate'] ?></td>
                        <td id="cleansedDate"><?php if($row3['cleansedDate'] != '0000'){ echo date('Y-d-m h:i:s a', strtotime($row3['cleansedDate'])); } ?></td>
                        <td id="dateAdded"><?php echo date('Y-d-m h:i:s a', strtotime($row3['dateAdded'])) ?></td>  
                        <td id="preparedBy"><?php echo $row3['preparedBy'] ?></td> 
                    </tr> 
                <?php endwhile; ?>
     
              <?php endif ?>

            </table>

            
            <form method="GET" id="accountsPagination">
                <?php if(isset($_POST['generate'])): ?>
                    <p id="tableCount3"><?php echo $rowCount3['count'] ?> Search Result</p>
                <?php endif; ?>
            </form>

            <div class="row" id="reportFilters" style="margin-bottom: 3.15rem;">
            <div class="col-xl">
                <?php if(isset($_POST['generate'])): ?>
                    <button type=button class="btn btn-default" id="btnExport" name="btnExport" style="float:right; margin-right: .5rem;" onclick="exportTableToExcel('tblReports', 'tblReports2', 'tblReports3', 'inventoryReport')">Export</button>
                <?php endif; ?>
            </div>
        </div>

        </div>

        <?php
            $resultMinDate = $mysqli->query("SELECT DATE(dateAdded) AS dateAdded FROM tblsystems ORDER BY dateADDED ASC LIMIT 1") or die($mysqli->error());
            $rowMinDate = $resultMinDate->fetch_assoc();
            $minDate = ($rowMinDate['dateAdded']);
        ?>

        <script>   
            function exportTableToExcel(tableID, tableID2, tableID3, filename = ''){
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';

                var tableSelect = document.getElementById(tableID);
                var tableSelect2 = document.getElementById(tableID2);
                var tableSelect3 = document.getElementById(tableID3);

                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
                var tableHTML2 = tableSelect2.outerHTML.replace(/ /g, '%20');
                var tableHTML3 = tableSelect3.outerHTML.replace(/ /g, '%20');
             
                // Create download link element
                downloadLink = document.createElement("a");
                
                document.body.appendChild(downloadLink);
                
                if(navigator.msSaveOrOpenBlob){
                    var blob = new Blob(['\ufeff', tableHTML, tableHTML2, tableHTML3], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob( blob, filename);
                }else{
                    // Create a link to the file
                    downloadLink.href = 'data:' + dataType + ';charset=utf-8,%EF%BB%BF' + '<h3><strong>ADMINISTRATIVE</strong></h3>' + tableHTML + '<h3><strong>OPERATIONS-IS</strong></h3>' + tableHTML2 + '<h3><strong>SUPPORT-TO-OPERATIONS-IS</strong></h3>' + tableHTML3;
                
                    // Setting the file name
                    downloadLink.download = filename;
                    
                    //triggering the function
                    downloadLink.click();
                }
            }


            function loading(){
                var loader = document.getElementById("loader");
                loader.style.display = "none";
                var pageSystem = "<?php $_SESSION['pageSystem'] = 1; ?>";
                var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";
                
                document.getElementById("reports").style.color = "black";
                document.getElementById("reports").style.fontWeight = "bold";
            }

            // $('#btnPrint').click(function(){
            //     var from = "<?php if(isset($from)){  echo $from; }else { echo ""; }?>";
            //     var to = "<?php if(isset($to)){  echo $to; }else { echo ""; }?>";    
            //     var table = document.getElementById('tblReports');
            //     var table2 = document.getElementById('tblReports2');
            //     var table3 = document.getElementById('tblReports3');
            //     var logo = document.getElementById('logo');

            //     var tableCount = document.getElementById('tableCount').innerHTML;
            //     var tableCount2 = document.getElementById('tableCount2').innerHTML;
            //     var tableCount3 = document.getElementById('tableCount3').innerHTML;

            //     var printPreview = window.open('', '', 'width=screen.width,height=screen.height,toolbar=yes,scrollbars=yes,status=yes,menubar=yes');

            //     printPreview.document.write('');
            //     printPreview.document.write('<style>@page { margin: 0; margin-right: .5vw; margin-left: .4vw; margin-top: .5vw; margin-bottom: .5vw; } #tableCount { page-break-after:always; } table{ border-spacing: 0; } table, td, th, thead, tr{ font-size: 8pt; padding: 0px; } table th{ background: #007bff; color: white; } table td, th{ border: 1px solid lightgrey; } table th, td{ padding-left: .5vw; padding-right: .5vw; } body{ font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; } #name{ width: 15vw; } #description{ width: 15vw; } #environment{ width: 10vw; } #devTool { width: 15vw; } #backEnd{ width: 25vw; } #source{ width: 20vw; } #remarks{ width: 10vw; } #logo{ float: left; margin-left: .2vw; margin-top: .3vw; width: 70px; height: 70px; }</style>');
                
            //     document.getElementById('logo').style.display = "block";
            //     printPreview.document.write('<p align="center" style="font-size: 12pt; margin-right: 6.5vw;">' + logo.outerHTML + 'Information System Inventory </p>');
            //     document.getElementById('logo').style.display = "none";
            //     printPreview.document.write('<p align="center" style="font-size: 8pt; margin-right: 6.5vw;">As of ' + from + " " + 'to ' + to + '</p>');
            //     printPreview.document.write('<h1 align="center" style="font-size: 12pt; margin-right: 6.5vw;">ADMINISTRATIVE</h1>');
            //     printPreview.document.write(table.outerHTML);
            //     printPreview.document.write('<p align="center" id="tableCount" style="font-size: 12pt; ">' + tableCount + '</p>');
               

            //     document.getElementById('logo').style.display = "block";
            //     printPreview.document.write('<p align="center" style="font-size: 12pt; margin-right: 6.5vw;">' + logo.outerHTML + 'Information System Inventory </p>');
            //     document.getElementById('logo').style.display = "none";
            //     printPreview.document.write('<p align="center" style="font-size: 8pt; margin-right: 6.5vw;">As of ' + from + " " + 'to ' + to + '</p>');
            //     printPreview.document.write('<h1 align="center" style="font-size: 12pt; margin-right: 6.5vw;">OPERATIONS INFORMATION SYSTEM</h1>');
            //     printPreview.document.write(table2.outerHTML);
            //     printPreview.document.write('<p align="center" id="tableCount" style="font-size: 12pt;">' + tableCount2 + '</p>');
               
               
            //     document.getElementById('logo').style.display = "block";
            //     printPreview.document.write('<p align="center" style="font-size: 12pt; margin-right: 6.5vw;">' + logo.outerHTML + 'Information System Inventory </p>');
            //     document.getElementById('logo').style.display = "none";
            //     printPreview.document.write('<p align="center" style="font-size: 8pt; margin-right: 6.5vw;">As of ' + from + " " + 'to ' + to + '</p>');
            //     printPreview.document.write('<h1 align="center" style="font-size: 12pt; margin-right: 6.5vw;">SUPPORT TO OPERATIONS INFORMATION SYSTEM</h1>');
            //     printPreview.document.write(table3.outerHTML);
            //     printPreview.document.write('<p align="center" id="tableCount" style="font-size: 12pt;">' + tableCount3 + '</p>');
              
            //     printPreview.document.close();

            //     printPreview.focus(); 
            //     printPreview.print(); 
            //     printPreview.close();
      
            // })
         
            var maxDate = new Date().toISOString().split('T')[0];
            var minDate = "<?php echo $minDate; ?>";
            document.getElementsByName("toValue")[0].setAttribute('max', maxDate);
            document.getElementsByName("toValue")[0].setAttribute('min', minDate);

            document.getElementsByName("fromValue")[0].setAttribute('max', maxDate);
            document.getElementsByName("fromValue")[0].setAttribute('min', minDate);

        </script>


    </body>
</html>