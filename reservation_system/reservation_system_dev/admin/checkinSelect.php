<?php 
    session_start();  
    include_once 'includes/dbh.inc.php'; 
     
 if(isset($_POST["res_id"])){   
    $res_id = $_POST['res_id'];

    $output = '';
      $sql = "SELECT * FROM reservation
          inner join customers on customers.cust_id = reservation.cust_id
          inner join rooms on rooms.room_id = reservation.room_id
          WHERE reservation.res_id = '$res_id'";
          $result = mysqli_query($conn, $sql);
         
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result)){       
           $output .= '

                <tr>  
                     <td width="30%"><label>Customer Name</label></td>  
                     <td width="70%">'.$row["cust_first"].' '.$row["cust_last"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Room</label></td>  
                     <td width="70%">'.$row["room_type"].'</td>  
                </tr>   
                <tr>  
                    <td width="30%"><label>Quantity</label></td>  
                    <td width="70%">'.$row["quantity"].'</td>  
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
    
                ';  
      }  
      $output .= "</table></div>";  
      echo $output;  
 }  
 ?>
