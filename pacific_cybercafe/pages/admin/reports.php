<?php
    session_start();
    
    // Auth
    if(isset($_SESSION['u_id'])){
        // Get Datas
        include_once 'includes/dbh.inc.php';
        $query = "SELECT * FROM reports 
                INNER JOIN customers on customers.cust_id = reports.cust_id
                INNER JOIN transaction  on transaction.tran_id = reports.tran_id
                INNER JOIN users  on users.user_id = reports.user_id
                WHERE tran_status = 'confirmed'
                ORDER BY rep_id DESC";  
 
        $result = mysqli_query($conn, $query);  

    }else{
        header("Location: index.php");
        exit();
    } 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manager | Reports</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Data tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

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
                    <li>
                        <a href="rewards.php">Rewards</a>
                    </li>
                    <li>
                        <a href="register.php">Users</a>
                    </li>
                    <li class="active">
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
    <br>

    <div class="container">          
        <div class="panel panel-primary">
            <div class="panel-heading">Reports</div>
            <div class="panel-body">
                <div class="table-responsive">  
                    <table id="reports_data" class="table table-striped table-bordered">  
                        <thead>  
                            <tr>                                         
                                <td>#</td>  
                                <td>Customer</td>  
                                <td>Amount Paid</td>
                                <td>Date</td>
                                <td>User Incharge</td>
                            </tr>  
                        </thead>  
                        <?php  
                        while($row = mysqli_fetch_array($result))  
                        {  
                            echo '  
                            <tr>  
                                    
                                    <td>'.$row["rep_id"].'</td>  
                                    <td>'.$row["cust_first"].' '.$row["cust_last"].'</td>  
                                    <td>'.$row["tran_amount"].'</td> 
                                    <td>'.$row["created_at"].'</td>   
                                    <td>'.$row["user_first"].' '.$row["user_last"].'</td>
                            </tr>  
                            ';  
                        }  
                        ?>  
                    </table>  
                </div> 
            </div>
        </div> 
    </div>
 

<script>  
    $(document).ready(function(){  
        $('#reports_data').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'print'
            ]
        });        
    });  
</script> 

<?php include 'includes/footer.inc.php'; ?>