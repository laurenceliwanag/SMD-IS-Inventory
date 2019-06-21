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

  mysqli_num_rows($resultCount);

  if($limit >= mysqli_num_rows($resultCount)){
    echo '<script>';
    echo 'var div = document.getElementById("divViewMore2");';
    echo 'div.style.display = "none"';
    echo '</script>';
  }

  if(mysqli_num_rows($result1) > 0){
    echo '<ul class="list-group">'; 
    while($row1 = $result1->fetch_assoc()){
      echo '<a href="../document/?document=' .$row1['id'] . '&folder=' . $newFolder . '">' .'<li class="list-group-item">' . '<img src="../images/system documents/' . $row1['filename'] . '" height="50vw" width="50vw" alt="" style="margin-right: 1vw;">' . $row1['filename'] . '<a href="../systems/?removeDocuments=' . $id . '&removeFolder=' . $newFolder . '&remove=' . $row1['id'] . '" class="close"  style="margin-top: 12px;"><span aria-hidden="true">&times;</span></a>' . '</li>' .'</a>';
    }
    echo '</ul>';
  }
  else{
    echo '<p style="text-align: center; width: 100%; margin-top: 1rem;">No Documents Attached in ' . $newFolder . ' Folder</p>';
  }

?>