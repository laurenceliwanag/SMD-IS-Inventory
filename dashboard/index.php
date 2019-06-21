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
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <link rel="icon" href="../images/logo-itms.png">
        <script type="text/javascript" src="chartjs-plugin-labels.js"></script>
    </head>
    <body onload="loading()">
    <?php include '../navbar.php' ?>
  
        <div class="loader" id="loader"></div>

        <?php require '../connection.php'; 
            /*--------------------ADMINISTRATIVE ITMS--------------------*/ 
            $resultAdministrativeLANITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'LAN-Based' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemAdministrativeLANITMS = $resultAdministrativeLANITMS->fetch_assoc();

            $resultAdministrativeWEBITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'Web-Based' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemAdministrativeWEBITMS = $resultAdministrativeWEBITMS->fetch_assoc();

            $resultAdministrativeCLOUDITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'Cloud-Based' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemAdministrativeCLOUDITMS = $resultAdministrativeCLOUDITMS->fetch_assoc();

            $resultAdministrativeOTHERSITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'Others' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemAdministrativeOTHERSITMS = $resultAdministrativeOTHERSITMS->fetch_assoc();

            /*--------------------ADMINISTRATIVE UNIT--------------------*/ 
            $resultAdministrativeLANUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'LAN-Based' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemAdministrativeLANUNIT = $resultAdministrativeLANUNIT->fetch_assoc();

            $resultAdministrativeWEBUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'Web-Based' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemAdministrativeWEBUNIT = $resultAdministrativeWEBUNIT->fetch_assoc();

            $resultAdministrativeCLOUDUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'Cloud-Based' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemAdministrativeCLOUDUNIT = $resultAdministrativeCLOUDUNIT->fetch_assoc();

            $resultAdministrativeOTHERSUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'Others' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemAdministrativeOTHERSUNIT = $resultAdministrativeOTHERSUNIT->fetch_assoc();

            /*--------------------ADMINISTRATIVE OUTSOURCE--------------------*/        
            $resultAdministrativeLANOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'LAN-Based' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemAdministrativeLANOUT = $resultAdministrativeLANOUT->fetch_assoc();

            $resultAdministrativeWEBOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'Web-Based' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemAdministrativeWEBOUT = $resultAdministrativeWEBOUT->fetch_assoc();

            $resultAdministrativeCLOUDOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'Cloud-Based' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemAdministrativeCLOUDOUT = $resultAdministrativeCLOUDOUT->fetch_assoc();

            $resultAdministrativeOTHERSOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative' AND environment = 'Others' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemAdministrativeOTHERSOUT = $resultAdministrativeOTHERSOUT->fetch_assoc();



            /*--------------------OPERATIONS ITMS--------------------*/
            $resultOperationsLANITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'LAN-Based' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemOperationsLANITMS = $resultOperationsLANITMS->fetch_assoc();

            $resultOperationsWEBITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'Web-Based' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemOperationsWEBITMS = $resultOperationsWEBITMS->fetch_assoc();

            $resultOperationsCLOUDITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'Cloud-Based' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemOperationsCLOUDITMS = $resultOperationsCLOUDITMS->fetch_assoc();

            $resultOperationsOTHERSITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'Others' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemOperationsOTHERSITMS = $resultOperationsOTHERSITMS->fetch_assoc();

            /*--------------------OPERATIONS UNIT--------------------*/
            $resultOperationsLANUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'LAN-Based' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemOperationsLANUNIT = $resultOperationsLANUNIT->fetch_assoc();

            $resultOperationsWEBUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'Web-Based' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemOperationsWEBUNIT = $resultOperationsWEBUNIT->fetch_assoc();

            $resultOperationsCLOUDUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'Cloud-Based' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemOperationsCLOUDUNIT = $resultOperationsCLOUDUNIT->fetch_assoc();

            $resultOperationsOTHERSUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'Others' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemOperationsOTHERSUNIT = $resultOperationsOTHERSUNIT->fetch_assoc();

            /*--------------------OPERATIONS OUTSOURCE--------------------*/
            $resultOperationsLANOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'LAN-Based' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemOperationsLANOUT = $resultOperationsLANOUT->fetch_assoc();

            $resultOperationsWEBOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'Web-Based' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemOperationsWEBOUT = $resultOperationsWEBOUT->fetch_assoc();

            $resultOperationsCLOUDOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'Cloud-Based' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemOperationsCLOUDOUT = $resultOperationsCLOUDOUT->fetch_assoc();

            $resultOperationsOTHERSOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS' AND environment = 'Others' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemOperationsOTHERSOUT = $resultOperationsOTHERSOUT->fetch_assoc();


            
            /*--------------------SUPPORT ITMS--------------------*/
            $resultSupportLANITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'LAN-Based' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemSupportLANITMS = $resultSupportLANITMS->fetch_assoc();

            $resultSupportWEBITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'Web-Based' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemSupportWEBITMS = $resultSupportWEBITMS->fetch_assoc();

            $resultSupportCLOUDITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'Cloud-Based' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemSupportCLOUDITMS = $resultSupportCLOUDITMS->fetch_assoc();

            $resultSupportOTHERSITMS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'Others' AND source = 'In-House (by ITMS)'") or die($mysqli->error);
            $rowSystemSupportOTHERSITMS = $resultSupportOTHERSITMS->fetch_assoc();

            
            /*--------------------SUPPORT UNIT--------------------*/
            $resultSupportLANUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'LAN-Based' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemSupportLANUNIT = $resultSupportLANUNIT->fetch_assoc();

            $resultSupportWEBUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'Web-Based' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemSupportWEBUNIT = $resultSupportWEBUNIT->fetch_assoc();

            $resultSupportCLOUDUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'Cloud-Based' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemSupportCLOUDUNIT = $resultSupportCLOUDUNIT->fetch_assoc();

            $resultSupportOTHERSUNIT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'Others' AND source = 'In-House (c/o Unit)'") or die($mysqli->error);
            $rowSystemSupportOTHERSUNIT = $resultSupportOTHERSUNIT->fetch_assoc();

            /*--------------------SUPPORT OUTSOURCE--------------------*/
            $resultSupportLANOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'LAN-Based' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemSupportLANOUT = $resultSupportLANOUT->fetch_assoc();

            $resultSupportWEBOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'Web-Based' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemSupportWEBOUT = $resultSupportWEBOUT->fetch_assoc();

            $resultSupportCLOUDOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'Cloud-Based' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemSupportCLOUDOUT = $resultSupportCLOUDOUT->fetch_assoc();

            $resultSupportOTHERSOUT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS' AND environment = 'Others' AND source = 'Outsource'") or die($mysqli->error);
            $rowSystemSupportOTHERSOUT = $resultSupportOTHERSOUT->fetch_assoc();

            /*-------------------- TOTAL --------------------*/
            $resultTotalADMINISTRATIVE= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Administrative'") or die($mysqli->error);
            $rowTotalADMINISTRATIVE = $resultTotalADMINISTRATIVE->fetch_assoc();

            $resultTotalOPERATIONS= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Operations IS'") or die($mysqli->error);
            $rowTotalOPERATIONS = $resultTotalOPERATIONS->fetch_assoc();

            $resultTotalSUPPORT= $mysqli->query("SELECT COUNT(*) AS count FROM tblsystems WHERE status != 'inactive' AND typeIS = 'Support to Operations IS'") or die($mysqli->error);
            $rowTotalSUPPORT = $resultTotalSUPPORT->fetch_assoc();
        ?>

        <div class="custom-container">
            <div class="row totalIS" id="dashboard" style="border-left: 1px solid lightgrey; border-right: 1px solid lightgrey;">
                <div class="col-xl" style="position: relative; height: 29.2vh; width: 80vw; display: grid; justify-items: center; align-items: center; border: 1px solid lightgrey;">
                    <h5 class="card-title" style="font-size: 20px;"><strong>Total No. of Administrative</strong></h5>
                    <h1 align="center" class="card-subtitle" style="font-size: 8rem;"><?php echo $rowTotalADMINISTRATIVE['count']; ?></h1>
                </div>
                <div class="col-xl" style="position: relative; height: 29.2vh; width: 80vw; display: grid; justify-items: center; align-items: center;  border: 1px solid lightgrey;">
                    <h5 class="card-title" style="font-size: 20px;"><strong>Total No. of Operations IS</strong></h5>
                    <h1 align="center" class="card-subtitle" style="font-size: 8rem;"><?php echo $rowTotalOPERATIONS['count']; ?></h1>   
                </div>
                <div class="col-xl" style="position: relative; height: 29.2vh; width: 80vw; display: grid; justify-items: center; align-items: center;  border: 1px solid lightgrey;">
                    <h5 class="card-title" style="font-size: 20px;"><strong>Total No. of Support to Operations IS</strong></h5>
                    <h1 align="center" class="card-subtitle" style="font-size: 8rem;"><?php echo $rowTotalSUPPORT['count']; ?></h1> 
                </div>
            </div> 
            <div class="row" id="dashboard" style="border-left: 1px solid lightgrey; border-right: 1px solid lightgrey;">
                <div class="col-xl" style="position: relative; height: 45vh; width: 80vw;">
                    <canvas id="sourceAdministrative"></canvas>
                </div>
                <div class="col-xl" style="position: relative; height: 45vh; width: 80vw;">
                    <canvas id="sourceOperations"></canvas>
                </div>
                <div class="col-xl" style="position: relative; height: 45vh; width: 80vw;">
                    <canvas id="sourceSupport"></canvas>
                </div>
            </div>    
            <div class="row" id="dashboard" style="border-left: 1px solid lightgrey; border-right: 1px solid lightgrey;">
                <div class="col-xl" style="position: relative; height: 45vh; width: 80vw;">
                    <canvas id="administrative"></canvas>
                </div>
                <div class="col-xl" style="position: relative; height: 45vh; width: 80vw;">
                    <canvas id="operations"></canvas>
                </div>
                <div class="col-xl" style="position: relative; height: 45vh; width: 80vw;">
                    <canvas id="support"></canvas>
                </div>
            </div>   
        </div>

    <script>
        $('#btnPrint').click(function(){
                var sourceAdministrative = document.getElementById("sourceAdministrative");
                var printPreview = window.open('', '', 'width=screen.width,height=screen.height,toolbar=yes,scrollbars=yes,status=yes,menubar=yes');

                printPreview.document.write(sourceAdministrative.outerHTML);
                printPreview.document.close();

                printPreview.focus(); 
                printPreview.print(); 
                printPreview.close();
      
            })

        var ctxSourceAdministrative = document.getElementById("sourceAdministrative").getContext("2d");
        var sourceAdministrative = new Chart(ctxSourceAdministrative, {
        type: 'pie',
        data: {
            labels: ['In-House(by ITMS)', 'In-House(c/o Unit)', 'Outsource'],
            datasets: [{
                label: 'In-House(by ITMS)',
                backgroundColor: ["rgba(95,199,227)", "rgba(124,178,135)", "rgba(228,136,139)"],
                data: [<?php echo $rowSystemAdministrativeLANITMS['count'] + $rowSystemAdministrativeWEBITMS['count'] + $rowSystemAdministrativeCLOUDITMS['count']; ?>, <?php echo $rowSystemAdministrativeLANUNIT['count'] + $rowSystemAdministrativeWEBUNIT['count'] + $rowSystemAdministrativeCLOUDUNIT['count']; ?>, <?php echo $rowSystemAdministrativeLANOUT['count'] + $rowSystemAdministrativeWEBOUT['count'] + $rowSystemAdministrativeCLOUDOUT['count']; ?>]
            }]
        }, 

        options: {
            plugins:{
                labels: {
                    render: 'percentage',
                    fontColor: 'white',
                    fontSize: 16
                }
            },
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: "#000000",
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        display: false
                    }
                }],
            },
            title: {
                display: true,
                text: 'Breakdown by Source',
                fontSize: 22,
                fontColor: "#000000",
                fontFamily: "Roboto Slab"
            }
        }
        });

        var ctxAdministrative = document.getElementById("administrative").getContext("2d");
        var administrative = new Chart(ctxAdministrative, {
        type: 'horizontalBar',
        data: {
            labels: ['In-House(by ITMS)', 'In-House(c/o Unit)', 'Outsource'],
            datasets: [{
                label: 'LAN-Based',
                backgroundColor: "rgba(95,199,227)",
                data: [<?php echo $rowSystemAdministrativeLANITMS['count']; ?>, <?php echo $rowSystemAdministrativeLANUNIT['count']; ?>, <?php echo $rowSystemAdministrativeLANOUT['count']; ?>]
            }, {
                label: 'Web-Based',
                backgroundColor: "rgba(124,178,135)",
                data: [<?php echo $rowSystemAdministrativeWEBITMS['count']; ?>, <?php echo $rowSystemAdministrativeWEBUNIT['count']; ?>, <?php echo $rowSystemAdministrativeWEBOUT['count']; ?>]
            }, {
                label: 'Cloud-Based',
                backgroundColor:  "rgba(228,136,139)",
                data: [<?php echo $rowSystemAdministrativeCLOUDITMS['count']; ?>, <?php echo $rowSystemAdministrativeCLOUDUNIT['count']; ?>, <?php echo $rowSystemAdministrativeCLOUDOUT['count']; ?>]
            }, {
                label: 'Others',
                backgroundColor: "rgba(255,167,127)",
                data: [<?php echo $rowSystemAdministrativeOTHERSITMS['count']; ?>, <?php echo $rowSystemAdministrativeOTHERSUNIT['count']; ?>, <?php echo $rowSystemAdministrativeOTHERSOUT['count']; ?>]
            }]
        },

        options: {
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: "#000000",
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: "#000000"
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "#000000",
                        fontStyle: "bold",
                        fontSize: 14,
                    }
                }],
                
            },
            title: {
                display: true,
                text: 'Breakdown by Environment',
                fontSize: 22,             
                fontColor: "#000000",
                fontFamily: "Roboto Slab"
            }
        }
        });

        var ctxSourceOperations = document.getElementById("sourceOperations").getContext("2d");
        var sourceOperations = new Chart(ctxSourceOperations, {
        type: 'pie',
        data: {
            labels: ['In-House(by ITMS)', 'In-House(c/o Unit)', 'Outsource'],
            datasets: [{
                label: 'In-House(by ITMS)',
                backgroundColor: ["rgba(95,199,227)", "rgba(124,178,135)", "rgba(228,136,139)"],
                data: [<?php echo $rowSystemOperationsLANITMS['count'] + $rowSystemOperationsWEBITMS['count'] + $rowSystemOperationsCLOUDITMS['count']; ?>, <?php echo $rowSystemOperationsLANUNIT['count'] + $rowSystemOperationsWEBUNIT['count'] + $rowSystemOperationsCLOUDUNIT['count']; ?>, <?php echo $rowSystemOperationsLANOUT['count'] + $rowSystemOperationsWEBOUT['count'] + $rowSystemOperationsCLOUDOUT['count']; ?>]
            }]
        }, 

        options: {
            plugins:{
                labels: {
                    render: 'percentage',
                    fontColor: 'white',
                    fontSize: 16
                }
            },
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: "#000000",
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        display: false
                    }
                }]
            },
            title: {
                display: true,
                text: 'Breakdown by Source',
                fontSize: 22,             
                fontColor: "#000000",
                fontFamily: "Roboto Slab"
            }
        }
        });

        var ctxOperations = document.getElementById("operations").getContext("2d");
        var operations = new Chart(ctxOperations, {
        type: 'horizontalBar',
        data: {
                labels: ['In-House(by ITMS)', 'In-House(c/o Unit)', 'Outsource'],
                datasets: [{
                label: 'LAN-Based',
                backgroundColor: "rgba(95,199,227)",
                data: [<?php echo $rowSystemOperationsLANITMS['count']; ?>, <?php echo $rowSystemOperationsLANUNIT['count']; ?>, <?php echo $rowSystemOperationsLANOUT['count']; ?>]
            }, {
                label: 'Web-Based',
                backgroundColor: "rgba(124,178,135)",
                data: [<?php echo $rowSystemOperationsWEBITMS['count']; ?>, <?php echo $rowSystemOperationsWEBUNIT['count']; ?>, <?php echo $rowSystemOperationsWEBOUT['count']; ?>]
            }, {
                label: 'Cloud-Based',
                backgroundColor:  "rgba(228,136,139)",
                data: [<?php echo $rowSystemOperationsCLOUDITMS['count']; ?>, <?php echo $rowSystemOperationsCLOUDUNIT['count']; ?>, <?php echo $rowSystemOperationsCLOUDOUT['count']; ?>]
            }, {
                label: 'Others',
                backgroundColor: "rgba(255,167,127)",
                data: [<?php echo $rowSystemOperationsOTHERSITMS['count']; ?>, <?php echo $rowSystemOperationsOTHERSUNIT['count']; ?>, <?php echo $rowSystemOperationsOTHERSOUT['count']; ?>]
            }] 
        },

        options: {
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: "#000000",
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: "#000000"
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "#000000",
                        fontStyle: "bold",
                        fontSize: 14
                    }
                }]
            },
            title: {
                display: true,
                text: 'Breakdown by Environment',
                fontSize: 22,             
                fontColor: "#000000",
                fontFamily: "Roboto Slab"
            }
        }
        });

        var ctxSourceSupport = document.getElementById("sourceSupport").getContext("2d");
        var sourceSupport = new Chart(ctxSourceSupport, {
        type: 'pie',
        data: {
                labels: ['In-House(by ITMS)', 'In-House(c/o Unit)', 'Outsource'],
                datasets: [{
                label: 'In-House(by ITMS)',
                backgroundColor: ["rgba(95,199,227)", "rgba(124,178,135)", "rgba(228,136,139)"],
                data: [<?php echo $rowSystemSupportLANITMS['count'] + $rowSystemSupportWEBITMS['count'] + $rowSystemSupportCLOUDITMS['count']; ?>, <?php echo $rowSystemSupportLANUNIT['count'] + $rowSystemSupportWEBUNIT['count'] + $rowSystemSupportCLOUDUNIT['count']; ?>, <?php echo $rowSystemSupportLANOUT['count'] + $rowSystemSupportWEBOUT['count'] + $rowSystemSupportCLOUDOUT['count']; ?>]
            }]
        },

        options: {
            plugins:{
                labels: {
                    render: 'percentage',
                    fontColor: 'white',
                    fontSize: 16
                }
            },
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: "#000000",
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        display: false
                    }
                }]
            },
            title: {
                display: true,
                text: 'Breakdown by Source',
                fontSize: 22,             
                fontColor: "#000000",
                fontFamily: "Roboto Slab"
            },
        }
        });

        var ctxSupport = document.getElementById("support").getContext("2d");
        var support = new Chart(ctxSupport, {
        type: 'horizontalBar',
        data: {
                labels: ['In-House(by ITMS)', 'In-House(c/o Unit)', 'Outsource'],
                datasets: [{
                label: 'LAN-Based',
                backgroundColor: "rgba(95,199,227)",
                data: [<?php echo $rowSystemSupportLANITMS['count']; ?>, <?php echo $rowSystemSupportLANUNIT['count']; ?>, <?php echo $rowSystemSupportLANOUT['count']; ?>]
            }, {
                label: 'Web-Based',
                backgroundColor: "rgba(124,178,135)",
                data: [<?php echo $rowSystemSupportWEBITMS['count']; ?>, <?php echo $rowSystemSupportWEBUNIT['count']; ?>, <?php echo $rowSystemSupportWEBOUT['count']; ?>]
            }, {
                label: 'Cloud-Based',
                backgroundColor:  "rgba(228,136,139)",
                data: [<?php echo $rowSystemSupportCLOUDITMS['count']; ?>, <?php echo $rowSystemSupportCLOUDUNIT['count']; ?>, <?php echo $rowSystemOperationsCLOUDOUT['count']; ?>]
            }, {
                label: 'Others',
                backgroundColor: "rgba(255,167,127)",
                data: [<?php echo $rowSystemSupportOTHERSITMS['count']; ?>, <?php echo $rowSystemSupportOTHERSUNIT['count']; ?>, <?php echo $rowSystemOperationsOTHERSOUT['count']; ?>]
            }]
        },

        options: {
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: "#000000",
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: "#000000"
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "#000000",
                        fontStyle: "bold",
                        fontSize: 14
                    }
                }]
            },
            title: {
                display: true,
                text: 'Breakdown by Environment',
                fontSize: 22,             
                fontColor: "#000000",
                fontFamily: "Roboto Slab"
            }
        }
        });

        function loading(){
            var loader = document.getElementById("loader");
            loader.style.display = "none";
            var pageSystem = "<?php $_SESSION['pageSystem'] = 1; ?>";
            var pageAccount = "<?php $_SESSION['pageAccount'] = 1; ?>";

            document.getElementById("dashboard").style.color = "black";        
            document.getElementById("dashboard").style.fontWeight = "bold";
        }

    </script>

    </body>
</html>

<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->