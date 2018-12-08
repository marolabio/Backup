<table class='table table-striped table-hover'>
          <?php 

          include_once 'includes/dbh.inc.php';

          $cust_id = $_POST['cust_id'];
          $sql = "SELECT * FROM reservation 
          inner join customers on reservation.cust_id = customers.cust_id
          inner join rooms on reservation.room_id = rooms.room_id
          where reservation.cust_id = '$cust_id' and res_status = 'checkin'";

          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
        
        If($queryResults > 0){  
          echo "
          <tr>
          <th>Customer Name</th>
          <th>Room Type</th>
          <th>Quantity</th>
          <th>Check in</th>
          <th>Check out</th>
          <th>Action</th>
          </tr>"; 
        
        while($row = mysqli_fetch_assoc($result)){
          $checkin =  strtotime($row['checkin']);
          $checkout =  strtotime($row['checkout']);
          echo "<tr id = '$row[res_id]''>
          <td>".$row['cust_first'].' '.$row['cust_last']."</td>
          <td>".$row['room_type']."</td>
          <td>".$row['quantity']."</td>
          <td>".date("F j, Y",$checkin)."</td>
          <td>".date("F j, Y",$checkout)."</td>
          <td>

           <input type = 'button'  value = 'Check-in' data-id = '$row[res_id]' class = 'btn btn-success checkin'/>
          </td></tr>";
        }
      }
      
        ?>
      </table>

     