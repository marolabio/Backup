<?php  
 //filter.php  
 if(isset($_POST["from_date"], $_POST["to_date"]))  
 {  
      include_once 'includes/dbh.inc.php';
      $output = '';  
      $query = "  
           SELECT * FROM reports  
           INNER JOIN customers ON customers.cust_id = reports.cust_id
           INNER JOIN billing ON billing.cust_id = reports.cust_id
           INNER JOIN users ON users.user_id = reports.user_id
           WHERE cust_checkin BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'
           AND rep_status = 'checkedout' ORDER BY rep_id DESC
      ";  

      $result = mysqli_query($conn, $query);  
      $output .= '  
           <table>  
           <thead>   
                <tr>  
                    <td>#</td>  
                    <td>Customer Name</td>  
                    <td>Check-in</td>  
                    <td>Check-out</td>
                    <td>Total Amount</td>
                    <td>Amount Paid</td>
                    <td>Incharge</td>
                </tr>  
            </thead>
      ';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                <tr>  
                    <td>'.$row["rep_id"].'</td>  
                    <td>'.$row["cust_first"].' '.$row["cust_last"].'</td>  
                    <td>'.$row["cust_checkin"].'</td>  
                    <td>'.$row["cust_checkout"].'</td>
                    <td>'.$row["total_amount"].'</td>
                    <td>'.$row["amount_paid"].'</td>
                    <td>'.$row["user_first"].''.$row["user_last"].'</td>  
                </tr>
                ';  
           }  
      }  
      else  
      {  
           $output .= '  
                <tr>  
                     <td colspan="7">No Order Found</td>  
                </tr>  
           ';  
      }  
      $output .= '</table>';  
      echo $output;  
 }  
 ?>