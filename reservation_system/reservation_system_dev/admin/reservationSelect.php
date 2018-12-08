<?php 
    include_once 'includes/dbh.inc.php';
    session_start();

 if(isset($_POST['cust_id']))  
 {  
    $output = '';
    $cust_id = $_POST['cust_id'];
    $sql = "SELECT * FROM billing 
    inner join customers on customers.cust_id = billing.cust_id
    inner join reservation on reservation.cust_id = billing.cust_id
    where billing.cust_id = '$cust_id'";
    $result = mysqli_query($conn, $sql);
         
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result)){ 
           $res_type = $row['res_type']; 
           $transaction_id = $row['transaction_id']; 
           $cust_name = "$row[cust_first] $row[cust_last]"; 
           $cust_contact =  $row['cust_contact'];
           $total_amount =  $row['total_amount'];
           $balance =  $row['balance'];
           $cust_slip =  $row['cust_slip'];
           $bank_name =  $row['bank_name'];
           $msg =  $row['message'];
      }
      //Deposit Slip
      if(!$cust_slip == NULL){
        $_SESSION['bank'] = $bank_name;
        $_SESSION['msg'] = $msg;
        $_SESSION['slip'] = $cust_slip;
        
        $slip = '<a href="view.php" class="btn btn-info" target="_blank">View</a>';

      }else{

        $slip = 'No Deposit Slip';

      }
 
           $output .= '
                <tr>  
                     <td width="30%"><label>Reservation Type</label></td>  
                     <td width="70%">'.$res_type.'</td>  
                </tr>    
                <tr>  
                     <td width="30%"><label>Transaction ID</label></td>  
                     <td width="70%">'.$transaction_id.'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Customer Name</label></td>  
                     <td width="70%">'.$cust_name.'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Contact Number</label></td>  
                     <td width="70%">'.$cust_contact.'</td>  
                </tr>                  
                <tr>  
                     <td width="30%"><label>Deposit Slip</label></td>  
                     <td width="70%">'.$slip.'</td>  
                    
                </tr>
                ';  

    $sql = "SELECT * FROM reservation
          inner join customers on customers.cust_id = reservation.cust_id
          inner join rooms on rooms.room_id = reservation.room_id
          where reservation.cust_id = '$cust_id'";
          $result = mysqli_query($conn, $sql);
         

      $output .= '  
      </table>
      </div>
           <table class="table table-bordered">
                    <tr>  
                        <th width="40%">Item Name</th>  
                        <th width="15%">Price</th>  
                        <th width="10%">Night/s</th>  
                        <th width="15%">Amount</th>  
                    </tr> '; 
      $total = 0;
      while($row = mysqli_fetch_array($result)){ 
        $checkin = date("F j, Y", strtotime($row['checkin']));
        $total = $total + ($row['quantity'] * $row['room_rate'] * $row['nights']);
           $output .= '
        <tr>  
            <td>
              
              '.$row['quantity']." x ".$row['room_type']."<br>".date("F j, Y", strtotime($row['checkin']))." - ".date("F j, Y", strtotime($row['checkout'])).'
              
            </td>  
           <td>Php '.number_format($row['quantity'] * $row['room_rate'], 2).'</td>  
           <td>
              '.$row['nights'].'                
          </td>
           <td>Php '.number_format($row['quantity'] * $row['room_rate'] * $row['nights'], 2).'</td>  

        </tr>';
      }  

      $output .= "
        <tr>  
             <td colspan='3' align='right'>Subtotal</td>  
             <td align='right'>Php ".number_format($total, 2)."</td>   
        </tr>";

      $sql = "SELECT * FROM billing where cust_id = '$cust_id'";
      $result = mysqli_query($conn, $sql);
         
      while($row = mysqli_fetch_array($result)){ 
      $discount = $row['discount'];
      $total_amount = $row['total_amount'];
      $balance = $row['balance'];

      }
      $output .= "
        <tr>  
             <td colspan='3' align='right'>Discount</td>  
             <td align='right'>Php ".number_format($discount, 2)."</td>   
        </tr> 
        <tr>  
             <td colspan='3' align='right'>Total</td>  
             <td align='right'>Php ".number_format($total_amount - $discount, 2)."</td>   
        </tr> 
        ";
        
        date_default_timezone_set('Asia/Manila');
        $today = date('F j, Y' );
        if($today != $checkin){
            $output .= "
            <tr>  
                <td colspan='3' align='right'>Prepayment</td>  
                <td align='right'>Php ".number_format($balance / 2, 2)."</td>   
            </tr>";
        }

        
        $output .= "
      </table></div>
      <div>
        <input type = 'text' name = 'prepayment' class = 'form-control' placeholder = 'Please input payment here' required>
        <input type = 'hidden' name = 'balance' value = '$balance'>
      </div>

      ";  

      echo $output;  
 }

?>


