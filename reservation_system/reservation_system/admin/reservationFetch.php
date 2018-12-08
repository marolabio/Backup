
<table class="table table-striped table-hover">
 <?php
 
        include_once "includes/dbh.inc.php";
        
          $search = $_POST['search'];
          $sql = "SELECT * FROM customers
          inner join billing on billing.cust_id = customers.cust_id
          where customers.cust_first LIKE '%".$search."%' AND cust_status = 'waiting'";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['reservation'] = $queryResults;
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
          echo "<tr id = '$row[cust_id]'>
            <td>".$row['transaction_id']."</td>
            <td>".$row['cust_first']." ".$row['cust_last']."</td>
            <td>".$row['cust_contact']."</td>
            <td>Php ".number_format($row['balance'], 2)."</td>
            <td><input type = 'button' data-id = '$row[cust_id]' value = 'Verify' class = 'btn btn-success verify'/>
            <input type = 'button' data-id = '$row[cust_id]' value = 'Cancel' class = 'btn btn-danger cancel'/>
            <input type = 'button'  value = 'Discount' data-id = '$row[cust_id]' class = 'btn btn-info discount'/>
            </td>
          </tr>";
         }
        }else{
          echo "No records found";
        }
      
        ?>

</table>

