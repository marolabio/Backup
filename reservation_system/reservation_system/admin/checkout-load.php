 <table class='table table-border table-hover'>
 <?php
        include_once "includes/dbh.inc.php";
        session_start();

        $sql = "SELECT * FROM customers 
          inner join billing on customers.cust_id = billing.cust_id
          where customers.cust_status = 'checkedin'";
          $result = mysqli_query($conn, $sql);
          
          $queryResults = mysqli_num_rows($result);
          $_SESSION['checkedin'] = $queryResults;
        If($queryResults > 0){  
          echo "
          <tr>
            <th>Transaction ID</th>
            <th>Customer Name</th>
            <th>Contact Number</th>
            <th>Balance</th>
            <th>Action</th>
          </tr>"; 
        }

        $c = 0;  

        while($row = mysqli_fetch_assoc($result)){
        $c++;
          echo "
          <tr>
            <td>".$row['transaction_id']."</td>
            <td>".$row['cust_first'].' '.$row['cust_last']."</td>
            <td>".$row['cust_contact']."</td>
            <td>Php ".$row['balance']."</td>
            <td>
              <input type = 'button'  value = 'Pay' data-id = '$row[cust_id]' class = 'btn btn-success pay'/>
              <input type = 'button'  value = 'Update' data-id = '$row[cust_id]' class = 'btn btn-warning update'/>
              <input type = 'button'  value = 'Print' data-id = '$row[cust_id]' class = 'btn btn-info print'/>
              <button type='button' class='btn btn-secondary transaction view' data-toggle='collapse' data-id = '$row[cust_id]' data-target='#".$c."'>View</button>
            </td>

            <div id='".$c."' class='collapse viewDetails'></div>
            
          </tr>           ";
        }
         
  ?>
</table>
          