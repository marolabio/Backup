<?php  
 //filter.php  
include_once 'includes/dbh.inc.php';
 if(isset($_POST["from_date"], $_POST["to_date"]))  
 {  
      $sql = "SELECT * FROM reports 
     where checkout BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['reports'] = $queryResults;
        If($queryResults > 0){  
          echo "
          <table class='table table-bordered'>  
          <tr>

          <th>Customer Name</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Total Amount</th>
          <th>Amount Paid</th>
          <th>User</th>
          </tr>"; 
        
        while($row = mysqli_fetch_assoc($result)){
        
          echo "<tr id = '$row[rep_id]'>

          <td>".$row['cust_name']."</td>
          <td>".$row['checkin']."</td>
          <td>".$row['checkout']."</td>
          <td>".$row['total_amount']."</td>
          <td>".$row['amount_paid']."</td>
          <td>".$row['user_incharge']."</td>
          
          </tr>";
         }
        }else{
          echo "No Data Found";
        }
 }

  
 ?>