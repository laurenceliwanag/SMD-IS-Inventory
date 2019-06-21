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
            <h1 align="center">Audit Trail</h1>
            <hr>
          </div>
        </div>

           <!-----FILTERS-----> 
          <form action="../audittrail/" method="POST" style="display: grid; justify-items: center;">
            <div class="row" id="auditFilters" style="width: 60%;">
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
                </div>
                <div class="row">
                  <strong><label for="fromValue" style="visibility: hidden;">From</label></strong>
                  <div class="col-xl">
                    <div class="form-group">
                      <input type="text" name="searchValue" class="form-control" placeholder="Search">
                    </div>  
                  </div>
                  <strong><label for="toValue" style="visibility: hidden;">To</label></strong>
                  <div class="col-xl">
                    <div class="form-group">
                      <select  class="custom-select" name="actionValue">
                        <option value="" selected>-Select Activity-</option>
                        <option value="">All</option>
                        <option value="Activated">Activated</option>
                        <option value="Added">Added</option>
                        <option value="Deactivated">Deactivated</option>
                        <option value="Deleted">Deleted</option>
                        <option value="Edited">Edited</option>
                        <option value="Recovered">Recovered</option>       
                      </select>
                    </div> 
                  </div>
                </div>
              </div>
              <div class="col-xl-2">
                      <div class="row">
                        <div class="col-xl" style="text-align: center;">
                          <div class="form-group">
                            <button class="btn btn-outline-info" name= "search" id="btnSearch" style="margin-top: 1rem">Search</button>
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
          
          
          <!-----ACCOUNT TABLE----->
          <div class="row">
            <div class="col" id="accountTable">
              <?php 
                require '../connection.php';
                $userId = $_SESSION['userId'];
                
                  if(isset($_POST['search'])){
                    $searchValue = $_POST['searchValue'];
                    $actionValue = $_POST['actionValue'];
                    $from = $_POST['fromValue'];
                    $to = $_POST['toValue'];
                    
                    if ($_POST['searchValue'] != ''){
                      if ($_POST['actionValue'] != ''){
                        if ($_POST['fromValue'] != '' && $_POST['toValue'] != '' ){
                          $result1 = $mysqli->query("SELECT COUNT(*) as count FROM(SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' AND A.action = '$actionValue' AND (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' AND tblsystemtrail.action = '$actionValue' AND (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to'))A") or die($mysqli->error);
                          $rowCount = $result1->fetch_assoc();
                          $resultCount = 11;
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
        
                          $result = $mysqli->query("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' AND A.action = '$actionValue' AND (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' AND tblsystemtrail.action = '$actionValue' AND (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to') ORDER BY dateModified DESC LIMIT 11") or die($mysqli->error);

                          $resultString = ("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' AND A.action = '$actionValue' AND (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' AND tblsystemtrail.action = '$actionValue' AND (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to') ORDER BY dateModified DESC");
                        }
                        else {
                          $result1 = $mysqli->query("SELECT COUNT(*) as count FROM(SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' AND A.action = '$actionValue' UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' AND tblsystemtrail.action = '$actionValue')A") or die($mysqli->error);
                          $rowCount = $result1->fetch_assoc();
                          $resultCount = 11;
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
        
                          $result = $mysqli->query("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' AND A.action = '$actionValue' UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' AND tblsystemtrail.action = '$actionValue' ORDER BY dateModified DESC LIMIT 11") or die($mysqli->error);

                          $resultString = ("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' AND A.action = '$actionValue' UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' AND tblsystemtrail.action = '$actionValue' ORDER BY dateModified DESC");
                        }
                      }
                      else {
                        if ($_POST['fromValue'] != '' && $_POST['toValue'] != '' ){
                          $result1 = $mysqli->query("SELECT COUNT(*) as count FROM(SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' AND (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' AND (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to'))A") or die($mysqli->error);
                          $rowCount = $result1->fetch_assoc();
                          $resultCount = 11;
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
        
                          $result = $mysqli->query("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' AND (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' AND (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to') ORDER BY dateModified DESC LIMIT 11") or die($mysqli->error);

                          $resultString = ("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' AND (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' AND (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to') ORDER BY dateModified DESC");
                        }
                        else {
                          $result1 = $mysqli->query("SELECT COUNT(*) as count FROM(SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%')A") or die($mysqli->error);
                          $rowCount = $result1->fetch_assoc();
                          $resultCount = 11;
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
        
                          $result = $mysqli->query("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' ORDER BY dateModified DESC LIMIT 11") or die($mysqli->error);

                          $resultString = ("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.accountId LIKE '%$searchValue%' UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystems.name LIKE '%$searchValue%' ORDER BY dateModified DESC");
                        }
                      }
                    }
                    else{
                      if ($_POST['actionValue'] != ''){
                        if ($_POST['fromValue'] != '' && $_POST['toValue'] != '' ){
                          $result1 = $mysqli->query("SELECT COUNT(*) as count FROM(SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.action = '$actionValue' AND (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystemtrail.action = '$actionValue' AND (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to'))A") or die($mysqli->error);
                          $rowCount = $result1->fetch_assoc();
                          $resultCount = 11;
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
        
                          $result = $mysqli->query("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.action = '$actionValue' AND (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystemtrail.action = '$actionValue' AND (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to') ORDER BY dateModified DESC LIMIT 11") or die($mysqli->error);
                          
                          $resultString = ("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.action = '$actionValue' AND (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystemtrail.action = '$actionValue' AND (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to') ORDER BY dateModified DESC");
                        }
                        else {
                          $result1 = $mysqli->query("SELECT COUNT(*) as count FROM(SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.action = '$actionValue' UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystemtrail.action = '$actionValue')A") or die($mysqli->error);
                          $rowCount = $result1->fetch_assoc();
                          $resultCount = 11;
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
        
                          $result = $mysqli->query("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.action = '$actionValue' UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystemtrail.action = '$actionValue' ORDER BY dateModified DESC LIMIT 11") or die($mysqli->error);

                          $resultString = ("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE A.action = '$actionValue' UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE tblsystemtrail.action = '$actionValue' ORDER BY dateModified DESC");
                        }
                      }
                      else {
                        if ($_POST['fromValue'] != '' && $_POST['toValue'] != '' ){
                          $result1 = $mysqli->query("SELECT COUNT(*) as count FROM(SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to'))A") or die($mysqli->error);
                          $rowCount = $result1->fetch_assoc();
                          $resultCount = 11;
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
        
                          $result = $mysqli->query("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to') ORDER BY dateModified DESC LIMIT 11") or die($mysqli->error);

                          $resultString = ("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id WHERE (DATE(A.dateModified) BETWEEN '$from' AND '$to') UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id WHERE (DATE(tblsystemtrail.dateModified) BETWEEN '$from' AND '$to') ORDER BY dateModified DESC");
                        }
                        else {
                          $result1 = $mysqli->query("SELECT COUNT(*) as count FROM(SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id)A") or die($mysqli->error);
                          $rowCount = $result1->fetch_assoc();
                          $resultCount = 11;
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
        
                          $result = $mysqli->query("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id ORDER BY dateModified DESC LIMIT 11") or die($mysqli->error);

                          $resultString = ("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id ORDER BY dateModified DESC");

                        }
                      }
                    }
                  }
                  else{
                    $result1 = $mysqli->query("SELECT COUNT(*) as count FROM(SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id UNION 
                    SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id)A") or die($mysqli->error);
                    $rowCount = $result1->fetch_assoc();
                    $resultCount = 11;
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
  
                    $result = $mysqli->query("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id ORDER BY dateModified DESC LIMIT $startLimit, $resultCount") or die($mysqli->error);

                    $resultString = ("SELECT A.accountId, B.inCharge, B.authorityLevel, A.action, A.activity, A.dateModified FROM(SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS accountId, tblaccounttrail.action, 'Accounts' AS activity, tblaccounttrail.dateModified FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.accountId = tblaccounts.id)A JOIN (SELECT tblaccounttrail.id, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel FROM tblaccounttrail JOIN tblaccounts ON tblaccounttrail.userId = tblaccounts.id)B ON A.id = B.id UNION SELECT tblsystems.name, CONCAT(tblaccounts.fname,' ', tblaccounts.lname, ' ', tblaccounts.qualifier) AS inCharge, tblaccounts.authorityLevel, tblsystemtrail.action, 'Systems' AS activity, tblsystemtrail.dateModified FROM tblsystemtrail JOIN tblsystems ON tblsystemtrail.systemId = tblsystems.id JOIN tblaccounts ON tblsystemtrail.userId = tblaccounts.id ORDER BY dateModified DESC LIMIT $startLimit, $resultCount");
                  }    
              ?>

          <?php if(isset($_POST['search'])): ?> 
            <p align="center" style="font-size: 12pt; font-weight: bold;"><?php if($from != "" && $to != ""){ echo "As of ". $from . " to " . $to; }else{ echo "As of Today"; } ?></p>
            <p align="center"><strong>Keyword Searched: </strong> <?php echo $searchValue . " | "; ?><strong>Acitivity: </strong> <?php echo $actionValue; ?>
          <?php endif; ?>

              <div id="divTable">
                <table class="table table-striped table-hover table-responsive">
                  <?php if($result != ""): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                      <tr>
                        <td style="width: 80vw;">
                          <strong><label><?php echo $row['accountId']; ?><label></strong>
                          <?php echo ' has been' ?>
                          <?php if($row['action'] == 'Edited'): ?><image src="../images/edited.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;"></image><?php elseif($row['action'] == 'Added'): ?><image src="../images/added.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;"></image><?php elseif($row['action'] == 'Deactivated'): ?><image src="../images/deleted.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;"><?php elseif($row['action'] == 'Activated'): ?><image src="../images/recovered.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;"><?php elseif($row['action'] == 'Deleted'): ?><image src="../images/deleted.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;"><?php elseif($row['action'] == 'Recovered'): ?><image src="../images/recovered.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;"><?php endif; ?><?php echo $row['action'] ?>
                          <?php echo ' by ' . $row['inCharge'] . '(' . ucwords($row['authorityLevel']) . ')' ?>
                        </td>
                        <td style="width: 13vw;"><?php echo date('Y-d-m h:i:s a', strtotime($row['dateModified'])) ?></td>
                      </tr>   
                    <?php endwhile; ?>
        
                  <?php endif ?>
                </table>
              </div>
             
              <script>
                  $(document).ready(function(){
                      var query = "<?php echo $resultString; ?>";
                      var docCount = 11;
                      $("#btnViewMore").click(function(){
                        docCount = docCount + 11;
                        $("#divTable").load("viewMoreAudit.php", {
                          newQuery: query,
                          newDocCount: docCount
                        });
                      });
                  });
              </script>

              <form action="../audittrail/" method="GET" id="accountsPagination">
                  <?php if(isset($_POST['search'])): ?>
                    <div class="row" style="display: grid; justify-items: center; margin-top: 1rem; <?php if($rowCount['count'] == 0 || $rowCount['count'] <= 11): ?>display: none;<?php endif; ?>" id="divViewMore">
                        <button class="btn btn-outline-primary" type="button" id="btnViewMore" style="width: 25vw;">View More</button>
                    </div>
                    <p><?php echo $rowCount['count'] ?> Search Result</p> 
                  <?php else: ?>
                  <?php if(mysqli_num_rows($result) > 0): ?>
                      <?php if($page == '1'): ?>
                        <button disabled class="btn btn-outline-primary"><</button>
                      <?php else: ?>
                        <a href="../audittrail/?page=<?php echo $page - 1 ?>" class="btn btn-outline-primary"><</a>
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
                          <a href="../audittrail/?page=<?php echo $page ?>" class="btn btn-primary"><?php echo $page ?></a>
                        <?php else: ?>
                          <a href="../audittrail/?page=<?php echo $page ?>" class="btn btn-outline-primary"><?php echo $page ?></a>
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
                        <a href="../audittrail/?page=<?php echo $page + 1 ?>" class="btn btn-outline-primary">></a>
                      <?php endif; ?>
                      <p><?php echo $startLimit + 1?> - <?php $total = $startLimit + $resultCount; if($total < $rowCount['count']){ echo $total; } else{ echo $rowCount['count']; } ?> / <?php echo $rowCount['count'] ?></p> 
                    <?php else: ?>
                      <p>There are no audit trails</p>
                    <?php endif; ?>
                  <?php endif; ?>
                </form>
    
            </div>
          </div>       

        </div>

        <?php
            $resultMinDate = $mysqli->query("SELECT DATE(dateModified) AS dateModified FROM(SELECT dateModified FROM tblaccounttrail UNION SELECT dateModified FROM tblsystemtrail)A ORDER BY dateModified ASC LIMIT 1") or die($mysqli->error());
            $rowMinDate = $resultMinDate->fetch_assoc();
            $minDate = ($rowMinDate['dateModified']);
        ?>

      <script type="text/javascript">
    
        function loading(){
          var loader = document.getElementById("loader");
          loader.style.display = "none";
          var pageSystem = "<?php $_SESSION['pageSystem'] = 1; ?>";
          var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";

          document.getElementById("auditTrail").style.color = "black";
          document.getElementById("auditTrail").style.fontWeight = "bold";

        }

        var maxDate = new Date().toISOString().split('T')[0];
        var minDate = "<?php echo $minDate; ?>";
        document.getElementsByName("toValue")[0].setAttribute('max', maxDate);
        document.getElementsByName("toValue")[0].setAttribute('min', minDate);

        document.getElementsByName("fromValue")[0].setAttribute('max', maxDate);
        document.getElementsByName("fromValue")[0].setAttribute('min', minDate);
    

      </script>

    </body>
</html>



<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->