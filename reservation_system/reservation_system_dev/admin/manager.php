<?php
	include_once 'includes/dbh.inc.php';
	session_start();

if(!isset($_SESSION['u_id']))
	{
    // not logged in
    header('Location: login.php');
    exit();
	}else{

     $sql = "SELECT * FROM reports";
     $result = mysqli_query($conn, $sql);
     $queryResults = mysqli_num_rows($result);
     $_SESSION['reports'] = $queryResults;

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
    <title>Manager Area | Dashboard</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/adminstyle.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
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
            <li class="active"><a href="manager.php">Dashboard</a></li>
            <li><a href="report.php">Reports</a></li>
            <li><a href="refund.php">Refunds</a></li>
            <li><a href="rooms.php">Rooms</a></li>
            \
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
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard <small>Manager's System</small></h1>
          </div>
        </div>
      </div>
    </header>

    <!-- <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </section> -->

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
                echo $_SESSION['reports'];
              ?>
              </span></a>
             <a href="refund.php" class="list-group-item"><span class=" " aria-hidden="true"></span> Refunds<span class="badge">
              <?php   
                echo $_SESSION['refunds'];
              ?>
              </span></a>
              <a href="rooms.php" class="list-group-item"><span class=" "  aria-hidden="true"></span> Rooms <span class="badge">
              <?php   
                echo $_SESSION['rooms'];
              ?>
              </span></a>
              <a href="users.php" class="list-group-item"><span class="" aria-hidden="true"></span> Users <span class="badge">
              <?php   
                echo $_SESSION['users'];
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
                <h3 class="panel-title">Overview</h3>
              </div>
              <div class="panel-body">
                <div class="col-md-3">
                  <div class="well dash-box">
                    <h2><span class="" aria-hidden="true">
                      <?php   
                        echo $_SESSION['reports'];
                      ?>
                    </span></h2>
                    <h4>Reports</h4>
                  </div>
                </div><div class="col-md-3">
                  <div class="well dash-box">
                    <h2><span class="" aria-hidden="true">
                      <?php   
                        echo $_SESSION['refunds'];
                      ?>
                    </span></h2>
                    <h4>Refunds</h4>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="well dash-box">
                    <h2><span class="" aria-hidden="true">
                      <?php   
                        echo $_SESSION['rooms'];
                      ?>
              </span></h2>
                    <h4>Rooms</h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="well dash-box">
                    <h2><span class="" aria-hidden="true">
                      <?php   
                        echo $_SESSION['users'];
                      ?>
              </span></h2>
                    <h4>Users</h4>
                  </div>
                </div>
                
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
                      $sql = "SELECT * FROM users where user_type = 'Manager' order by last_login DESC";
                      $result = mysqli_query($conn, $sql);
                      $queryResults = mysqli_num_rows($result);

                      If($queryResults > 0){  
                          echo "
                              <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Last Login</th>
                              </tr>";

                            
                      while($row = mysqli_fetch_assoc($result)){
                          echo "
                            <tr>
                                <td>".$row['user_first']." ".$row['user_last']."</td>
                                <td>".$row['user_uid']."</td>
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
     <p>Rock Garden Resort, Copyright &copy; 2018 </p>
    </footer>

    <!-- Modals -->

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
