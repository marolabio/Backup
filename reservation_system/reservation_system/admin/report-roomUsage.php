<?php
  include_once 'includes/dbh.inc.php';
  session_start();


if(!isset($_SESSION['u_id']))
  {
    // not logged in
    header('Location: login.php');
    exit();
  }else{

     $sql = "SELECT * FROM reports
     INNER JOIN customers ON customers.cust_id = reports.cust_id
     INNER JOIN reservation ON reservation.cust_id = reports.cust_id
     INNER JOIN rooms ON rooms.room_id = reports.room_id
     INNER JOIN users ON users.user_id = reports.user_id
     WHERE rep_status = 'checkedout' AND reports.room_id != 0
     ORDER BY rep_id DESC";

     $reports_result = mysqli_query($conn, $sql);
     $queryResults = mysqli_num_rows($reports_result);
     $_SESSION['roomUsage_reports'] = $queryResults;

     $sql = "SELECT * FROM customers inner join billing on billing.cust_id = customers.cust_id 
     where cust_status = 'refund'";
     $result = mysqli_query($conn, $sql);
     $queryResults = mysqli_num_rows($result);
     $_SESSION['refunds'] = $queryResults;

     $sql = "SELECT * FROM rooms";
     $result = mysqli_query($conn, $sql);
     $queryResults = mysqli_num_rows($result);
     $_SESSION['rooms'] = $queryResults;

     $sql = "SELECT * FROM users";
     $result = mysqli_query($conn, $sql);
     $queryResults = mysqli_num_rows($result);
     $_SESSION['users'] = $queryResults;

  }


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports | Room Usage</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/adminstyle.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

  
  </head>
  <body>

    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Manager</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="manager.php">Dashboard</a></li>
            <li class="active"><a href="report.php">Reports</a></li>
            <li><a href="refund.php">Refunds</a></li>
            <li><a href="rooms.php">Rooms</a></li>
            <li><a href="users.php">Users</a></li>

          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href = "">Welcome, <?php echo $_SESSION['u_first']; ?></a></li>
            <li><a href="includes/logout.inc.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Reports <small>Room Usage</small></h1>
          </div>
          <div class="col-md-2">
            <div class="dropdown create">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Reports
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="report.php">Checked-out</a></li>
                <li><a href="report-cancelled.php">Cancelled</a></li>
                <li><a href="report-refunded.php">Refunded</a></li>
                <li><a href="report-expired.php">Expired</a></li>
                <li><a href="report-roomUsage.php">Room Usage</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>


    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a href="manager.php" class="list-group-item active main-color-bg">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
              </a>
              <a href="report.php" class="list-group-item"><span class=" " aria-hidden="true"></span> Reports<span class="badge">
              <?php   
                echo $_SESSION['roomUsage_reports'];
              ?>
              </span></a>    
              <a href="refund.php" class="list-group-item"><span class=" " aria-hidden="true"></span> Refunds<span class="badge">
              <?php   
                echo $_SESSION['refunds'];
              ?>
              </span></a>

                <a href="rooms.php" class="list-group-item"><span class="" aria-hidden="true"></span> Rooms <span class="badge">
                <?php   
                $sql = "SELECT * FROM rooms";
                $result = mysqli_query($conn, $sql);
                $queryResults = mysqli_num_rows($result);
                echo "$queryResults";
              ?>
              </span></a>
              <a href="users.php" class="list-group-item"><span class="" aria-hidden="true"></span> Users <span class="badge">
                              <?php   
                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);
                $queryResults = mysqli_num_rows($result);
                echo "$queryResults";
              ?>
              </span></a>
            </div>

            <div class="well">
              <h4>Date:</h4>
              <?php 
                date_default_timezone_set('Asia/Manila');
                echo date('F j, Y ');
              ?>
            </div>
          </div>
      
          <div class="col-md-9">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Room Usage Reports</h3>
        
              </div>
                <div class="panel-body">  

                <div class="table-responsive">  
                
                     <table id="reports_data" class="table table-striped table-bordered"> 
                     
 
                          <thead>  
                               <tr>  
                                    <td>#</td>  
                                    <td>Customer Name</td>  
                                    <td>Room</td>
                                    <td>Date</td>
                                    <td>Incharge</td>
                                      
                                   
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($reports_result))  
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["res_id"].'</td>  
                                    <td>'.$row["cust_first"].' '.$row["cust_last"].'</td>  
                                    <td>'.$row["room_type"].'</td>
                                    <td>'.$row["rep_date"].'</td>
                                    <td>'.$row["user_first"].' '.$row["user_last"].'</td>  
                                    
                               </tr>  
                               ';  
                          }  
                          ?>  
                     </table>  

                </div>  
                </div>
                <br>


              </div>
              </div>
              </div>

          </div>
        </div>
      </div>
    </section>



        <script>  
 
        </script>   

  <script>
    $(document).ready(function(){  
      $('#reports_data').DataTable({
          dom: 'Bfrtip',
          buttons: [
             'excel', 'print'
          ]
      }); 

    }); 

     CKEDITOR.replace( 'editor1' );
 </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

