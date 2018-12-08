<?php 
    session_start();

    if(isset($_SESSION['c_id'])){
        // Extra Feature
    }else{
        header("Location: signin.php");
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

                    <li class="active">
                        <a href="addLoad.php">Load</a>
                    </li>
                    <li>
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
                    <h2>Please enter amount</h2>
                </div>
                
                <form action="generate.php" method="post">
                    <input type="hidden" name="cust_id" value="<?php echo $_SESSION['c_id'] ?>">
                    <input type="number" style="border-radius: 0px;" min="20" max="1000" name="amount" class="form-control" autocomplete="off" placeholder="Enter amount" value="" required>
                    <br>
                    <p><span style="color:red;">Note: </span>Minimum of 20 and maximum of 1000 worth of load</p>
                    <button type="submit" class="btn btn-block btn-md btn-outline-success">Generate</button>
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
