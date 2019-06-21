<?php
  ob_start();
  require '../connection.php';
  if(!isset($_SESSION)){ 
    session_start();
  }
 
  $limit = $_POST['newDocCount'];
  $query = $_POST['newQuery'] . ' LIMIT ' . $limit;
  $queryCount =  $_POST['newQuery'];

  $result1 = $mysqli->query($query) or die($mysqli->error());
  $resultCount = $mysqli->query($queryCount) or die($mysqli->error()); 

  if($limit >= mysqli_num_rows($resultCount)){
    echo '<script>';
    echo 'var div = document.getElementById("divViewMore");';
    echo 'div.style.display = "none"';
    echo '</script>';
  }

  echo '<table class="table table-striped table-hover table-responsive" id="tblAccounts">';
  echo '<thead>';
  echo '<tr>';
  echo '<th style="width: 13vw;">First Name</th>';
  echo '<th style="width: 10vw;">Middle Name</th>';
  echo '<th style="width: 13vw;">Last Name</th>';
  echo '<th style="width: 5vw;">Qualifier</th>';
  echo '<th style="width: 20vw;">Rank</th>';
  echo '<th style="width: 10vw;">Authority Level</th>';
  echo '<th style="width: 7vw;">Status</th>';
  echo '<th style="width: 8vw;">Date Added</th>';
  echo '<th style="width: 16vw;"class="action">Action</th>';
  echo '</tr>';
  echo '</thead>';
                
  if($result1 != ""){
    while($row = $result1->fetch_assoc()){
     echo '<tr ondblclick="accountView(' . $row['id'] . ')">';
     echo '<td>' . $row['fname'] . '</td>';
     echo '<td>' . $row['mname'] . '</td>';
     echo '<td>' . $row['lname'] . '</td>';
     echo '<td>' . $row['qualifier'] . '</td>';
     $tblRank = $row['rank'];
     $resultRank = $mysqli->query("SELECT * FROM tblranks WHERE id = '$tblRank'") or die($mysqli->error());
     $rowRank = $resultRank->fetch_array();
     echo '<td>' . $rowRank['rank'] . '</td>';
     echo '<td>' . ucwords($row['authorityLevel']) . '</td>';
     echo '<td>' . ucwords($row['status']) . '</td>';
     echo '<td>' . date("Y-m-d", strtotime($row['dateAdded'])) . '</td>';
     echo '<td class="action">';
     echo '<form action="process.php" method="POST">';
     echo '<div>';
     echo '<a href="?view=' . $row['id'] . '" class="btn btn-success" id="btnView" data-toggle="tooltip" data-placement="top" title="View" style="margin-right: 0.188rem; margin-top: .4rem;"><image src="../images/view.png" height="20" width="20"></image></a>';
     echo '<a href="?activate=' . $row['id'] . '" class="btn" data-toggle="tooltip" data-placement="top" title="Activate" style="background: #07666d; margin-top: .4rem;" id="btnDelete"><image src="../images/recover.png" height="20" width="20"></image></a>';
     echo '</div>';
     echo '</form>';
     echo '</td>';
     echo '</tr>';   

    }
  }
                 
                    
              
  echo '</table>';
?>

