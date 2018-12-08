<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Account Login</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/adminstyle.css" rel="stylesheet">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
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
          <a class="navbar-brand" href="../index.php">Home</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header" style = "margin:0;
    padding:0;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center"> Admin Area </h1>
          </div>
        </div>
      </div>
    </header>
    
<?php
  $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


    if(strpos($fullUrl, "login=empty") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> All fields are required
    </div>';
  }elseif(strpos($fullUrl, "login=error") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> Login Error
    </div>';
  }
  elseif(strpos($fullUrl, "email=sent") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Please Check Your Email Inbox!
    </div>';
  }


  
?>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <form id="login" action="includes/login.inc.php" class="well" method = "POST">
                  <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" class="form-control" name = "uid" placeholder="Username/Email">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name = "pwd" placeholder="Password">
                  </div>
				          <a href="forgotPassword.php">Forgot Password?</a>
                  <button type="submit" name = "submit" class="btn btn-default btn-block">Login</button>
              </form>
          </div>
        </div>
      </div>
    </section>

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
