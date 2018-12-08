
<table class="table table-striped table-hover">
 <?php
 
        include_once "includes/dbh.inc.php";
        
          $search = $_POST['search'];
          $sql = "SELECT * FROM customers
          inner join billing on billing.cust_id = customers.cust_id
          where customers.cust_first LIKE '%".$search."%' AND cust_status = 'confirmed'";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['confirmed'] = $queryResults;

        If($queryResults > 0){  
          echo "
          <tr>
           <th>Transaction ID</th>
          <th>Customer Name</th>
          <th>Contact Number</th>
          <th>Balance</th>
          <th>Action</th>
          </tr>"; 
        
        while($row = mysqli_fetch_assoc($result)){
          echo "<tr id = '$row[cust_id]''>
          <td>".$row['transaction_id']."</td>
          <td>".$row['cust_first'].' '.$row['cust_last']."</td>
          <td>".$row['cust_contact']."</td>
          <td>Php ".number_format($row['balance'], 2)."</td>
          <td>
            <input type = 'button'  value = 'Pay' data-id = '$row[cust_id]' class = 'btn btn-success checkin'/>
            <input type = 'button'  value = 'Refund' data-id = '$row[cust_id]' class = 'btn btn-warning refund'/>
            <input type = 'button'  value = 'Print' data-id = '$row[cust_id]' class = 'btn btn-info print'/>
          </td>
          </tr>";
          }
        }else{
          echo "No records found";
        }
        
      
        ?>

</table>
