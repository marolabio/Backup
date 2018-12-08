<?php
  include_once 'includes/dbh.inc.php';
  session_start();
  unset($_SESSION['reservations']);
  
    unset($_SESSION['rooms']);
    unset($_SESSION['c_first']);
    unset($_SESSION['c_last']);
    unset($_SESSION['c_contact']);
    unset($_SESSION['c_email']);
    unset($_SESSION['cust_email']);

if(!isset($_SESSION['u_id']))
  {
    // not logged in
    header('Location: login.php');
    exit();

  }else{

          include_once 'expiration.php';

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

  if (!isset($_GET['page'])) {
      $_SESSION['page'] = 1;
  } else {
      $_SESSION['page'] = preg_replace('#[^0-9]#', '', $_GET['page']);
  }


?>

<div id = "expirationLoad"></div>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Reservation</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/adminstyle.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <li class = "active"><a href="reservation.php">Reservation</a></li>
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
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Reservation</h1>
          </div>
        </div>
      </div>
    </header>

<!--    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="admin.php">Dashboard</a></li>
          <li class="active">Reservation</li>
        </ol>
      </div>
    </section>-->

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


  if(strpos($fullUrl, "error=nonnumeric") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> You used an invalid characters
    </div>';
  }elseif(strpos($fullUrl, "error=insufficient") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> Insufficient payment
    </div>';
  }elseif(strpos($fullUrl, "cancel=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Reservation cancelled
    </div>';
  }elseif(strpos($fullUrl, "walkin=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Reservation has been created
    </div>';
  }elseif(strpos($fullUrl, "mailverify=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Payment verified, temporary receipt has been sent to the customer via email
    </div>';

  }elseif(strpos($fullUrl, "walkinfullpayment=success") == true){

    if(isset($_SESSION['change'])){
      if($_SESSION['change'] != 0){
        echo "<script type='text/javascript'>alert('Change: P ".number_format($_SESSION ['change'], 2)."')</script>";
        unset($_SESSION['change']);
      }
    }

    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> The customer ready for check-in
    </div>
    ';

  }elseif(strpos($fullUrl, "walkinprepayment=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> The customer has been verified
    </div>
    ';

  }elseif(strpos($fullUrl, "discount=once") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> One time discount only
    </div>
    ';
  }elseif(strpos($fullUrl, "discount=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Discount applied
    </div>
    ';
  }

  
?>


        
            <div class="panel panel-default">

              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">  <a style = "text-decoration: none; cursor: pointer;" href = "reservationAdd.php"><i class="fa fa-plus-square"> Create </i></a></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" name = "search_text" id = "search_text" placeholder="Search customer">
                      </div>
                </div>
                <br>
                <!-- For paging -->
                <?php 
                  if (!isset($_GET['page'])) {
                    $_SESSION['page'] = 1;
                  } else {
                    $_SESSION['page'] = $_GET['page'];
                  }
                ?>

                <div class = "table-responsive">
                  <div id = "reservation-load"></div>
                  <div id = "result"></div>
                
              </div>
              </div>

          </div>
        </div>
      </div>
    </section>

<script type="text/javascript">
  $(document).ready(function(){

      setInterval(function(){
        $("#reservation-load").load("reservation-load.php");
      }, 2000);

      setInterval(function(){
        $("#expirationLoad").load("expiration.php");
      }, 1000);
        
      $('#search_text').keyup(function(){
      var txt = $(this).val();
        if(txt == ''){
         $('#result').html('');
          $.ajax({
            url:"reservationFetch.php",
            method:"post",
            data: {search:txt},
            dataType:"text",
            success:function(data)
            {
              $('#result').html(data);
            }
          });
        }else{

        $("#reservation-load").detach();
         $('#result').html('');
          $.ajax({
            url:"reservationFetch.php",
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
     
    $(document).on("click", ".verify", function () {
      var cust_id = $(this).data('id');
       $("#cust_id").val(cust_id );
       
        $.ajax({  
                url:"reservationSelect.php",  
                method:"post",  
                data:{cust_id:cust_id},  
                success:function(data){  
                     $('#verifyDetails').html(data);  
                     $('#verify').modal("show");  
                }  
           });  
    });


       $(document).on("click", ".cancel", function () {
         var cust_id   = $(this).data('id');
         $(".modal-body #cust_id").val( cust_id );
         $('#cancel').modal("show");  

      });

      $(document).on("click", ".discount", function () {
         var cust_id   = $(this).data('id');
         $("#discount_id").val( cust_id );
         $.ajax({  
                url:"discountSelect.php",  
                method:"post",  
                data:{cust_id:cust_id},  
                success:function(data){  
                     $('#discountDetails').html(data);  
                     $('#discount').modal("show");  
                }  
           });  


      });


  });
</script>

    <!-- Modals -->

    <!-- Verify -->
    <div class="modal fade" id="verify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "reservationVerify.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Verify</h4>
      </div>
      <div class="modal-body" id = "verifyDetails"> 
      </div>
       <input type="hidden" name= "cust_id" id = "cust_id">
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name ="submit" class="btn btn-primary">Verify</button>
      </div>
    </form>
    </div>
  </div>
</div>

    <!-- Cancel -->
    <div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "reservationCancel.php" method = "POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cancel Reservation</h4>
      </div>
      <div class="modal-body">
        <div style = 'text-align: center;'>
             <h1>Are you sure?</h1>
        </div>
        <input type="hidden" name="cust_id" id = "cust_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Yes</button>
      </div>
    </form>
    </div>
  </div>
</div>

 <!-- Discount -->
    <div class="modal fade" id="discount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "discountApply.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Apply Discount</h4>
      </div>
        <div class="modal-body" id = "discountDetails">
      </div>
        <input type="hidden" name = "cust_id" id = "discount_id">
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Apply</button>
      </div>
    </form>
    </div>
  </div>
</div>


  <footer id="footer">
    <p>Rock Garden Resort, Copyright &copy; 2018 </p>
  </footer>

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




      



