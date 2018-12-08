<?php
	include_once 'dbh.php';
	session_start();

if(!isset($_SESSION['u_id']))
	{
    // not logged in
    header('Location: login.php');
    exit();
	}else{
          $sql = "SELECT * FROM customers where cust_status = 'waiting'";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['waiting'] = $queryResults;

          $sql = "SELECT * FROM customers 
          where cust_status = 'confirmed'";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['confirmed'] = $queryResults;


          $sql = "SELECT * FROM customers 
          where cust_status = 'checkin'";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['checkin'] = $queryResults;

          $result = mysqli_query($conn, "SELECT * from customers where cust_status = 'checkedin'");
          $queryResults = mysqli_num_rows($result);
          $_SESSION['checkedin'] = $queryResults;


  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Dashboard</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/adminstyle.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
  </head>
  <style>
      a{
          color:black;
      }
      
  </style>
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
          <a class="navbar-brand" href="#">Admin</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="admin.php">Dashboard</a></li>
            <li><a href="reservation.php">Reservation</a></li>
            <li><a href="confirmed.php">Confirmed</a></li>
            <li><a href="checkin.php">Check-in</a></li>
            <li><a href="checkout.php">Check-out</a></li>
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
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard <small>Reservation System</small></h1>
          </div>
        </div>
      </div>
    </header>

<!--    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </section>-->

   
     
       <!-- <div class="row">
-->

<!--            <div class="well">
              <h4>Date:</h4>
              <?php 
                date_default_timezone_set('Asia/Manila');
                echo date('F j, Y g:i a  ');
              ?>
            </div>
          </div>-->
          
          
		<section id="main">
            <div class="container">
		  
          
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Overview</h3>
              </div>
              <div class="panel-body">
                  <a href = 'reservation.php'>
                <div class="col-md-3">
                  <div class="well dash-box">
                    <h2><span class="" aria-hidden="true">
                       <?php   
                        echo $_SESSION['waiting'];
                       ?>
                    </span></h2>
                    <h4>Reservation</h4>
                  </div>
                </div></a>
                
                <a href = 'confirmed.php'>
                <div class="col-md-3">
                  <div class="well dash-box">
                    <h2><span class="" aria-hidden="true">
                        <?php   
                           echo $_SESSION['confirmed'];
                        ?>
                    </span></h2>
                    <h4>Confirmed</h4>
                  </div>
                </div></a>
                
                <a href = 'checkin.php'>
                <div class="col-md-3">
                  <div class="well dash-box">
                    <h2><span class="" aria-hidden="true">
                        <?php   
                          echo $_SESSION['checkin'];
                        ?>
                    </span></h2>
                    <h4>Check-in</h4>
                  </div>
                </div></a>
                
                <a href = 'checkout.php'>
                <div class="col-md-3">
                  <div class="well dash-box">
                    <h2><span class="" aria-hidden="true">
                      <?php   
                        echo $_SESSION['checkedin'];
                      ?>
              </span></h2>
                    <h4>Check-out</h4>
                  </div>
                </div></a>
                
              </div>
              </div>

              <!-- Latest Users -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Latest User</h3>
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <?php   
                      $sql = "SELECT * FROM users where user_type = 'Admin' order by last_login DESC ";
                      $result = mysqli_query($conn, $sql);
                      $queryResults = mysqli_num_rows($result);

                      If($queryResults > 0){  
                          echo "
                              <tr>
                                <th>Name</th>
                                <th>Account</th>
                                <th>Last Login</th>
                              </tr>";

                            
                      while($row = mysqli_fetch_assoc($result)){
                          echo "
                            <tr>
                                <td>".$row['user_first']." ".$row['user_last']."</td>
                                <td>".$row['user_type']."</td>
                                <td>".$row['last_login']."</td>
                            </tr>";
                        }
                      }
               
                    ?>
                    </table>
                </div>
              </div>
          </div>
        </div>
      </div>
    </section>

    <footer id="footer">
     <p>Rock Garden Resort, Copyright &copy; 2017 </p>
    </footer>

    <!-- Modals -->

    <!-- Add Page -->
    <div class="modal fade" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Page</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Page Title</label>
          <input type="text" class="form-control" placeholder="Page Title">
        </div>
        <div class="form-group">
          <label>Page Body</label>
          <textarea name="editor1" class="form-control" placeholder="Page Body"></textarea>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox"> Published
          </label>
        </div>
        <div class="form-group">
          <label>Meta Tags</label>
          <input type="text" class="form-control" placeholder="Add Some Tags...">
        </div>
        <div class="form-group">
          <label>Meta Description</label>
          <input type="text" class="form-control" placeholder="Add Meta Description...">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

  <script>
     CKEDITOR.replace( 'editor1' );
 </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
