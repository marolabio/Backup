<?php 
    session_start();  
    include_once 'includes/dbh.inc.php'; 
     
 if(isset($_POST["cust_id"])){   
    $cust_id = $_POST['cust_id'];

    $output = '';
      $sql = "SELECT * FROM customers
          
          inner join billing on billing.cust_id = customers.cust_id
          WHERE customers.cust_id = '$cust_id'";
          $result = mysqli_query($conn, $sql);
         
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result)){ 
      $balance  = $row["balance"];
      $total_amount  = $row["total_amount"];

           $output .= '

                <tr>  
                     <td width="30%"><label>Customer Name</label></td>  
                     <td width="70%">'.$row["cust_first"].' '.$row["cust_last"].'</td>  
                </tr>                 

                <tr>  
                     <td width="30%"><label>Balance</label></td>  
                     <td width="70%">Php '.$row["balance"].'</td>  
                </tr>
    
                ';  
      }  
      $output .= "</table></div>
      <div>
        <input type = 'text' name = 'payment' class = 'form-control' placeholder = 'Please input payment here' required>
        <input type = 'hidden' name = 'balance' value = '".$balance."'>
        <input type = 'hidden' name = 'total_amount' value = '".$total_amount."'>
      </div>
      ";  
      echo $output;  
 }  

?>