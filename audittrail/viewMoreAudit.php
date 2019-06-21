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
  if($result1 != ""){
    while($row1 = $result1->fetch_assoc()){

      echo '<tr>';
      echo '<td style="width: 80vw;">';
      echo '<strong><label>' . $row1['accountId'] . '<label></strong>';
      echo ' has been';
      if($row1['action'] == 'Edited'){
        echo '<image src="../images/edited.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;"></image>';
      }
      else if($row1['action'] == 'Added'){
        echo '<image src="../images/added.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;"></image>';
      }
      else if($row1['action'] == 'Deactivated'){
        echo '<image src="../images/deleted.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;">';
      }
      else if($row1['action'] == 'Activated'){
        echo '<image src="../images/recovered.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;">';
      }
      else if($row1['action'] == 'Deleted'){
        echo '<image src="../images/deleted.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;">';
      }
      elseif($row1['action'] == 'Recovered'){
        echo '<image src="../images/recovered.png" height="20" width="20" style="margin-right: .5vw; margin-left: .4vw;">';
      }
      echo $row1['action'];
      echo ' by ' . $row1['inCharge'] . '(' . ucwords($row1['authorityLevel']) . ')';
      echo '</td>';
      echo '<td style="width: 13vw;">' . date('Y-d-m h:i:s a', strtotime($row1['dateModified'])) . '</td>';
      echo '</tr>';
    }
  }
  echo '</table>';
  
?>

