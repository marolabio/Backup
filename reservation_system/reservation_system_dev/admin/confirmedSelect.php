<?php 
    include_once 'includes/dbh.inc.php'; 
    session_start();
 if(isset($_POST["cust_id"]))  
 {  
    $output = '';
    $cust_id = $_POST['cust_id'];
     $sql = "SELECT * FROM billing 
     inner join customers on customers.cust_id = billing.cust_id
     where billing.cust_id = '$cust_id'";
          $result = mysqli_query($conn, $sql);
         
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  

           $total_amount =  $row['total_amount'];
           $balance =  $row['balance'];      
           $output .= '  
                <tr>  
                     <td width="30%"><label>Transaction ID</label></td>  
                     <td width="70%">'.$row["transaction_id"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Customer Name</label></td>  
                     <td width="70%">'.$row["cust_first"].' '.$row["cust_last"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Contact Number</label></td>  
                     <td width="70%">'.$row["cust_contact"].'</td>  
                </tr>

                <tr>  
                     <td width="30%"><label>Balance</label></td>  
                     <td width="70%">Php '.number_format($row["balance"], 2).'</td>  
                </tr>


                ';  

      }
      $output .= "</table></div> 
      <div>
        <input type = 'text' name = 'checkinPayment' class = 'form-control' placeholder = 'Please input payment here' required>
        <input type = 'hidden' name = 'total_amount' value = '$total_amount'>
        <input type = 'hidden' name = 'balance' value = '$balance'>
      </div>";   

      echo $output;  
 }  
 ?>
