<?php
  ob_start();
  require '../connection.php';
  if(!isset($_SESSION)){ 
    session_start();
  }
 
  $limit = $_POST['newResearcherCount'];
  $systemId = $_POST['systemId'];
  $systemOffice = $_POST['systemOffice'];
  
  $result1 = $mysqli->query("SELECT tblresearchers.id, tblresearchers.accountId, tblresearchers.systemId, tblaccounts.fname, tblaccounts.mname, tblaccounts.lname, tblaccounts.qualifier, tblranks.rank FROM tblresearchers JOIN tblaccounts ON tblresearchers.accountId = tblaccounts.id JOIN tblranks ON tblaccounts.rank = tblranks.id WHERE systemId = $systemId LIMIT $limit") or die($mysqli->error());
  $resultCount = $mysqli->query("SELECT * FROM tblresearchers") or die($mysqli->error()); 

  mysqli_num_rows($resultCount);

  if($limit >= mysqli_num_rows($resultCount)){
    echo '<script>';
    echo 'var div = document.getElementById("divViewMoreResearcher");';
    echo 'div.style.display = "none"';
    echo '</script>';
  }

  if(mysqli_num_rows($result1) > 0){
    echo '<ul class="list-group">';
      while($rowResearchers = $result1->fetch_assoc()){
        echo '<li class="list-group-item">'. $rowResearchers['fname'] . " ";
       if($rowResearchers['mname'] != ""){ 
         echo $rowResearchers['mname'][0] . ". "; 
         } 
         echo $rowResearchers['lname'] . " " . $rowResearchers['qualifier'];
         echo '<a href="../systems/?unassignResearcher='. $systemId .'&office='. $systemOffice .'&unassign='. $rowResearchers['id'] .'" class="close"><span aria-hidden="true">&times;</span></a></li>';
      }
      echo '</ul>';                     
  }
  else{
    echo '<p style="text-align: center; width: 100%; margin-top: 1rem;">No Researcher</p>';
  }

?>