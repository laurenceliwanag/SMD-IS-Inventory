<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

     
        <link rel="stylesheet" type="text/css" href="../style.css">
        <title>Inventory of Information Systems</title>
    </head>
    <body>
      <?php require_once 'login/process.php' ?>

      <nav class="navbar navbar-expand-xl bg-primary sticky-top">

          <a class="navbar-brand" href="../dashboard/">
            <img src="../images/logo-itms.png" width="30" height="30" alt="">
          </a> 

          <a class="navbar-brand mb-0 h1 d-xl-none" href="../dashboard/">IIS</a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <img src="../images/hamburger-icon.png" width="30" height="30" alt="">
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="navbar-brand mb-0 d-none d-lg-block" href="../dashboard/">Inventory of Information Systems</a>
        
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="../dashboard/" id="dashboard">Dashboard<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="systems">Systems </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="../systems/">List of Systems</a>
                  <?php if($_SESSION['authorityLevel'] == 'admin'): ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../deleted/">Deleted Systems</a>
                  <?php else: ?> 

                  <?php endif; ?>
                </div>
              </li>
              <?php if($_SESSION['authorityLevel'] == 'admin'): ?>
                <li class="nav-item">
                  <a class="nav-link" href="../inquiry/" id="inquiry">Inquiry<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../reports/" id="reports">Reports<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../audittrail/" id="auditTrail">Audit Trail<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="accounts">Accounts </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="../accounts/">Active Accounts</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../deactivated/">Deactivated Accounts</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../loginhistory/">Login History</a>
                  </div>
                </li>
              <?php else: ?> 

              <?php endif; ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="profile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php if($_SESSION['userId'] != ''): echo $_SESSION['fname']; echo " "; if($_SESSION['mname'] != "") {echo $_SESSION['mname'][0]; echo ".";} echo " "; echo $_SESSION['lname']; ?>
                <?php endif; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="../profile/">Profile</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logout">Logout</a>
                </div>
              </li>
            </ul>
          </div>
      </nav>

      
      <footer class="footer">
        <div class="form-group" style="margin: 0; padding: 1rem; padding-top: .5rem; padding-bottom: .5rem;">
          <p style="margin:0; text-align: center;">All Rights Reserved © 2019<img src="../images/logo-pnp.png" style="margin-left: .5rem; margin-right: .5rem; height: 1.5rem; width: 1.3rem;">Philippine National Police</p>
        </div>
      </footer>

      
        <!-----MODAL LOGIN----->
        <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                
                <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                <a href="#" class="close"><span aria-hidden="true" data-dismiss="modal" data-target="#logout">&times;</span></a>
              </div>

              <form action="logout.php" method="POST">
                <div class="modal-body">
                  Are you sure you want to logout?
                </div>

                <div class="modal-footer">
                  <a href="../login/logout.php" class="btn btn-success">Yes</a>
                  <a href="#" class="btn btn-danger" name="btnNo" data-dismiss="modal" data-target="#logout">No</a>
                </div>
              </form>
            </div>
          </div>
        </div>
  
</body>
</html>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->