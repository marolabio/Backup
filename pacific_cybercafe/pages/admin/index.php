<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }
    </style>
</head>

<body>


    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Admin</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active">
                        <a href="index.php">Sign in</a>
                    </li>
                </ul>

            </div>
            <!--/.nav-collapse -->
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
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <br>
                    <a href="forgotPassword.php">Forgot password?</a>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>