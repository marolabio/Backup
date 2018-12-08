<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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
                <a class="navbar-brand" href="#">Manager</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                </ul>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="rewards.php">Rewards</a>
                    </li>
                    <li class="active">
                        <a href="register.php">Users</a>
                    </li>
                    <li>
                        <a href="reports.php">Reports</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="includes/logout.inc.php">Log out</a>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
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
  }
  elseif(strpos($fullUrl, "password=notMatching") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Error:</strong> Password not matching
    </div>';
  }
  elseif(strpos($fullUrl, "register=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Account has been created
    </div>';
  }
?>

<br>
<div class="container">
<div class="row">
      <div class="col-md-4 col-sm-4">
        <div class="panel panel-primary">
          <div class="panel-heading"><span id="panel-heading">Create Account</span> </div>
          <div class="panel-body">
            <form id="form-id" action="includes/signup.inc.php" method="post">
                  <input type="hidden" name="user_id" id="user_id">
                  <div class="form-group">
                    <select name = "type" id="type" class = "form-control">
                      <option value="Admin">Admin</option>
                      <option value="Manager">Manager</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="user_first" name="firstName" placeholder="First name" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="user_last" name="lastName" placeholder="Last name" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="user_email" name="email" placeholder="Email address" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" id="password1" name = "password1" placeholder="Confirm password" required>
                  </div>

                  <div class="form-group">
                    <button type="submit" id="btn-submit" name = "submit" class="btn form-control btn-primary">Create account</button>
                  </div>
              </form>
          </div>
        </div>
      </div>




      <div class="col-sm-8">
        <div id="results"></div>
      </div>
    </div>
</div>


  <script>
    setInterval(function () {
      $('#results').load('register-load.php')
    }, 2000);
  </script>

  <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="register-delete.php" method="POST">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Delete User</h4>
          </div>
          <div class="modal-body">
            <div class="deleteUser">
              <input type="hidden" name="user_id" id="user_id">
            </div>
            <h1 style="text-align: center;">Are You Sure?</h1>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="submit" class="btn btn-danger">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="js/bootstrap.min.js"></script>
  <?php include 'includes/footer.inc.php'; ?>


