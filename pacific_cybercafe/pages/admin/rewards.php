<?php
    session_start();

    // Auth
    if(isset($_SESSION['u_id'])){
        // Extra Feature
    }else{
        header("Location: index.php");
    }

    if(isset($_POST['submit'])) { 
        include 'includes/dbh.inc.php';
        $reward_name = mysqli_real_escape_string($conn, $_POST['reward_name']);
        $reward_points = mysqli_real_escape_string($conn, $_POST['reward_points']);
        $date = date('Y-m-d H:i:s');
        $sql = "insert into rewards (reward_name, reward_points) values ('$reward_name','$reward_points')";
      

        if($conn->query($sql)===TRUE){
          // Get reward_id
          $reward_id = $conn->insert_id;

    
          // Insert image	

          $file = $_FILES['file'];
          $fileName = $_FILES['file']['name'];
          $fileTmpName = $_FILES['file']['tmp_name'];
          $fileSize = $_FILES['file']['size'];
          $fileError = $_FILES['file']['error'];
          $fileType = $_FILES['file']['type'];

          $fileExt = explode('.', $fileName);
          $fileActualExt = strtolower(end($fileExt));

          $allowed = array('jpg', 'jpeg', 'png', 'pdf');

          if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
              if($fileSize < 1000000){

                $file = addslashes($fileTmpName);
                $file  = file_get_contents($file);
                $file  = base64_encode($file);

                $sql = "Update rewards set reward_img = '$file' where reward_id = '$reward_id'";
                $result = mysqli_query($conn, $sql);
            
                  if($result){
                    header("Location: ../admin/rewards.php?create=success");
                    exit();	
                  }else{
                    echo "image not uploaded.";
                  }

              }else{
                echo "Your file is to big!";
              }
            }else{
              echo "There was an error uploading your file!";
            }

          }else{
            echo "You cannot upload files of this type!";
          }

        }else{
            echo "<script>alert('Something went wrong!');</script>";
        }

    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin</title>
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
              <li class="active">
                  <a href="rewards.php">Rewards</a>
              </li>
              <li>
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

  if(strpos($fullUrl, "create=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Reward has been created   
    </div>';
  }elseif(strpos($fullUrl, "delete=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Reward has been deleted
    </div>';
  }elseif(strpos($fullUrl, "edit=success") == true){
    echo '
    <div class="alert alert-success">
      <strong>Success:</strong> Reward has been Edited
    </div>';
  }
?>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-4">
        <div class="panel  panel-primary">
          <div class="panel-heading"><span id="panel-heading">Create</span> Reward Catalog</div>
          <div class="panel-body">
            <form id="form-id" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="reward_id" id="reward_id">
              <div class="form-group">
                <input type="text" name="reward_name" class="form-control" id="reward_name" placeholder="Name" required>
              </div>
              <div class="form-group">
                <input type="number" name="reward_points" id="reward_points" placeholder="Required Points" class="form-control">
              </div>
              <div class="form-group">
                <input type="file" name="file" class="form-control-file" id="reward_img" >
              </div>

              <button type="submit" name="submit" class="btn btn-primary form-control" id="btn-submit">Create</button>

            </form>
          </div>
        </div>
      </div>


      <div class="col-lg-8">
        <div id="results"></div>
      </div>
    </div>
  </div>



  </div>

<script>
$(document).ready(function () {
    setInterval(function () {
      $('#results').load('rewards-load.php')
    }, 2000);


    $(document).on("click", ".delete", function () {
         var reward_id = $(this).data('id');
          $(".deleteReward #reward_id").val( reward_id );
          $('#deleteReward').modal('show'); 
    });

    $(document).on("click", ".edit", function (){

      var reward_id = $(this).data('id');
      var reward_name = $('#'+reward_id).children('td[data-target=reward_name]').text();
      var reward_points = $('#'+reward_id).children('td[data-target=reward_points]').text();

       // Set value to be updated
       $("#reward_id").val(reward_id);
       $('#reward_name').val(reward_name);
       $('#reward_points').val(reward_points);

       // Change heading and classes
       $('#panel-heading').html('Update');
       $('#btn-submit').html('Update');
       $('#btn-submit').removeClass('btn-success');
       $('#btn-submit').addClass('btn-primary');

       // Change form action
       var newAction = 'rewards-edit.php';
       $('#form-id').attr('action', newAction);

    });

});
</script>

  <div class="modal fade" id="deleteReward" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="rewards-delete.php" method="POST">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Delete Reward</h4>
          </div>
          <div class="modal-body">
            <div class="deleteReward">
              <input type="hidden" name="reward_id" id="reward_id">
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

  <?php include 'includes/footer.inc.php'; ?>