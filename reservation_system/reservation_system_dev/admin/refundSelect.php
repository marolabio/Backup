<?php 
    session_start();  
    include_once 'includes/dbh.inc.php'; 

 if(isset($_POST["cust_id"])){   
    $cust_id = $_POST['cust_id'];

    $output = '';
      $sql = "SELECT * FROM reservation
          inner join customers on customers.cust_id = reservation.cust_id
          inner join billing on billing.cust_id = reservation.cust_id
          WHERE reservation.cust_id = '$cust_id'";
          $result = mysqli_query($conn, $sql);
         
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result)){
            $amount_paid = $row["amount_paid"];
           $output .= '


                <tr>  
                     <td width="30%"><label>Transaction ID</label></td>  
                     <td width="70%">'.$row['transaction_id'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Customer Name</label></td>  
                     <td width="70%">'.$row["cust_first"].' '.$row["cust_last"].'</td>  
                </tr>  
                
                <tr>  
                     <td width="30%"><label>Check-in</label></td>  
                     <td width="70%">'.date("F j, Y", strtotime($row['checkin'])).'</td>  
                </tr> 

                <tr>  
                     <td width="30%"><label>Check-out</label></td>  
                     <td width="70%">'.date("F j, Y", strtotime($row['checkout'])).'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Night/s</label></td>  
                     <td width="70%">'.$row["nights"].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Amount Paid</label></td>  
                     <td width="70%">Php '.number_format($row["amount_paid"], 2).'</td>  
                </tr>
    
                ';  
      }  
      $output .= "</table></div>
      <input type='hidden' name='cust_id' value = '".$cust_id."'> 
      <input type='hidden' name= 'amount_paid' value = '".$amount_paid."'> 
      <input type='text' class = 'form-control' name= 'refund' placeholder= 'Please input refund amount'> 
      ";  
      echo $output;  
 }  
 ?>
