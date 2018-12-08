<?php 
    include_once 'includes/dbh.inc.php'; 
 if(isset($_POST['cust_id'])){
    $cust_id = $_POST['cust_id'];  
    $output = '';
          $sql = "SELECT * FROM (billing 
          inner join customers on billing.cust_id = customers.cust_id)
          where cust_id = '$cust_id'";
          $result = mysqli_query($conn, $sql);
         
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {       
           $output .= '   
                <tr>  
                    <td width="30%"><label>Customer Name</label></td>  
                    <td width="70%">'.$row["cust_first"].' '.$row["cust_last"].'</td>  
                </tr>  
                <tr>
                    <th width="20%">Item Name</th>  
                    <th width="10%">Quantity</th>  
                    <th width="20%">Price</th>  
                    <th width="15%">Amount</th> 
                </tr>  

                ';  
      }  
      $output .= "</table></div>";  
      echo $output;  
 }  
 ?>
