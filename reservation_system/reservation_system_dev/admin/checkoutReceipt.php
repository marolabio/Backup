<?php session_start(); ?>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
th {
    text-align: left;
}
.container{
  width:80%;
  margin:auto;
  overflow:hidden;
}
#meta { margin-top: 1px; margin-bottom: 20px; width: 300px; float: right; }
#meta td { text-align: right;  }
#meta td.meta-head { text-align: left; background: #eee; }
#page-wrap { width: 800px; margin: 0 auto; }
#terms { text-align: center; margin: 20px 0 0 0; }
#terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }

#header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }
#customer-title { font-size: 20px; font-weight: bold; float: left; }

@media print {
    .noprint {display:none !important;}
    a:link:after, a:visited:after {  
      display: none;
      content: "";    
    }
}

</style>
<?php 
 include_once 'includes/dbh.inc.php';
if(isset($_POST['cust_id'])){
 $cust_id = $_POST['cust_id'];
    $sql = "SELECT * FROM reservation
          inner join customers on customers.cust_id = reservation.cust_id
          inner join rooms on rooms.room_id = reservation.room_id
          where reservation.cust_id = '$cust_id'";
          $result = mysqli_query($conn, $sql);

        $_SESSION['reservations'] = array();

        while($row = mysqli_fetch_assoc($result)){
            $_SESSION['c_id'] = $row['cust_id'];
            $_SESSION['c_first'] = $row['cust_first'];
            $_SESSION['c_last'] = $row['cust_last'];
            $_SESSION['c_email'] = $row['cust_email'];
            $_SESSION['c_contact'] = $row['cust_contact'];
            $_SESSION['transaction_id'] = $row['transaction_id'];
        

            
          $count = count($_SESSION['reservations']);

          $_SESSION['reservations'][$count] = array
          (
              'id' => $row['room_id'],
              'type' => $row['room_type'],
              'rate' => $row['room_rate'],
              'quantity' => $row['quantity'],
              'checkin' => $row['checkin'],
              'checkout' => $row['checkout'],
              'nights' => $row['nights']
          );
        

        }


  }

?>
<div id="page-wrap">
<div id="header">TEMPORARY RECEIPT</div>
<h1>Rock Garden Resort</h1>
<address>
Brgy. Arnedo, Bolinao<br>
Pangasinan 2406 Philippines<br>
Globe +63-917-683-6670 & Smart +63-920-413-9272<br>

<a href = "http://www.rockgardenbolinao.com/">http://www.rockgardenbolinao.com/</a>
<br>
</address>
  <h3 id='customer-title'>PAID</h3>
<table id="meta">
                <tr>
                    <td class="meta-head">Customer Name</td>
                    <td><?php echo $_SESSION['c_first']." ".$_SESSION['c_last']; ?></td>
                </tr>
                <tr>
                    <td class="meta-head">Transaction ID </td>
                    <td><?php echo $_SESSION['transaction_id']; ?></td>
                </tr>
                <tr>
                    <td class="meta-head">Email</td>
                    <td><?php echo $_SESSION['c_email']; ?></td>
                </tr>
                <tr>
                    <td class="meta-head">Date</td>
                    <td><?php echo
                    date('j F Y') ?></td>
                </tr>
</table>


                 <table width = "100%">  
                         <tr>  
                               <th width="40%">Item Name</th>  
                               <th width="15%">Price</th>  
                               <th width="10%">Night/s</th>  
                               <th width="15%">Amount</th>  
                          </tr>  
                          
       <?php   
        if(!empty($_SESSION['reservations'])):  
            
             $total = 0;  
        
             foreach($_SESSION['reservations'] as $key => $room): 
        ?>  
        <tr>  
            <td>
              <?php 
               $checkin =  strtotime($room['checkin']);
               $checkout =  strtotime($room['checkout']);
              
              echo $room['quantity']." x ".$room['type']."<br>".date("F j, Y", $checkin)." - ".date("F j, Y", $checkout);
              ?>
            </td>  
           <td>Php <?php echo number_format($room['quantity'] * $room['rate'], 2); ?></td>  
           <td>
              <?php 
              $nights = $room['nights'];
              echo $nights;
              ?>                                
          </td>
           <td>Php <?php echo number_format($room['quantity'] * $room['rate'] * $nights, 2); ?></td>  

        </tr>  
        <?php  
                  $total = $total + ($room['quantity'] * $room['rate'] * $nights);
             endforeach;  
        ?>  
        <tr>  
             <td colspan="3" align="right">Subtotal</td>  
             <td align="right">Php <?php echo number_format($total, 2); ?></td>     
        </tr>
        

        <?php  
        endif;
        ?>  
        


<?php 

      $sql = "SELECT * FROM billing where cust_id = '$cust_id'";
      $result = mysqli_query($conn, $sql);
         
      while($row = mysqli_fetch_array($result)){ 
      $discount = $row['discount'];
      $total_amount = $row['total_amount'];
      $balance = $row['balance'];
      $additional = $row['additional'];

      }
      echo "
      <tr>  
        <td colspan='3' align='right'>Additionals</td>  
        <td align='right'>Php ".number_format($additional, 2)."</td>   
      </tr>  
      <tr>  
        <td colspan='3' align='right'>Senior Citizen/PWD Discount</td>  
        <td align='right'>Php ".number_format($discount, 2)."</td>   
      </tr> 
      <tr>  
        <td colspan='3' align='right'>Total</td>  
        <td align='right'>Php ".number_format($total_amount - $discount, 2)."</td>   
      </tr>
      </table>";

?>



<?php 
    $sql = "SELECT * FROM transaction
    inner join billing on billing.cust_id = transaction.cust_id
    where billing.cust_id = '$cust_id'";
    $result = mysqli_query($conn, $sql);
     
?>

<table width = "100%" style= "margin-top: 20px;">
  <tr>
    <th>Transaction Date</th>
    <th>Amount Paid</th>
    <th>Change</th>
  </tr>
  <?php  
    while($row = mysqli_fetch_assoc($result)): 
    $balance = $row['balance'];
  ?>
    
  <tr>
    <td><?php echo date('F j, Y g:i a  ', strtotime($row['tran_date'])); ?></td>   
    <td>Php <?php echo number_format($row['tran_amount'], 2); ?></td> 
    <td>Php <?php echo number_format($row['tran_change'], 2); ?></td> 
  </tr>
 <?php endwhile; ?>
  <tr>  
      <td colspan="2" align="right">Balance</td>  
      <td align="right">Php <?php echo number_format($balance, 2); ?></td>        
  </tr>  
</table>




        <div id="terms">
          <div align="right">
             <p>Cashier/Authorized Representative: <b><?php echo $_SESSION['u_first']." ".$_SESSION['u_last']?><b></p>
          </div>
        </div>
        <div>
</div>

