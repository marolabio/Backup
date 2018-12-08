<?php
  include_once 'includes/dbh.inc.php';
  
  session_start();



if(!isset($_SESSION['u_id']))
  {
    // not logged in
    header('Location: login.php');
    exit();
  }
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Pending</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/adminstyle.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <script src="js/jquery.ui.datepicker-fr.js"></script>

    <script type="text/javascript">
    
    $(document).ready(function(){

    $(function(){
      
        $('#checkin').datepicker({ minDate: 0,  dateFormat: 'yy-mm-dd',
      
      onSelect: function() {
        var date = $(this).datepicker('getDate');
        if (date){
          date.setDate(date.getDate() + 1);
          $( "#checkout" ).datepicker( "option", "minDate", date );
        }
      }     
      });

      
      $('#checkout').datepicker({ minDate: 1, dateFormat: 'yy-mm-dd'});
      
    });
    

(function($){

        function processForm( e ){

            $("#show").hide();
            $("#response").hide();
            $("#wait").css("display", "block");
            
            $.ajax({
                url: 'reservationAddLoad.php',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: $(this).serialize(),
                success: function( data, textStatus, jQxhr ){
                    $("#wait").css("display", "none");
                    $("#response").show();
                    $('#response').html( data );
                    
                setInterval(function(){
                 $("#response").load("reservationAddLoad.php");
                }, 5000);
                                          
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });

          //setTimeout(function(){ alert("The page has expired due to inactivity. Click OK to reload page."); window.location.reload();}, 120000);

            e.preventDefault();
        }


       $('#my-form').submit( processForm );

    })(jQuery);
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
          <a class="navbar-brand" href="#">Admin</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="admin.php">Dashboard</a></li>
            <li class = "active"><a href="reservation.php">Reservation</a></li>
            <li><a href="confirmed.php">Confirmed</a></li>
			      <li><a href="checkedin.php">Checked In</a></li>
            <li><a href="checkedout.php">Checked Out</a></li>
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

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="index.php">Dashboard</a></li>
          <li class="active">Reservation</li>
        </ol>
      </div>
    </section>

<section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            
            <div class="well">

      <form id ="my-form">
        <div class = "form-group">
          <label> Check-in:</label>
          <input type="text" class = "form-control" name = "checkin" id="checkin" placeholder="Check-in" required />
        </div>
        <div class = "form-group">
          <label> Check-out:</label>
          <input type = "text" class = "form-control" name = "checkout" id = "checkout" placeholder="Check-out" required />
        </div>
        <button type="submit" name = "submit" class="btn btn-default btn-block search">Search</button>
        </div>
      </form>

        </div>

          <div class="col-md-9">
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                 <h3 class="panel-title">  <a style = "text-decoration: none; cursor: pointer;" href = "reservation.php"><i class="fa fa-arrow-left"></i> Back</a></h3>
              </div>
              <div class="panel-body">

 <h1 id = "show" style = "text-align: center;">Please select dates</h1>
<div id = "wait" style = "display:none; ">
    <div style = "text-align:center;">
        <img src="../img/Preloader_2.gif" alt="Preloader" width="67" height="67" ><br>Loading, please wait...
    </div>
    
</div>

    <div id = "response"></div>
                    
              </div>
              </div>

          </div>
        </div>
      </div>
    </section>



  <script>
     CKEDITOR.replace( 'editor1' );
 </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
