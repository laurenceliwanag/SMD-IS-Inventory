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

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>

        <script src="https://cdn.rawgit.com/ccampbell/mousetrap/825ce50c/mousetrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
      
        <link rel="stylesheet" type="text/css" href="../style.css">
        <link rel="icon" href="../images/logo-itms.png">
        <title>Inventory of Information Systems</title>

    </head>
    <body onload="loading()" style="margin:0; background: rgba(0,0,0, .8);">

      <?php 
       require '../connection.php';
       $id = $_GET['document'];
       $folder = $_GET['folder'];

       $resultActive = $mysqli->query("SELECT * FROM tbldocuments WHERE id = $id AND folder = '$folder'") or die($mysqli->error()); 
       $rowActive = $resultActive->fetch_assoc();

       $systemId = $rowActive['systemId'];

       $result = $mysqli->query("SELECT * FROM tbldocuments WHERE systemId = $systemId AND folder = '$folder' AND id != $id") or die($mysqli->error()); 

       $resultCount = $mysqli->query("SELECT COUNT(*) AS count FROM tbldocuments WHERE systemId = $systemId AND folder = '$folder' AND id != $id") or die($mysqli->error());
     
       ?>

      <div class="loader" id="loader"></div>

      <a href="javascript:history.go(-1)" class="close"><span aria-hidden="true" style="color:white; position: absolute; right: 2vw; top: 1.5vw; font-size: 3vw;">&times;</span></a>

      <div class="custom-container" style="height: 100vh; display: grid; align-items: center; margin-bottom: 0;">
    
        <div id="documentCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
              <div class="carousel-item active" style="text-align: center;">
                <img src="../images/system documents/<?php echo $rowActive['filename']; ?>">
                <div class="row" style="display: grid; justify-items: center; padding-top: 5px; margin-top: 10px;">
                  <label for=""><?php echo $rowActive['filename'] ?></label>
                </div>  
              </div>
              <?php while($row = $result->fetch_assoc()): ?>
                  <div class="carousel-item" style="text-align: center;">
                      <img src="../images/system documents/<?php echo $row['filename']; ?>">
                      <div class="row" style="display: grid; justify-items: center; padding-top: 5px; margin-top: 10px">
                        <label for=""><?php echo $row['filename'] ?></label>
                      </div>  
                  </div>
              <?php endwhile; ?>
          </div>
          <a class="carousel-control-prev" href="#documentCarousel" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#documentCarousel" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
          </a>
        </div>
    
      </div>



      <script>
        function loading(){
            var loader = document.getElementById("loader");
            loader.style.display = "none";
            var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";
        }

        $('.carousel').carousel({
          interval: 0
        })

        Mousetrap.bind("esc", function() { 
            location.href = "javascript:history.go(-1)";
        });
      </script>

  </body>
</html>