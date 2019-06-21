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

  echo '<table class="table table-striped table-hover table-responsive">';
  echo '<thead>';
  echo '<tr>';
  echo '<th style="width: 12vw;">First Name</th>';
  echo '<th style="width: 12vw;">Middle Name</th>';
  echo '<th style="width: 12vw;">Last Name</th>';
  echo '<th style="width: 5vw;">Qualifier</th>';
  echo '<th style="width: 15vw;">Rank</th>';
  echo '<th style="width: 10vw;">Authority Level</th>';
  echo '<th style="width: 12vw;">Time In</th>';
  echo '<th style="width: 12vw;">Time Out</th>';
  echo '</tr>';
  echo '</thead>';

  

  if($result1 != ""){
    while($row = $result1->fetch_assoc()){
      echo '<tr ondblclick="systemView' . $row['id'] .'">';
      echo '<td>' . $row['fname'] . '</td>';
      echo '<td>' . $row['mname'] . '</td>';
      echo '<td>' . $row['lname'] . '</td>';
      echo '<td>' . $row['qualifier'] . '</td>';
      $tblRank = $row['rank'];
      $resultRank = $mysqli->query("SELECT * FROM tblranks WHERE id = '$tblRank'") or die($mysqli->error());
      $rowRank = $resultRank->fetch_array();
      echo '<td>' . $rowRank['rank'] . '</td>';
      echo '<td>' . ucwords($row['authorityLevel']) . '</td>';
      echo '<td>' . date('Y-d-m h:i:s a', strtotime($row['timeIn'])) . '</td>';
      echo '<td>';
      if(date('Y-d-m h:i:s a', strtotime($row['timeOut'])) == '1970-01-01 01:00:00 am' || date('Y-d-m h:i:s a', strtotime($row['timeOut'])) == '1970-01-01 01:00:00 pm'){
        echo '0000-00-00 00:00:00'; 
      }
      else{ 
        echo date('Y-d-m h:i:s a', strtotime($row['timeOut'])); 
      }
      echo '</td>';
      echo '</tr>';
    } 
  }
?>

