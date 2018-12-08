<table class="table table-striped table-hover">
                
<?php
include_once "includes/dbh.inc.php";
session_start();
	if(!isset($_POST['submit'])){
		 $sql = "SELECT * FROM customers 
     inner join billing on billing.cust_id = customers.cust_id 
     where cust_status = 'refund'";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['refunds'] = $queryResults;
        If($queryResults > 0){  
          echo "
          <tr>

          <th>Transaction ID</th>
          <th>Customer Name</th>
          <th>Contact Number</th>
          <th>Amount Paid</th>
          <th>Action</th>
          </tr>"; 
        
        while($row = mysqli_fetch_assoc($result)){
        
          echo "<tr id = '$row[cust_id]'>
          <td>".$row['transaction_id']."</td>
          <td>".$row['cust_first']." ".$row['cust_last']."</td>
          <td>".$row['cust_contact']."</td>
          <td>Php ".number_format($row['amount_paid'], 2)."</td>
          <td>
          <input type = 'button' data-id = '$row[cust_id]' value = 'Refund' class = 'btn btn-info refund'/>
          <input type = 'button' data-id = '$row[cust_id]' value = 'Cancel' class = 'btn btn-primary cancel'/>
          </td>
          </tr>";
         }
        }
	}
?>
 </table>