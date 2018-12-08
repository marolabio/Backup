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
</style>

<div id="page-wrap">
<div id="header">INVOICE</div>
<h1>Rock Garden Resort</h1>
<address>
Brgy. Arnedo, Bolinao<br>
Pangasinan 2406 Philippines<br>
Globe +63-917-683-6670 & Smart +63-920-413-9272<br>

<a href = "http://www.rockgardenbolinao.com/">http://www.rockgardenbolinao.com/</a>
<br>
</address>

    <?php 
        if(isset($_SESSION['res_id'])){
            echo "<h3 id='customer-title'>Reservation</h3>";
        }else{
            echo "<h3 id='customer-title'>Updated Reservation</h3>";
        }
    ?>

<table id="meta">
                <tr>
                    <td class="meta-head">Customer Name</td>
                    <td><?php echo $_SESSION['c_first']." ".$_SESSION['c_last']; ?></td>
                </tr>
                <tr>
                    <td class="meta-head"><b>Transaction ID</b></td>
                    <td><b><?php echo $_SESSION['transaction_id']; ?></b></td>
                </tr>
                <tr>
                    <td class="meta-head">Email</td>
                    <td><?php echo $_SESSION['c_email']; ?></td>
                </tr>
                <tr>
                    <td class="meta-head">Due Date</td>
                    <td><?php echo
                    date('j F Y', strtotime('+3 days')) ?></td>
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
           <td>Php <?php echo number_format($room['quantity'] * $room['rate']); ?></td>  
           <td>
              <?php 
              $nights = $room['nights'];
              echo $nights;
              ?>                                
          </td>
           <td>Php <?php echo number_format($room['quantity'] * $room['rate'] * $nights); ?></td>  

        </tr>  
        <?php  
                  $total = $total + ($room['quantity'] * $room['rate'] * $nights);
             endforeach;  
        ?>  
        <tr>  
             <td colspan="3" align="right">Total</td>  
             <td align="right">Php <?php echo number_format($total); ?></td>  
               
        </tr> 
        <tr>  
             <td colspan="3" align="right">Prepayment</td>  
             <td align="right">Php <?php echo number_format($total * .5) ; ?></td>  
             
        </tr> 
        
        
        <?php  
          endif;
          $_SESSION['total'] = $total;
        ?>  
        </table>

        <div>
            <br><strong>Inclusions</strong>
                <p style ="text-indent: 50px;">Towels to be provided upon request (free of charge) for minimum room occupancy.</p>
                <p style ="text-indent: 50px;">Free use of cottages.</p>
                <p style ="text-indent: 50px;">50% pool discount.</p>
 
            <br><strong>Terms & Conditions</strong>
                <p style="text-indent: 50px;">Payment is through bank deposits and onsite payment only.</p>
                <p style="text-indent: 50px;">Reservation will be confirmed after 50% of the requested charges is paid.</p>
                <p style ="text-indent: 50px;">Guest is required to present a valid ID and the original deposit slip upon check-in.</p>
                <p style ="text-indent: 50px;">Check-in after 2:00 p.m. and check-out before 12:00 Noon.</p>
                <p style ="text-indent: 50px;">Early Check-in and late check-out are strictly subjected to room availability.</p>           
                <p style ="text-indent: 50px;">Failure to arrive will be treated as No-Show and will incur the first night charge unless advice due to emergencies.</p>
                <p style ="text-indent: 50px;">The resort will not be resposible for any loss of personal belongings.</p>
                <p style ="text-indent: 50px;">Smoking is not allowed inside our rooms.</p>

            <br><strong>Optional Charges</strong>
                <p style ="text-indent: 50px;">Adult Pool - P75/head</p>
                <p style ="text-indent: 50px;">Kiddie Pool - P50/head</p>
                <p style ="text-indent: 50px;">Rent of Gas Range - P250/hour</p>
                <p style ="text-indent: 50px;">Videoke Rent - P100/hour</p>
                <p style ="text-indent: 50px;">Extra Beddings - P170</p>

        </div>

        <div id="terms">
         <h5>Bank Details</h5>
         Deposit can be made thru Metrobank Account Name & number ROCK GARDEN RESORT, HOTEL & RESTAURANT: 368-3-36813799-6 (Alaminos City Branch, Pangasinan) or BDO Account Name & Number SANDA C. SOLIS :005-450251158 ( Alaminos City Branch, Pangasinan). 
         
         <br><br>
         Your reservation will be confirmed by sending us a scanned deposit slip through accessing your account  <a href="http://rockgardenresort.com/modify.php">here</a>. <span style="color:red;">Note:</span> You need to copy your transaction ID.
         <br><br>
         Kindly contact our font desk (0956580631, 09204139272) for further inquiries or final reservation.
        </div>
    
</div>

