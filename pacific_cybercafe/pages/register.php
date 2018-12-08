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
            <li class="nav-item active">
              <a class="nav-link" href="../pages/register.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/signin.php">Sign in</a>
            </li>
          </ul>
        </div>
        </div>
    </nav>





    <?php
  $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  if(strpos($fullUrl, "register=empty") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Error:</strong> All fields are required   
    </div>';
  }elseif(strpos($fullUrl, "register=invalid") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Error:</strong> Please input a valid name
    </div>';
  }elseif(strpos($fullUrl, "register=email") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Error:</strong> Please input a valid email
    </div>';
  }elseif(strpos($fullUrl, "register=usertaken") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Error:</strong> Email already taken, please use other email
    </div>';
  }elseif(strpos($fullUrl, "password=notMatching") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Error:</strong> Password not matching
    </div>';
  }elseif(strpos($fullUrl, "register=unsuccessful") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Error:</strong> Register unsuccessful
    </div>';
  }


  
?>

    <div class="container">
      <div class="well col-md-4 col-md-offset-4" style="margin-top: 20px;">
        <div class="panel-heading">
          <h1>Register</h1>
        </div>
        <form id="signup" action="includes/signup.inc.php" method="post">
          <div class="form-group">
            <input type="text" class="form-control" name="firstName" placeholder="First name" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="lastName" placeholder="Last name" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Email address" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password1" placeholder="Confirm password" required>
          </div>

          <div class="form-group">
            <button type="submit" name="submit" class="btn btn-success">Create account</button>
          </div>
        </form>
      </div>
    </div>





    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/mdb.min.js"></script>
</body>

</html>