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
    echo 'var div = document.getElementById("divViewMoreFilter");';
    echo 'div.style.display = "none"';
    echo '</script>';
  }

  echo '<table class="table table-striped table-hover table-responsive">';
  echo '<thead>';
  echo '<tr>';
  echo '<th></th>';
  echo '<th style="width: 15vw;">Name of IS</th>';
  echo '<th style="width: 5vw;">Office</th>';
  echo '<th style="width: 20vw;">Description</th>';
  echo '<th style="width: 8vw;">Source</th>';
  echo '<th style="width: 8vw;">Type of IS</th>';
  echo '<th style="width: 8vw;">Status of IS</th>';
  echo '<th style="width: 9vw;">Prepared By</th>';
  echo '<th style="width: 9vw;">Date Added</th>' ;
  echo '<th style="width: 16vw;" class="action">Action</th>';
  echo '</tr>';
  echo '</thead>';

  if($result1 != ""){
    while($row = $result1->fetch_assoc()){
      echo '<tr ondblclick="systemView' . $row['id'] .'">';
      if($row['logo'] == ''){
        echo '<td><img src="../images/logo-pnp.png" height="50" width="50"></td>';
      }
      else {
        echo '<td><img src="../images/system logo/'.  $row['logo'] .'" height="50" width="50"></td>';
      }
      echo '<td>'. $row['name'] .'</td>';
      echo '<td>'. $row['office'] .'</td>';
      echo '<td align="justify">' .  $row['description'] . ' </td>';
      echo '<td>' .  $row['source'] . ' </td>';
      echo '<td>' .  ucwords($row['typeIS']) . ' </td>';
      echo '<td>' .  $row['statusIS'] . ' </td>';
      echo '<td>' .  $row['preparedBy'] . ' </td>';
      echo' <td>' .  date("Y-m-d", strtotime($row['dateAdded'])) . '</td>';
      echo '<td class="action">';
      echo '<form action="../systems/" method="POST">';
      echo '<a href="?view=' .   $row['id'] . '" class="btn btn-success" id="btnView" data-toggle="tooltip" data-placement="top" title="View" style="margin-right: .188rem; margin-top: .4rem;"><image src="../images/view.png" height="20" width="20"></image></a>';

      if($_SESSION['authorityLevel'] == 'admin' || $_SESSION['authorityLevel'] == 'researcher'){
        echo '<a href="?edit= ' . $row['id'] . '" class="btn btn-info" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Edit" style="margin-right: .188rem; margin-top: .4rem;"><image src="../images/edit.png" height="20" width="20"></image></a>';
      }

      if($_SESSION['authorityLevel'] == 'admin'){
        echo '<a href="?delete=' . $row['id'] . '" class="btn btn-danger" id="btnDelete" data-toggle="tooltip" data-placement="top" title="Delete" style="margin-top: .4rem;"><image src="../images/delete.png" height="20" width="20"></image></a>';
      }
      echo '</form>';
      echo '</td>';
      echo '</tr>';
    } 
  }
?>

