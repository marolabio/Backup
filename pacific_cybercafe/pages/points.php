<?php
    session_start();
    
    // Auth
    if(isset($_SESSION['c_id'])){
        // Extra Feature
    }else{
        header("Location: signin.php");
    }

if(isset($_POST['submit'])){
    
    include('includes/dbh.inc.php');

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = $conn->query("SELECT * FROM customers WHERE cust_email = '$email'");

    if ($sql->num_rows == 1) {


        $sql = $conn->query("SELECT * FROM customers  WHERE cust_id = '$_SESSION[c_id]'");
        $row = mysqli_fetch_assoc($sql);
     
        if($row['cust_email'] === $email){
            echo "<script>alert('Invalid');</script>";
        }else{
            if($row['cust_points'] >= $amount){
                $conn->query("insert into notification (to_cust, cust_id, amount, message) values ('$email','$_SESSION[c_id]','$amount','$message')");

                $conn->query("update customers set cust_points = cust_points - $amount WHERE cust_id = '$_SESSION[c_id]'");
    
                $sql = $conn->query("update customers set cust_points = cust_points + $amount WHERE cust_email = '$email'");
    
                if($sql){
                    echo "<script>alert('Transfer success!');</script>";
                }
    
            }else{
                echo "<script>alert('Insuficient points');</script>";
            }
        }
    }else{
        echo "<script>alert('Account do not exist');</script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }
    </style>
</head>

<body>


    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Pacific Cybercafe</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="rewards.php">Rewards</a>
                    </li>

                    <li>
                        <a href="addLoad.php">Load</a>
                    </li>
                    <li class = "active">
                        <a href="points.php">Points</a>
                    </li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="label label-pill label-danger count" style="border-radius:10px;"></span>
                            <span class="glyphicon glyphicon-envelope" style="font-size:18px;"></span>
                        </a>
                        <ul class="dropdown-menu"></ul>
                    </li>
                    <li>
                        <a href="includes/logout.inc.php">Log out</a>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">
    <div class="well col-md-4 col-md-offset-4" style="margin-top: 20px;">
        <div class="panel-heading">
            <h2>Send points</h2>
        </div>
        <form id="signup" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Send points to" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="amount" min = "1" placeholder="Amount" required>
            </div>

            <div class="form-group">
                <textarea name="message" class="form-control" id="message"  rows="5" placeholder = "Message"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" name = "submit" class="btn btn-success">Send</button>
            </div>
              </form>
    </div>
    </div>
    <script>
        $(document).ready(function () {
    
            function load_unseen_notification(view = '') {
                $.ajax({
                    url: "fetch.php",
                    method: "POST",
                    data: { view: view },
                    dataType: "json",
                    success: function (data) {
                        $('.dropdown-menu').html(data.notification);
                        if (data.unseen_notification > 0) {
                            $('.count').html(data.unseen_notification);
                        }
                    }
                });
            }

            load_unseen_notification();

            $(document).on('click', '.dropdown-toggle', function () {
                $('.count').html('');
                load_unseen_notification('yes');
            });

            setInterval(function () {
                load_unseen_notification();;
               
            }, 5000);

        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
