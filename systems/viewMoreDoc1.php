<?php
  ob_start();
  require '../connection.php';
  if(!isset($_SESSION)){ 
    session_start();
  }
 
  $limit = $_POST['newDocCount'];
  $newFolder = $_POST['newFolder'];
  $id = $_POST['systemId'];
  
  $result1 = $mysqli->query("SELECT * FROM tbldocuments WHERE systemId = $id AND folder = '$newFolder' LIMIT $limit") or die($mysqli->error()); 
  $resultCount = $mysqli->query("SELECT * FROM tbldocuments WHERE systemId = $id AND folder = '$newFolder'") or die($mysqli->error()); 

  if($limit >= mysqli_num_rows($resultCount)){
    echo '<script>';
    echo 'var div = document.getElementById("divViewMore");';
    echo 'div.style.display = "none"';
    echo '</script>';
  }

  if(mysqli_num_rows($result1) > 0){
    while($row1 = $result1->fetch_assoc()){
      echo '<div class="col-xl-3" style="display: grid; justify-items:center;">';
      echo '<div class="form-group"  style="margin-top: .5rem;">';
      echo '<a href="../document/?document=' . $row1['id'] . '&folder=' . $newFolder . '" class="btn" id="attachedDocuments" style="background: transparent; box-shadow: none;">';
      echo '<img src="../images/system documents/' . $row1['filename'] . '" id="docImage" style="height: 13rem; width: 13rem;" alt=""> ';
      echo '</a>';
      echo '</div>';
      echo '<div class="form-group">';
      echo '<a href="../document/?document=' . $row1['id'] . '&folder=' . $newFolder . '">';
      echo $row1['filename'] . '</a>';
      echo '</div>';
      echo '</div>';
    }
  }
  else{
    echo '<p style="text-align: center; width: 100%; margin-top: 1rem;">No Documents Attached in ' . $newFolder . ' Folder</p>';
  }

?>