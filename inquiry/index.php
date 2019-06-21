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

        <img src="..//images//logo-itms.png" id="logo" height="0" width="0" style="display: none;">

        <div class="custom-container">

            <!-----TITLE----->
            <div class="row">
                <div class="col" id="accountTitle">
                    <h1 align="center">Inquiry</h1>
                    <hr>
                </div>
            </div>

           <!-----FILTERS-----> 
           <form action="../inquiry/" method="POST" style="display: grid; justify-items: center;">
            <div class="row" id="inquiryFilters" style="width: 95%;">
              <div class="col-xl">
                <div class="row">
                  <strong><label for="fromValue">From</label></strong>
                  <div class="col-xl" style="margin-top: 1rem;">
                    <div class="form-group">
                      <input type="date" name="fromValue" class="form-control">
                    </div>  
                  </div>
                  <strong><label for="toValue">To</label></strong>
                  <div class="col-xl" style="margin-top: 1rem;">
                    <div class="form-group">
                      <input type="date" name="toValue" class="form-control" >
                    </div> 
                  </div>
                  <div class="col-xl" style="margin-top: 1rem;">
                    <div class="form-group">
                      <input type="text" name="nameValue" class="form-control" placeholder="Name of Information System">
                    </div>  
                  </div>
                  <div class="col-xl" style="margin-top: 1rem;">
                    <div class="form-group" id="formGroup">
                        <select class="custom-select" name="groupValue" id="groupValue">
                            <option value="" selected>-Select Office/Unit Group-</option>
                            <option value="Command Group">Command Group</option>
                            <option value="P-Staff/Other Staff">P-Staff/Other Staff</option>
                            <option value="D-Staff">D-Staff</option>
                            <option value="NASU">NASU</option>
                            <option value="NOSU">NOSU</option>
                            <option value="NCRPO">NCRPO</option>
                            <option value="PROs">PROs</option>
                        </select>
                    </div> 
                    <div class="form-group" id="formOffice" style="display: none">
                        <select class="custom-select" name="officeValue" id="officeValue">
                            <option value="" selected>-Select Office/Unit-</option>
                            <option value="">All</option>
                        </select>
                    </div>   
                  </div>
                </div>
                <div class="row">
                  <strong><label for="toValue" style="visibility: hidden;" class="d-none d-lg-block">From</label></strong>
                  <div class="col-xl">
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
                  <strong><label for="toValue" style="visibility: hidden;" class="d-none d-lg-block">To</label></strong>
                  <div class="col-xl">
                    <div class="form-group">
                        <select class="custom-select" name="typeValue">
                            <option value="" selected>-Select IS Type-</option>
                            <option value="">All</option>
                            <option value="Administrative">Administrative</option>
                            <option value="Operations IS">Operations IS</option>
                            <option value="Support to Operations IS">Support to Operations IS</option>
                        </select>
                    </div> 
                  </div>       
                  <div class="col-xl">
                    <div class="form-group">
                        <select class="custom-select" name="environmentValue">
                            <option value="" selected>-Select Environment-</option>
                            <option value="">All</option>
                            <option value="LAN-Based">LAN-Based</option>
                            <option value="WEB-Based">Web-Based</option>
                            <option value="CLOUD-Based">Cloud-Based</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>  
                  </div>
                  <div class="col-xl">
                    <div class="form-group">
                        <select class="custom-select" name="sourceValue">
                            <option value="" selected>-Select Source-</option>
                            <option value="">All</option>
                            <option value="In-House (by ITMS)">In-House (by ITMS)</option>
                            <option value="In-House (c/o Unit)">In-House (c/o Unit)</option>
                            <option value="Outsource">Outsource</option>
                        </select>
                    </div> 
                  </div>
                </div>
              </div>
              <div class="col-xl-1">
                <div class="row">
                    <div class="col-xl" style="text-align: center;">
                        <div class="form-group">
                            <button class="btn btn-outline-info" name="generate" style="margin-top: 1rem">Generate</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl" style="text-align: center;">
                        <div class="form-group">
                            <button class="btn btn-outline-info" name="clear" name="clear" id="btnClear">Clear</button>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </form>

          <hr>

        <?php
           if(isset($_POST['generate'])){
                $from = $_POST['fromValue'];
                $to = $_POST['toValue'];
                $name  = $_POST['nameValue'];
                $office  = $_POST['officeValue'];
                $statusIS = $_POST['statusValue'];
                $typeIS = $_POST['typeValue'];
                $environment = $_POST['environmentValue'];
                $source = $_POST['sourceValue'];

                
                if($from != '' && $to != '' ){
                    if($name != ''){
                        if($office != ''){
                            if($statusIS != ''){
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                            else{
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%' AND office LIKE '%$office%' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                        }
                        else{
                            if($statusIS != ''){
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                            else{
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND name LIKE '%$name%'  AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else{
                        if($office != ''){
                            if($statusIS != ''){
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                            else{
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to') AND office LIKE '%$office%' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                        }
                        else{
                            if($statusIS != ''){
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                            else{
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE (DATE(dateAdded) BETWEEN '$from' AND '$to')  AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else{
                    if($name != ''){
                        if($office != ''){
                            if($statusIS != ''){
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                            else{
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%' AND office LIKE '%$office%' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                        }
                        else{
                            if($statusIS != ''){
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                            else{
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  name LIKE '%$name%'  AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  name LIKE '%$name%'  AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else{
                        if($office != ''){
                            if($statusIS != ''){
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                            else{
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  office LIKE '%$office%' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  office LIKE '%$office%' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                        }
                        else{
                            if($statusIS != ''){
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  statusIS = '$statusIS' AND typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  statusIS = '$statusIS' AND typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  statusIS = '$statusIS' AND typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  statusIS = '$statusIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  statusIS = '$statusIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  statusIS = '$statusIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  statusIS = '$statusIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                            else{
                                if($typeIS != ''){
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  typeIS = '$typeIS' AND environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  typeIS = '$typeIS' AND environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  typeIS = '$typeIS' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  typeIS = '$typeIS' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                                else{
                                    if($environment != ''){
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  environment = '$environment' AND source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  environment = '$environment' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                    else{
                                        if($source != ''){
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  source = '$source' AND status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                        else{
                                            $result = $mysqli->query("SELECT * FROM tblsystems WHERE  status != 'inactive' ORDER BY name ASC") or die($mysqli->error);

                                            $resultCount = $mysqli->query("SELECT COUNT(*) AS count  FROM tblsystems WHERE  status != 'inactive' ORDER BY name ASC") or die($mysqli->error);
                                            $rowCount = $resultCount->fetch_assoc();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else{
                $result = "";
            }

        ?>

        <?php if(isset($_POST['generate'])): ?>
        <p align="center" style="font-size: 12pt; font-weight: bold;"><?php if($from != "" && $to != ""){ echo "As of ". $from . " to " . $to; }else{ echo "As of Today"; } ?></p>
        <div class="row" style="display: grid; justify-items: center;">
            <div class="col-xl-10">
                <div class="row">
                    <div class="col-xl-2">

                    </div>
                    <div class="col-xl">
                        <div class="form-group">
                            <strong><label for="date">Name of IS:</label></strong>
                            <label align="justify" style="margin-left: 1rem;"><?php if($name == ""){ echo "All"; } else{ echo $name; } ?></label>
                        </div>
                    </div>
                    <div class="col-xl">
                        <div class="form-group">
                            <strong><label for="date">Name of Office/Unit:</label></strong>
                            <label align="justify" style="margin-left: 1rem;"><?php if($office == ""){ echo "All"; } else{ echo $office; } ?></label>
                        </div>
                    </div>
                    <div class="col-xl">
                        <div class="form-group">
                            <strong><label for="date">Status of IS:</label></strong>
                            <label align="justify" style="margin-left: 1rem;"><?php if($statusIS == ""){ echo "All"; } else{ echo $statusIS; } ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2">
                        
                    </div>
                    <div class="col-xl">
                        <div class="form-group">
                            <strong><label for="date">Type of IS:</label></strong>
                            <label align="justify" style="margin-left: 1rem;"><?php if($typeIS == ""){ echo "All"; } else{ echo $typeIS; } ?></label>
                        </div>
                    </div>
                    <div class="col-xl">
                        <div class="form-group">
                            <strong><label for="date">Environment:</label></strong>
                            <label align="justify" style="margin-left: 1rem;"><?php if($environment == ""){ echo "All"; } else{ echo $environment; } ?></label>
                        </div>
                    </div>
                    <div class="col-xl">
                        <div class="form-group">
                            <strong><label for="date">Source:</label></strong>
                            <label align="justify" style="margin-left: 1rem;"><?php if($source == ""){ echo "All"; } else{ echo $source; } ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <p align="center"><?php echo "<strong>Total No. of IS: </strong>"; echo $rowCount['count']; ?></p>
        <?php endif; ?>

        <table class="table table-striped table-bordered table-responsive" id="tblInquiry" <?php if($result == "" || $rowCount['count'] == 0): ?> style="display:none;"<?php endif; ?> style="font-size: 11pt;">
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

            <div class="row" id="inquiryFilters" style="margin-bottom: 3.15rem;">
                <div class="col-xl">
                    <?php if(isset($_POST['generate'])): ?>
                        <button type=button class="btn btn-default" id="btnExport" name="btnExport" style="float:right; margin-right: .5rem;" onclick="exportTableToExcel('tblInquiry', 'systemInquiry')">Export</button>
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
            function loading(){
                var loader = document.getElementById("loader");
                loader.style.display = "none";
                var pageSystem = "<?php $_SESSION['pageSystem'] = 1; ?>";
                var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";

                document.getElementById("inquiry").style.color = "black";
                document.getElementById("inquiry").style.fontWeight = "bold";
            }

            function exportTableToExcel(tableID, filename = ''){
                var typeIS = "<?php if(isset($typeIS)){  echo str_replace(' ','-', $typeIS); }else { echo ""; }?>";
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';

                var tableSelect = document.getElementById(tableID);


                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
             
                // Create download link element
                downloadLink = document.createElement("a");
                
                document.body.appendChild(downloadLink);
                
                if(navigator.msSaveOrOpenBlob){
                    var blob = new Blob(['\ufeff', tableHTML], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob( blob, filename);
                }else{
                    // Create a link to the file
                    downloadLink.href = 'data:' + dataType + ';charset=utf-8,%EF%BB%BF' + tableHTML;
                
                    // Setting the file name
                    downloadLink.download = filename;
                    
                    //triggering the function
                    downloadLink.click();
                }
            }

            // $('#btnPrint').click(function(){
            //     var from = "<?php if(isset($from)){  echo $from; }?>";
            //     var to = "<?php if(isset($to)){  echo $to; }?>";
            //     var name = "<?php if(isset($typeIS)){  echo $name; }?>";
            //     if(name == ""){
            //         name = "All";
            //     }
            //     var office = "<?php if(isset($office)){  echo $office; }?>";
            //     if(office == ""){
            //         office = "All";
            //     }
            //     var statusIS = "<?php if(isset($statusIS)){  echo $statusIS; }?>";
            //     if(statusIS == ""){
            //         statusIS = "All";
            //     }
            //     var typeIS = "<?php if(isset($typeIS)){  echo $typeIS; }?>";
            //     if(typeIS == ""){
            //         typeIS = "All";
            //     }
            //     var environment = "<?php if(isset($environment)){  echo $environment; }?>";
            //     if(environment == ""){
            //         environment = "All";
            //     }
            //     var source = "<?php if(isset($source)){  echo $source; }?>";
            //     if(source == ""){
            //         source = "All";
            //     }
                
            //     var table = document.getElementById('tblInquiry');
            //     var logo = document.getElementById('logo');

            //     var tableCount = document.getElementById('tableCount').innerHTML;

            //     var printPreview = window.open('', '', 'width=screen.width,height=screen.height,toolbar=yes,scrollbars=yes,status=yes,menubar=yes');

            //     printPreview.document.write('');
            //     printPreview.document.write('<style>@page { margin: 0; margin-right: .5vw; margin-left: .4vw; margin-top: .5vw; margin-bottom: .5vw; } #tableCount { page-break-after:always; } table{ border-spacing: 0; } table, td, th, thead, tr{ font-size: 8pt; padding: 5px; } table th{ background: #007bff; color: white; } table td, th{ border: 1px solid lightgrey; } table th, td{ padding-left: .5vw; padding-right: .5vw; } body{ font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; } #name{ width: 15vw; } #description{ width: 40vw; } #remarks{ width: 20vw; } #dateAdded{ width: 15vw; } #logo{ float: left; margin-left: .2vw; margin-top: .3vw; width: 70px; height: 70px; }</style>');
                
            //     document.getElementById('logo').style.display = "block";
            //     printPreview.document.write('<p align="center" style="font-size: 12pt; margin-right: 5vw;">' + logo.outerHTML + 'Information System Inventory </p>');
            //     if(from != "" || to != ""){
            //         printPreview.document.write('<p align="center" style="font-size: 10pt; margin-right: 5vw;">As of ' + from + ' to ' + to + '</p>');
            //     }
            //     else{
            //         printPreview.document.write('<p align="center" style="font-size: 10pt; margin-right: 5vw;">As of Today</p>');
            //     }
            //     printPreview.document.write('<div style="display: grid; justify-items: center; margin-right: 5vw;">');
            //     printPreview.document.write('<table cellpadding="0">');
            //     printPreview.document.write('<tr>');
            //     printPreview.document.write('<td valign="top" align="justify" style="font-size: 10pt; border: none; padding: .5rem; padding-right: 2rem;"><strong>Name of IS: </strong>' + name + '</td>');
            //     printPreview.document.write('<td valign="top" align="justify" style="font-size: 10pt; border: none; padding: .5rem; padding-right: 2rem;"><strong>Name of Office/Unit: </strong>' + office + '</td>');
            //     printPreview.document.write('<td valign="top" style="font-size: 10pt; border: none; padding: .5rem;"><strong>Status of IS: </strong>' + statusIS + '</td>');
            //     printPreview.document.write('</tr>');
            //     printPreview.document.write('<tr>');
            //     printPreview.document.write('<td valign="top" style="font-size: 10pt; border: none; padding: .5rem; padding-right: 2rem;"><strong>Type of IS: </strong>' + typeIS + '</td>');
            //     printPreview.document.write('<td valign="top" style="font-size: 10pt; border: none; padding: .5rem; padding-right: 2rem;"><strong>Environment: </strong>' + environment + '</td>');
            //     printPreview.document.write('<td valign="top" style="font-size: 10pt; border: none; padding: .5rem;"><strong>Source: </strong>' + source + '</td>');
            //     printPreview.document.write('</tr>');
            //     printPreview.document.write('</table>');
            //     printPreview.document.write('</div>');

            //     document.getElementById('logo').style.display = "none";
              
            //     printPreview.document.write(table.outerHTML);
            //     printPreview.document.write('<p align="center" id="tableCount" style="font-size: 12pt; ">' + tableCount + '</p>');          
              
            //     printPreview.document.close();

            //     printPreview.focus(); 
            //     printPreview.print(); 
            //     printPreview.close();
      
            // })

        $(document).ready(function () {
          $("#officeValue").change(function () {
            var val = $(this).val();
            if (val == "-Select Group-") {
              document.getElementById("formGroup").style.display = "block";
              document.getElementById("groupValue").selectedIndex = "0";
              document.getElementById("formOffice").style.display = "none";
            }
          });
        });


        $(document).ready(function () {
            $("#groupValue").change(function () {
                var val = $(this).val();
                if (val == "Command Group") {
                    $("#officeValue").html("<option selected value=''>-Select Command Group-</option><option value='OCPNP'>OCPNP</option><option value='TDCA'>TDCA</option><option value='TDCO'>TDCO</option><option value='TDCS/SDS'>TDCS/SDS</option><option value='-Select Group-'>-Select Group-</option>");
                    document.getElementById("formGroup").style.display = "none";
                    document.getElementById("formOffice").style.display = "block";
                } else if (val == "P-Staff/Other Staff") {
                    $("#officeValue").html("<option selected value=''>-Select P-Staff/Other Staff-</option><option value='SILG'>SILG</option><option value='PIO'>PIO</option><option value='CPSM'>CPSM</option><option value='CESPO'>CESPO</option><option value='IAS'>IAS</option><option value='HRAO'>HRAO</option><option value='WCPC'>WCPC</option><option value='ITG(DI)'>ITG(DI)</option><option value='CITF'>CITF</option><option value='-Select Group-'>-Select Group-</option>");
                    document.getElementById("formGroup").style.display = "none";
                    document.getElementById("formOffice").style.display = "block";
                } else if (val == "D-Staff") {
                    $("#officeValue").html("<option selected value=''>-Select D-Staff-</option><option value='DPRM'>DPRM</option><option value='DI'>DI</option><option value='DO'>DO</option><option value='DL'>DL</option><option value='DPL'>DPL</option><option value='DC'>DC</option><option value='DPCR'>DPCR</option><option value='DIDM'>DIDM</option><option value='DHRDD'>DHRDD</option><option value='DRD'>DRD</option><option value='DICTM'>DICTM</option><option value='WM'>WM</option><option value='EM'>EM</option><option value='VIS'>VIS</option><option value='NL'>NL</option><option value='SL'>SL</option><option value='-Select Group-'>-Select Group-</option>");
                    document.getElementById("formGroup").style.display = "none";
                    document.getElementById("formOffice").style.display = "block";
                } else if (val == "NASU") {
                    $("#officeValue").html("<option selected value=''>-Select NASU-</option><option value='LS'>LS</option><option value='ITMS'>ITMS</option><option value='FS'>FS</option><option value='HS'>HS</option><option value='CES'>CES</option><option value='PRBS'>PRBS</option><option value='CHS'>CHS</option><option value='LSS'>LSS</option><option value='HSS'>HSS</option><option value='ES'>ES</option><option value='TS'>TS</option><option value='-Select Group-'>-Select Group-</option>");
                    document.getElementById("formGroup").style.display = "none";
                    document.getElementById("formOffice").style.display = "block";
                } else if (val == "NOSU") {
                    $("#officeValue").html("<option selected value=''>-Select NOSU-</option><option value='MG'>MG</option><option value='IG'>IG</option><option value='PSPG'>PSPG</option><option value='CIDG'>CIDG</option><option value='SAF'>SAF</option><option value='ACG'>ACG</option><option value='ASG'>ASG</option><option value='HPG'>HPG</option><option value='PCRG'>PCRG</option><option value='CSG'>CSG</option><option value='CLG'>CLG</option><option value='AKG'>AKG</option><option value='-Select Group-'>-Select Group-</option>");
                    document.getElementById("formGroup").style.display = "none";
                    document.getElementById("formOffice").style.display = "block";
                } else if (val == "NCRPO") {
                    $("#officeValue").html("<option selected value=''>-Select NCRPO-</option><option value='MPD'>MPD</option><option value='SPD'>SPD</option><option value='NPD'>NPD</option><option value='EPD'>EPD</option><option value='QCPD'>QCPD</option><option value='NCRPO'>NCRPO</option><option value='-Select Group-'>-Select Group-</option>");
                    document.getElementById("formGroup").style.display = "none";
                    document.getElementById("formOffice").style.display = "block";
                } else if (val == "PROs") {
                    $("#officeValue").html("<option selected value=''>-Select PROs-</option><option value='PRO1'>PRO1</option><option value='PRO2'>PRO2</option><option value='PRO3'>PRO3</option><option value='PRO4A'>PRO4A</option><option value='PRO4B'>PRO4B</option><option value='PRO5'>PRO5</option><option value='PRO6'>PRO6</option><option value='PRO7'>PRO7</option><option value='PRO8'>PRO8</option><option value='PRO9'>PRO9</option><option value='PRO10'>PRO10</option><option value='PRO11'>PRO11</option><option value='PRO12'>PRO12</option><option value='PRO13'>PRO13</option><option value='PROCOR'>PROCOR</option><option value='PROARMM'>PROARMM</option><option value='-Select Group-'>-Select Group-</option>");
                    document.getElementById("formGroup").style.display = "none";
                    document.getElementById("formOffice").style.display = "block";
                } else {
                    $("#officeValue").html("<option selected value=''>-Select Office/Unit-</option>");
                }
            });
        });
         
        var maxDate = new Date().toISOString().split('T')[0];
        var minDate = "<?php echo $minDate; ?>";
        document.getElementsByName("toValue")[0].setAttribute('max', maxDate);
        document.getElementsByName("toValue")[0].setAttribute('min', minDate);

        document.getElementsByName("fromValue")[0].setAttribute('max', maxDate);
        document.getElementsByName("fromValue")[0].setAttribute('min', minDate);
   
        </script>


    </body>
</html>