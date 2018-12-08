<?php   
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" type="image/png" href="/img/iconLogo.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Affordable, family oriented, with an open food policy resort">
    <meta name="author" content="Rolandi Torres">
    <title>Rock Garden Resort | Access Reservation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nav.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </head>
    <body>

    <header>
      <nav class = "navbar navbar-inverse navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".toggle-target">
              <span class = "icon-bar"></span>
              <span class = "icon-bar"></span>
              <span class = "icon-bar"></span>
            </button>
            <a href="index.php" class = "navbar-brand">
              <img src="/img/RGR_LOGO.png">
            </a>
           </div>

            <div class = "collapse navbar-collapse toggle-target">
              <ul class = "nav navbar-nav navbar-right">
                  
                <li><a href="index.php">Home</a></li>
                <li><a href="accommodation.php">Accommodation</a></li>
                <li><a href="facilities.php">Facilities</a></li>
                
                  <li class="active dropdown">
                    <a href="#" class = "dropdown-toggle" data-toggle = "dropdown">Book Now <b class = "caret"></b></a>
                      <ul class = "dropdown-menu">
                        <li><a href="booknow.php">Book now</a></li>
                        <li><a href="modify.php">Access Reservation</a></li>
                      </ul>
                  </li>

              </ul>
            </div> 

      </div>
      </nav>
    </header>

<?php
  $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  if(strpos($fullUrl, "cancel=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Your reservation has been cancelled
    </div>';
  }
  elseif(strpos($fullUrl, "logout=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Logout success
    </div>';
  }elseif(strpos($fullUrl, "login=empty") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> All fields are required
    </div>';
  }
  elseif(strpos($fullUrl, "modify=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> You have successfully updated your reservation.
    </div>';
  }
    elseif(strpos($fullUrl, "transaction_id=error") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> The transaction ID you’ve entered is incorrect.
    </div>';
  }
      elseif(strpos($fullUrl, "email=error") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> The email you’ve entered is incorrect.
    </div>';
      }
    elseif(strpos($fullUrl, "depositSlip=sent") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> You have already sent a deposit slip. For concerns, please contact us at Globe 09176836670 or Smart 0920413927.
    </div>';
  }

  
?>
<br>
    <div class="col-md-4 col-md-offset-4">
      <form id="login" action="includes/login.inc.php" class="well" method = "POST">
                  <div class="form-group">
                    <p>Please enter the email address and the Transaction ID of the reservation you wish to modify or send deposit slip.</p>
                    <label>Email Address</label>
                    <input type="text" class="form-control" name = "cust_email" placeholder="Email Address">
                  </div>
                  <div class="form-group">
                    <label>Transaction ID</label>
                    <input type="text" class="form-control" name = "transaction_id" placeholder="Transaction ID">
                  </div>
         
                  <button type="submit" name = "submit" class="btn btn-default btn-block">Next</button>
              </form>
    </div>
      
  </body>
  </html>  