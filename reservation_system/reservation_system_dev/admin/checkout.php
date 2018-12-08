<?php
  include_once 'includes/dbh.inc.php';
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

          $result = mysqli_query($conn, "SELECT * FROM customers 
          where cust_status = 'checkedin'");
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
    <title>Admin Area | Check-out</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/adminstyle.css" rel="stylesheet">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   
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
          <a class="navbar-brand" href="#">Admin</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="reservation.php">Reservation</a></li>
            <li><a href="confirmed.php">Confirmed</a></li>
            <li><a href="checkin.php">Check-in</a></li>
            <li class="active"><a href="checkout.php">Check-out</a></li>
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
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Check-out</h1>
          </div>
        </div>
      </div>
    </header>

<!--    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="admin.php">Dashboard</a></li>
          <li class="active">Check-out</li>
        </ol>
      </div>
    </section>
-->
    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
               <a href="admin.php" class="list-group-item active main-color-bg">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
              </a>
              <a href="reservation.php" class="list-group-item"><span class=" " aria-hidden="true"></span> Reservation <span class="badge">
              <?php   
              echo $_SESSION['waiting'];
              ?>
              </span></a>
              <a href="confirmed.php" class="list-group-item"><span class=" "  aria-hidden="true"></span> Confirmed <span class="badge">
              <?php   
              echo $_SESSION['confirmed'];
              ?>
              </span></a>
             
              <a href="checkin.php" class="list-group-item"><span class="" aria-hidden="true"></span> Check-in <span class="badge">
              <?php   
              echo $_SESSION['checkin'];
              ?>
              </span></a>
                <a href="checkout.php" class="list-group-item"><span class="" aria-hidden="true"></span> Check-out <span class="badge">
              <?php   
              echo $_SESSION['checkedin'];
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

  if(strpos($fullUrl, "checkout=success") == true){
    if(isset($_SESSION['change'])){
      if($_SESSION['change'] != 0){
        echo "<script type='text/javascript'>alert('Change: P ".number_format($_SESSION ['change'], 2)."')</script>";
        unset($_SESSION['change']);
      }
    }

    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> The customer has been checked-out
    </div>';
  }
  elseif(strpos($fullUrl, "update=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Customer bill has been updated
    </div>';
  }
    elseif(strpos($fullUrl, "error=nonnumeric") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> Invalid input
    </div>';
  }
  elseif(strpos($fullUrl, "error=insufficient") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> Insufficient
    </div>';
  }
  elseif(strpos($fullUrl, "balance=notpaid") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> Balance not paid
    </div>';
  }
  elseif(strpos($fullUrl, "checkout=successful") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Customer has been checked-out
    </div>';
  }
  elseif(strpos($fullUrl, "paid=successful") == true){
    
    if(isset($_SESSION['change'])){
      echo "<script type='text/javascript'>alert('Change: P ".number_format($_SESSION ['change'], 2)."')</script>";
        unset($_SESSION['change']);
    }
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Customer is okay for check-out
    </div>';
  }
?>


            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Check-out</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" name = "search_text" id = "search_text" placeholder="Search Customers...">
                      </div>
                </div>
                <br>
                <div class = "table-responsive">
               <div id = "checkout-load"></div>
               <div id = "result"></div>
              </div>
              </div>

          </div>
        </div>
      </div>
    </section>

    <footer id="footer">
      <p>Rock Garden Resort, Copyright &copy; 2018 </p>
    </footer>

<script type="text/javascript">
$(document).ready(function(){

  $("#checkout-load").load("checkout-load.php");

  $('#search_text').keyup(function(){
      var txt = $(this).val();
        if(txt == ''){
         $('#result').html('');
          $.ajax({
            url:"checkoutFetch.php",
            method:"post",
            data: {search:txt},
            dataType:"text",
            success:function(data)
            {
              $('#result').html(data);
            }
          });
        }else{

        $("#checkout-load").detach();
         $('#result').html('');
          $.ajax({
            url:"checkoutFetch.php",
            method:"post",
            data:{search:txt},
            dataType:"text",
            success:function(data)
            {
              $('#result').html(data);
            }
          });
        } 
    });

  $(document).on("click", ".view", function () {
    var cust_id = $(this).data('id');   
        $.ajax({  
          url:"viewCheckout.php",  
          method:"POST",  
          data:{cust_id:cust_id},  
              success:function(data){  
                $('.viewDetails').html(data);       
              } 
        });              
  }); 

  $(document).on("click", ".update", function () {
    var cust_id = $(this).data('id');
    $("#cust_id").val( cust_id );
      $.ajax({  
          url:"checkoutSelectUpdate.php",  
          method:"POST",  
          data:{cust_id:cust_id},  
          success:function(data){  
                $('#updateDetails').html(data);  
                $('#update').modal('show'); 
          } 
      });
  });

  $(document).on("click", ".pay", function () {
    var cust_id = $(this).data('id');
    $("#cust_id").val( cust_id );
      $.ajax({  
          url:"checkoutSelectCheckout.php",  
          method:"POST",  
          data:{cust_id:cust_id},  
          success:function(data){  
            $('#payDetails').html(data);  
            $('#pay').modal('show'); 
          } 
        });          
  }); 


  $(document).on("click", ".checkout", function () {
    var res_id = $(this).data('id');
      $("#res_id").val( res_id );
      $('#checkout').modal('show'); 
  }); 

  $(document).on("click", ".print", function () {
    var cust_id = $(this).data('id');
      $(".modal-body #cust_id").val( cust_id );
      $('#print').modal("show");
  }); 

});
</script>

  <!-- Checkout -->
    <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "checkoutCheckout.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Check-out Customer</h4>
      </div>
        <div class="modal-body">
          <h1 style = "text-align: center;">Are you sure?</h1>
      </div>
        <input type="hidden" name = "res_id" id = "res_id"> 
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Check-out</button>
      </div>
    </form>
    </div>
  </div>
</div>

  <!-- pay -->
    <div class="modal fade" id="pay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "checkoutPay.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Pay remaining balance</h4>
      </div>
        <div class="modal-body" id= "payDetails">
      </div>
        <input type="hidden" name = "cust_id" id = "cust_id"> 
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Pay</button>
      </div>
    </form>
    </div>
  </div>
</div>

    <!-- Print -->
    <div class="modal fade" id="print" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "checkoutReceipt.php" target = "_blank" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Print receipt</h4>
      </div>
        <div class="modal-body" >
          <div style = 'text-align: center;'>
             <h1>Are you sure?</h1>
          </div>
        <input type="hidden" name = "cust_id" id = "cust_id">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Print</button>
      </div>
    </form>
    </div>
  </div>
</div>

  <!-- Update -->
    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <form action = "checkoutUpdate.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update customer bill</h4>
      </div>
        <div class="modal-body" id= "updateDetails">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Update</button>
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
