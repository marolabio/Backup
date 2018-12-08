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
    <title>Manager Area | Rooms</title>
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
            <li class="active"><a href="rooms.php">Rooms</a></li>
            <li><a href="users.php">Users</a></li>

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
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Rooms <small></small></h1>
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
<?php
  $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  if(strpos($fullUrl, "delete=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Room deleted!
    </div>';
  }
  elseif(strpos($fullUrl, "create=empty") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> All fields are required!
    </div>';
  }
  elseif(strpos($fullUrl, "roomtype=invalid") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> Invalid input in room type!
    </div>';
  }
    elseif(strpos($fullUrl, "create=taken") == true){
    echo '
    <div class="alert alert-danger">
      <strong>Warning:</strong> Room is taken!
    </div>';
  }

?>



            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">
				<a style = "text-decoration: none; cursor: pointer;" data-toggle="modal" data-target="#createRoom">Create Room <i class="fa fa-plus-square"></i></a>
				</h3>
				
              </div>
              <div class="panel-body">
                <!-- <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" placeholder="Search Rooms...">
                      </div>
                </div> -->
                
                
<?php
	if(!isset($_POST['submit'])){
		$sql = "SELECT * FROM rooms";
		$result = mysqli_query($conn, $sql);
		$queryResults = mysqli_num_rows($result);
		If($queryResults > 0){	
			echo "
			<div class = 'table-responsive'>
			<table class='table table-striped table-hover'><tr>
					<th>Room Type</th>
					<th>Room Description</th>
          <th>Room Rate</th>
					<th>Max Occupancy</th>
          <th>Room QTY</th>
					<th>Action</th>
				</tr>"; 
				
			while($row = mysqli_fetch_assoc($result)){
				echo "<tr id = '$row[room_id]'>
					<td data-target = 'room_type'>".$row['room_type']."</td>
					<td data-target = 'room_description'>".$row['room_description']."</td>
          <td data-target = 'room_rate'>".$row['room_rate']."</td>
					<td data-target = 'room_max'>".$row['room_max']."</td>
          <td data-target = 'room_quantity'>".$row['room_quantity']."</td>
					<td><input type ='button' name = 'edit' value = 'Edit' data-id = '$row[room_id]' class = 'btn btn-info editRoom' data-toggle='modal'>
					<input type ='button' name = 'delete' value = 'Delete' data-id = '$row[room_id]' class = 'btn btn-danger deleteRoom' data-toggle='modal'></td>
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

$(document).on("click", ".editRoom", function (){
      var room_id = $(this).data('id');
      var room_type = $('#'+room_id).children('td[data-target=room_type]').text();
      var room_description = $('#'+room_id).children('td[data-target=room_description]').text();
      var room_max = $('#'+room_id).children('td[data-target=room_max]').text();
      var room_rate = $('#'+room_id).children('td[data-target=room_rate]').text();
      var room_quantity = $('#'+room_id).children('td[data-target=room_quantity]').text();

       $(".modal-body #r_id").val(room_id);
       $('#r_type').val(room_type);
       $('#r_description').val(room_description);
       $('#r_max').val(room_max);
       $('#r_rate').val(room_rate);
       $('#r_quantity').val(room_quantity);
       $('#editRoom').modal('show');   
    });
    
        $(document).on("click", ".deleteRoom", function () {
         var room_id = $(this).data('id');
         $("#room_id ").val( room_id );
         $('#deleteRoom').modal('show');
    });
</script>

    <!-- Modals -->
   <!-- Create Room -->
    <div class="modal fade" id="createRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "roomCreate.php" method = "POST" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Room</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Select image to upload:</label>
            <input type="file" name="file" required>
        </div>
        <div class="form-group">
          <label>Room Type</label>
          <input type="text" class="form-control" name = "room_type" placeholder="Room Type">
        </div>
        <div class="form-group">
          <label>Room Description</label>
          <textarea class="form-control" rows="5" name = "room_description" placeholder="Room Description"></textarea>
        </div>
        <div class="form-group">
          <label>Max Occupancy</label>
          <input type="number" class="form-control" name = "room_max" min = "1" max = "20" placeholder="Max Occupancy">
        </div>
        <div class="form-group">
          <label>Room Rate</label>
          <input type="text" class="form-control" name = "room_rate" placeholder="Room Rate">
        </div>
        <div class="form-group">
          <label>Room Quantity</label>
          <input type="number" class="form-control" name = "room_quantity" placeholder="Room Quantity">
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Create</button>
      </div>
    </form>
    </div>
  </div>
</div>
</div>

    <!-- Edit room -->
     <div class="modal fade" id="editRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "roomEdit.php" method = "POST" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Room</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name = "r_id" id = "r_id">
        <div class="form-group">
          <label>Select image to upload:</label>
            <input type="file" name="file" >
        </div>
        <div class="form-group">
          <label>Room Type</label>
          <input type="text" class="form-control" name = "r_type"  id = "r_type">
        </div>
        <div class="form-group">
          <label>Room Description</label>
          <textarea class="form-control" rows="5" name = "r_description" id = "r_description"></textarea>
        </div>
        <div class="form-group">
          <label>Max Occupancy</label>
          <input type="text" class="form-control" name = "r_max" id = "r_max" >
        </div>
    <div class="form-group">
          <label>Room Rate</label>
          <input type="text" class="form-control" name = "r_rate" id = "r_rate" >
        </div>
    <div class="form-group">
          <label>Room Quantity</label>
          <input type="number" class="form-control" name = "r_quantity" id = "r_quantity">
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Edit</button>
      </div>
    </form>
    </div>
  </div>
</div>
</div>


<!-- Delete Room-->

 <div class="modal fade" id="deleteRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "roomDelete.php" method = "POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Room</h4>
      </div>
      <div class="modal-body">
      </div>
        <input type="hidden" name="room_id" id = "room_id">
        <h1 style="text-align: center;">Are You Sure?</h1>
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