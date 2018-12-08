<?php
session_start();

// Auth
if(isset($_SESSION['c_id'])){
    // Extra Feature
}else{
    header("Location: signin.php");
}

require "vendor/autoload.php";

if (!$_POST['amount']) {
    header("location: addLoad.php");
    die();
}else{
    $amount = 'id=' .$_POST['cust_id']. '&' . 'l='.$_POST['amount'];
}

$Bar = new Picqer\Barcode\BarcodeGeneratorHTML();
$code = $Bar->getBarcode($amount, $Bar::TYPE_CODE_128);
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
        #qrbox>div {
            object-fit: fill;
            margin: auto;
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


    <div class="container" id="panel">

        <div class="row">
        <div class="well col-md-4 col-md-offset-4" style="margin-top: 20px;">
                <div class="panel-heading">
                    <h1>Pacific Cybercafe</h1>
                </div>
                <hr>
                    <div id="qrbox">
                        <?php echo $code ?>
                    </div>
                <hr>
                <p>Amount: <b>₱ <?php echo $_POST['amount']; ?></b></p>
                <p><span style="color:red;">Note: </span>Please present this barcode to the cashier.</p>
                <button onclick="window.location.href='rewards.php'" class="btn btn-info btn-block">Done</button>
            </div>
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
