<table class="table table-striped table-hover">
                
<?php
  session_start();
  include_once "includes/dbh.inc.php";
  if(!isset($_POST['submit'])){
     $sql = "SELECT * FROM reports";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $records = $queryResults;

        If($queryResults > 0){  
          echo "
          <tr>

          <th>Transaction ID</th>
          <th>Customer Name</th>
          <th>Check In</th>
          <th>Check Out</th>
          <th>Total Amount</th>
          <th>Cash Rendered</th>
          <th>Status</th>
          </tr>"; 
        
        while($row = mysqli_fetch_assoc($result)){
        
          echo "<tr id = '$row[rep_id]'>
          <td>".$row['transaction_id']."</td>
          <td>".$row['cust_name']."</td>
          <td>".$row['checkin']."</td>
          <td>".$row['checkout']."</td>
          <td>Php ".number_format($row['total_amount'], 2)."</td>
          <td>Php ".number_format($row['amount_paid'], 2)."</td>
          <td>".$row['status']."</td>
          
          </tr>";


         }
       }
  }
?>
</table>
<?php 

  $sql = "SELECT SUM(amount_paid) as total_sum FROM reports";
  $result = mysqli_query($conn, $sql);
  $queryResults = mysqli_num_rows($result);
    If($queryResults > 0){
            while($row = mysqli_fetch_assoc($result)){
              $total_sum = $row['total_sum']; 
              echo "
              <div class='form-group col-xs-3'>
                <h3><span class='label label-success'>Total: 
                ₱ ".number_format($total_sum, 2)."
               </span></h3>
              </div>
            ";
          }
        }

?>

  <div class="form-group pull-right">
    <h3><span class="label label-default">Records: <?php echo $records;?></span></h3>
  </div>

