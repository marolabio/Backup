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
    <title>Admin Area | Reservation</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/adminstyle.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <script src="js/jquery.ui.datepicker-fr.js"></script>
    <script type="text/javascript">
    $(function(){
      
        $('#checkin').datepicker({ minDate: -0,  dateFormat: 'yy-mm-dd',
      
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
  </script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
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

    