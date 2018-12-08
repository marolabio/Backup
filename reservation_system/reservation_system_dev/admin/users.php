<?php
  include_once 'includes/dbh.inc.php';
  session_start();



if(!isset($_SESSION['u_id']))
  {
    // not logged in
    header('Location: login.php');
    exit();
  }else{

     $sql = "SELECT * FROM reports";
     $result = mysqli_query($conn, $sql);
     $queryResults = mysqli_num_rows($result);
     $_SESSION['reports'] = $queryResults;

     $sql = "SELECT * FROM customers inner join billing on billing.cust_id = customers.cust_id 
     where cust_status = 'refund'";
     $result = mysqli_query($conn, $sql);
     $queryResults = mysqli_num_rows($result);
     $_SESSION['refunds'] = $queryResults;

     $sql = "SELECT * FROM rooms";
     $result = mysqli_query($conn, $sql);
     $queryResults = mysqli_num_rows($result);
     $_SESSION['rooms'] = $queryResults;

     $sql = "SELECT * FROM users";
     $result = mysqli_query($conn, $sql);
     $queryResults = mysqli_num_rows($result);
     $_SESSION['users'] = $queryResults;

  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manager Area | Users</title>
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
          <a class="navbar-brand" href="#">Manager</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="manager.php">Dashboard</a></li>
            <li><a href="report.php">Reports</a></li>
            <li><a href="refund.php">Refunds</a></li>
            <li><a href="rooms.php">Rooms</a></li>
            <li class="active"><a href="users.php">Users</a></li>

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
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Users <small></small></h1>
          </div>
        </div>
      </div>
    </header>


    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a href="manager.php" class="list-group-item active main-color-bg">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
              </a>
              <a href="report.php" class="list-group-item"><span class=" " aria-hidden="true"></span> Reports<span class="badge">
              <?php   
                echo $_SESSION['reports'];
              ?>
              </span></a>
             <a href="refund.php" class="list-group-item"><span class=" " aria-hidden="true"></span> Refunds<span class="badge">
              <?php   
                echo $_SESSION['refunds'];
              ?>
              </span></a>
              <a href="rooms.php" class="list-group-item"><span class=" "  aria-hidden="true"></span> Rooms <span class="badge">
              <?php   
                echo $_SESSION['rooms'];
              ?>
              </span></a>
              <a href="users.php" class="list-group-item"><span class="" aria-hidden="true"></span> Users <span class="badge">
              <?php   
                echo $_SESSION['users'];
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
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">
				<a style = "text-decoration: none; cursor: pointer;" data-toggle="modal" data-target="#addUser">Create User <i class="fa fa-plus-square"></i></a>
				</h3>
				
              </div>
              <div class="panel-body">
                <!-- <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" placeholder="Filter Users...">
                      </div>
                </div> -->
                
                
<?php
	if(!isset($_POST['submit'])){
		$sql = "SELECT * FROM users";
		$result = mysqli_query($conn, $sql);
		$queryResults = mysqli_num_rows($result);
		If($queryResults > 0){	
			echo "
			<div class = 'table-responsive'>
			<table class='table table-striped table-hover'><tr>
					<th>Account</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email Name</th>
					<th>Username</th>
					<th>Action</th>
				</tr>"; 
				
			while($row = mysqli_fetch_assoc($result)){
				echo "<tr id = '$row[user_id]'>
				  <td>".$row['user_type']."</td>
					<td data-target = 'user_first'>".$row['user_first']."</td>
					<td data-target = 'user_last'>".$row['user_last']."</td>
					<td data-target = 'user_email'>".$row['user_email']."</td>
					<td data-target = 'user_uid'>".$row['user_uid']."</td>
					<td><input type ='button' name = 'edit' value = 'Edit' data-id = '$row[user_id]' class = 'btn btn-info editUser' data-toggle='modal'>
					<input type ='button' name = 'delete' value = 'Delete' data-id = '$row[user_id]' class = 'btn btn-danger deleteUser' data-toggle='modal'></td>
				</tr>";"</table>";
			}
		}	
	}
?>

                    
              </div>
              </div>

          </div>
        </div>
      </div>
    </section>
<script type="text/javascript">
    $(document).on("click", ".editUser", function (){
      var user_id = $(this).data('id');
      var user_first = $('#'+user_id).children('td[data-target=user_first]').text();
      var user_last = $('#'+user_id).children('td[data-target=user_last]').text();
      var user_email = $('#'+user_id).children('td[data-target=user_email]').text();
      var user_uid = $('#'+user_id).children('td[data-target=user_uid]').text();
       $(".modal-body #user_id").val(user_id );
       $('#user_first').val(user_first);
       $('#user_last').val(user_last);
       $('#user_email').val(user_email);
       $('#user_uid').val(user_uid);
       $('#editUser').modal('show');   
    });
        

        $(document).on("click", ".deleteUser", function () {
         var user_id = $(this).data('id');
         $("#user_id ").val( user_id );
         $('#deleteUser').modal('show');
    });
</script>

    <!-- Modals -->
    <!-- Add users -->
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "includes/signup.inc.php" method = "POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add User</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Account Type</label>
          <select name = "type" class = "form-control">
            <option value="Admin">Admin</option>
            <option value="Manager">Manager</option>
          </select>
        </div>
        <div class="form-group">
          <label>First Name</label>
          <input type="text" class="form-control" name = "first" placeholder="First name">
        </div>
        <div class="form-group">
          <label>Last Name</label>
          <input type="text" class="form-control" name = "last" placeholder="Last name">
        </div>
    <div class="form-group">
          <label>Email</label>
          <input type="text" class="form-control" name = "email" placeholder="Email">
        </div>
    <div class="form-group">
          <label>Username</label>
          <input type="text" class="form-control" name = "uid" placeholder="Username">
        </div>
    <label>Password</label>
          <input type="password" class="form-control" name = "pwd" placeholder="Password">
        </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Create</button>
      </div>
    </form>
    </div>
  </div>
</div>


    <!-- Edit User -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "userEdit.php" method = "POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit User</h4>
      </div>
      <div class="modal-body">
          <input type="hidden" class="form-control" name = "user_id" id ="user_id">
        <div class="form-group">
          <label>First Name</label>
          <input type="text" class="form-control" name = "user_first" id= "user_first">
        </div>
        <div class="form-group">
          <label>Last Name</label>
          <input type="text" class="form-control" name = "user_last" id = "user_last">
        </div>
    <div class="form-group">
          <label>Email</label>
          <input type="text" class="form-control" name = "user_email" id = "user_email">
        </div>
    <div class="form-group">
          <label>Username</label>
          <input type="text" class="form-control" name = "user_uid" id ="user_uid">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Edit</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Delete -->

 <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "userDelete.php" method = "POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="user_id" id = "user_id">
        <h1 style="text-align: center;">Are You Sure?</h1>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Delete</button>
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