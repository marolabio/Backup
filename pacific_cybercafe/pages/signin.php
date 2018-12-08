<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.min.css">
    <link rel="stylesheet" href="../css/mdb.min.css">
    <style>
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Pacific Cybercafe</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
          aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto mt-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/register.php">Register</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="../pages/signin.php">Sign in</a>
            </li>
          </ul>
        </div>
        </div>
    </nav>


<?php
  $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  if(strpos($fullUrl, "signin=error") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Error:</strong> Your email or password is incorrect
    </div>';
  }elseif(strpos($fullUrl, "signin=empty") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Error:</strong> All fields are required
    </div>';
  }elseif(strpos($fullUrl, "register=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Account has been created
    </div>';
  }
 
?>

    <div class="container">
        <div class="well col-md-4 col-md-offset-4" style="margin-top: 20px;">
            <div class="panel-heading">
                <h1>Sign in</h1>
            </div>
      
            <form action="includes/login.inc.php" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password"><br>
                  <a href="forgotPassword.php">Forgot password?</a>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success btn-block">Login</button>
                  </div>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>