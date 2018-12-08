<?php 
    session_start(); 

    if(isset($_SESSION['c_id'])){
        include_once 'includes/dbh.inc.php';
        $query = "SELECT * FROM transaction
                WHERE cust_id = '$_SESSION[c_id]' AND tran_status = 'confirmed'
                ORDER BY created_at DESC LIMIT 10";  
 
        $result = mysqli_query($conn, $query);  
        $found = mysqli_num_rows($result);

    }else{
        header("Location: signin.php");
        exit();
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
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
    
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
                    <li class="active">
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="rewards.php">Rewards</a>
                    </li>

                    <li>
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
    

    <!-- JUMBOTRON -->
    <div class="jumbotron text-center">
        <div class="container">
            <h1>Welcome, <?php echo $_SESSION['c_first'];?>!</h1>
            <p>Load to earn points and redeem great rewards.</p>
        </div>
    </div>

    <div class="container">

        <div class="row">

                <div class="col-md-3">

                        <div class="well">
                            <b>Points: </b><span id="points"></span>
                        </div>
        
                    
                                <b>INSTRUCTIONS</b>
                
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse1" style="text-decoration: none !important;">How to load</a>
                                        </h4>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">1.) Click on Load</li>
                                                <li class="list-group-item">2.) Enter the amount you want to load</li>
                                                <li class="list-group-item">3.) Click generate</li>
                                                <li class="list-group-item">4.) Present the generated barcode to the respective personel of pacific cybercafe</li>
                                                <li class="list-group-item">5.) Pay the specific amount</li>
                                            </ul>
                                        </div>
                                        </div>
                                    </div>
            
                                    <div class="panel panel-default">
                                            <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse2" style="text-decoration: none !important;">How send points</a>
                                            </h4>
                                            </div>
                                            <div id="collapse2" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">1.) Click on points</li>
                                                    <li class="list-group-item">2.) Enter the email address of the recipient you want to send points</li>
                                                    <li class="list-group-item">3.) Enter the amount of points</li>
                                                    <li class="list-group-item">4.) Enter your message to the recipient</li>
                                                    <li class="list-group-item">5.) Click on send</li>
                                                </ul>
                                            </div>
                                            </div>
                                    </div>
                                </div>
            
                    </div>


 <div class="col-md-9">
 <div class="panel panel-default" style = "height: 90vh; fit-content:true;">
            <div class="panel-heading">History</div>
            <div class="panel-body">
                <div class="table-responsive">  
                    <table id="reports_data" class="table table-striped table-bordered">  
                        <thead>  
                            <tr>                                         
                                <td>#</td>  
                                <td>Earned Points</td>  
                                <td>Amount Paid</td>
                                <td>Date</td>
                            </tr>  
                        </thead>  
                        <?php  
                        while($row = mysqli_fetch_array($result))  
                        {  
                            $points = $row["tran_amount"] / 20;
                            echo '  
                            <tr>  
                                <td>'.$row["tran_id"].'</td>  
                                <td>'.$points.'</td>  
                                <td>'.$row["tran_amount"].'</td> 
                                <td>'.$row["created_at"].'</td>   
                            </tr>  
                            ';  
                        }  
                        ?>  
                    </table>  
                </div> 
            </div>
        </div> 
</div>

                    



        </div>
    </div>

<script>

$(document).ready(function () {

    // Loading of rewards

    setInterval(function () {
        // Autoload load and points
        $(function () {
            var cust_id = '<?php echo $_SESSION['c_id'];?>'
            $.ajax({
                url: "fetch-customer.php",
                method: "POST",
                data: { cust_id: cust_id },
                dataType: "json",
                success: function (data) {

                    $('#load').text(data.cust_load);
                    $('#points').text(data.cust_points);
                }
            });
        })

    }, 2000);

 // Notification module

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

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</body>
</html>