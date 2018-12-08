<script>
    setInterval(function () {
        $('#results').load('transaction-load.php')
    }, 2000);
</script>

<?php
    session_start();
    
    // Auth
    if(isset($_SESSION['u_id'])){
        // Extra Feature
    }else{
        header("Location: index.php");
    }


    if(isset($_POST['submit'])){
        include_once 'includes/dbh.inc.php';
        $sql = "SELECT * FROM redeem 
        INNER JOIN customers on customers.cust_id = redeem.cust_id
        INNER JOIN rewards on rewards.reward_id = redeem.reward_id
        where redeem.code = '$_POST[code]' AND redeem.redeem_status = '' AND expiration > NOW()";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = mysqli_fetch_assoc($result);
            $cust_id = $row['cust_id'];
            $reward_id = $row['reward_id'];
            $redeem_id = $row['redeem_id'];

            // Update status
            $conn->query("UPDATE redeem set redeem_status = 'redeemed' where redeem_id = '$redeem_id'");

            // Set values for the alert message
            $cust_first = $row['cust_first'];
            $reward_name = $row['reward_name'];
            // Set status
            echo "<script>alert('$cust_first is now capable of redeeming $reward_name')</script>";

        }else{
            echo "<script>alert('Error')</script>";
        }
        
        $row = mysqli_fetch_assoc($result);

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
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="transaction.php">Transaction</a>
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
    <br>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="well">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" id="promo" name="code" placeholder="Enter customer promo code" required>
                        </div>
                        <input type="submit" class="btn btn-primary form-control" value="Redeem" name="submit">
                    </form>
                </div>
            </div>


            <div class="col-lg-9">
                <div id="results"></div>
            </div>
        </div>
    </div>

<!-- Modals -->

<div class="modal fade" id="cust_redeem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="reward-redeem.php" method="POST">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel"><span id="rewardName"></span></h4>
          </div>
          <div class="modal-body">
            <div class="redeemReward">

              <input type="hidden" name="reward_id" id="reward_id">
              <input type="hidden" name="cust_id" id="cust_id">
              <input type="hidden" name="cust_email" id="cust_email">
              

              <table class="table table-bordered">
                  <tr>
                      <td>Available balance</td>
                      <td><span id="balance"></span></td>
                  </tr>
                  <tr>
                      <td>Cost</td>
                      <td><span id="pointsRequired"></span></td>
                  </tr>
                  <tr>
                      <td>Updated balance</td>
                      <td><span id="updatedBalance"></span></td>
                  </tr>
              </table>
              <input type="checkbox" required> <label for="checkbox">Are you sure?</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="submit" class="btn btn-success">Redeem</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<?php include 'includes/footer.inc.php'; ?>