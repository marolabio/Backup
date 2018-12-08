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
    <title>Manager Area | Refunds</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/adminstyle.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          setInterval(function(){
              $("#refunds").load("refund-load.php");
          }, 500);
        });
    </script>
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
            <li><a href="report.php">Reports</a></li>
            <li class="active"><a href="refund.php">Refunds</a></li>
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
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Refunds <small></small></h1>
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


<?php
  $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


  if(strpos($fullUrl, "refund=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> The customer has been refunded 
    </div>';
    
  }elseif(strpos($fullUrl, "error=insufficient") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> Insufficient amount 
    </div>';
  }elseif(strpos($fullUrl, "invalid=input") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> Invalid input 
    </div>';
  }
  elseif(strpos($fullUrl, "refund=cancel") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Refund Cancelled 
    </div>';
  }
?>

            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Refunds</h3>
				
              </div>
              <div class="panel-body">
                <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" placeholder="Search Customer...">
                      </div>
                </div>
                <br>
                <div class = "table-responsive">
                 <div id = "refunds">
                   
                 </div>
                 </div>
              </div>
              </div>

          </div>
        </div>
      </div>
    </section>
<script type="text/javascript">
    $(document).on("click", ".refund", function () {
      var cust_id   = $(this).data('id');
      $.ajax({  
            url:"refundSelect.php",  
            method:"POST",  
            data:{cust_id:cust_id},  
            success:function(data){  
                  $('#refundDetails').html(data);  
                  $('#refund').modal('show'); 
            }  
      });
         
    });

    $(document).on("click", ".cancel", function () {
         var cust_id   = $(this).data('id');
         $(".modal-body #cust_id ").val( cust_id );
         $('#refundCancel').modal('show');
    });
    
</script>

    <!-- Modals -->

<!-- Refund -->

 <div class="modal fade" id="refund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "refundCustomer.php" method = "POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Refund Customer</h4>
      </div>
      <div class="modal-body" id = "refundDetails">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Refund</button>
      </div>
    </form>
    </div>
  </div>
</div>
    <!-- Refund cancel -->
    <div class="modal fade" id="refundCancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "refundCancel.php" method = "POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cancel Refund</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="cust_id" id = "cust_id">
        <h1 style="text-align: center;">Are you sure?</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Yes</button>
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