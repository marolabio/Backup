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
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
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
                    <li class="active">
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
    <br>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="well">
                    <b>Points: </b><span id="points"></span>
                </div>
            </div>

            <div class="col-md-9">
                <div class="panel panel-default" style="height: 90vh; fit-content:true;">
                    <div class="panel-heading">Rewards</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div id="results"></div>
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
            $("#results").load('rewards-load.php')

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

            // Redeem button

            $(document).on('click', '.btnRedeem', function () {
                // Get ids
                var reward_id = $(this).data("id");
                var cust_id = '<?php echo $_SESSION['c_id'];?>'

                redeemPoints(cust_id, reward_id);

            });

            function redeemPoints(cust_id, reward_id) {

                $.ajax({
                    url: "redeemPoints.php",
                    method: "POST",
                    data: { cust_id: cust_id, reward_id: reward_id },
                    dataType: "json",
                    success: function (data) {
                        // Data is in array data[0] is the reward table and data[1] is the customers table

                        // Assign hidden inputs
                        $('.redeemReward #reward_id').val(data[0].reward_id);
                        $('.redeemReward #cust_id').val(data[1].cust_id);
                        $('.redeemReward #cust_email').val(data[1].cust_email);


                        // Assign modal values
                        $('#rewardName').text(data[0].reward_name);
                        $('.redeemReward #balance').text(data[1].cust_points).css('color', 'green');
                        $('.redeemReward #pointsRequired').text(data[0].reward_points).css('color', 'red');

                        var updatedBalance = data[1].cust_points - data[0].reward_points;
                        $('.redeemReward #updatedBalance').text(updatedBalance).css('color', 'green');

                        // Check if negative
                        if (updatedBalance >= 0) {
                            $('#redeem').modal();
                        } else {
                            alert('Insuficient points');
                        }

                    }
                });
            }

        });
    </script>


    <!-- Modals -->

    <div class="modal fade" id="redeem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="reward-redeem.php" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel"><b>Reward Name: </b><span id="rewardName"></h4>
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

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>