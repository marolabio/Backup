<?php   
	
	include_once 'includes/dbh.inc.php';	
  include_once 'includes/header.inc.php';
  session_start();
  
  if(!isset($_SESSION['reservations'])){
    header("Location: booknow.php");
    exit();
  }
  
?>


<br> 
<section class = "container">
  
  <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Reservation Details</h3>
        
              </div>
              <div class="table-responsive">  
                     <table class="table table-bordered">  
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
         </div>
        </div>
        

 

  <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Customer Details</h3>
              </div>
    <div class="table-responsive">  
        <table class="table table-bordered">
          <tr>  
            <th>First Name</th>  
            <th>Last Name</th>  
            <th>Contact Number</th>  
            <th>Email</th>  
          </tr>  
          <tr>  
            <td><?php echo $_SESSION['c_first'] ?></td>  
            <td><?php echo $_SESSION['c_last'] ?></td>  
            <td><?php echo $_SESSION['c_contact'] ?></td>  
            <td><?php echo $_SESSION['c_email'] ?></td>  
          </tr>   
        </table>     
      </div> 
    </div>

<strong>Inclusions</strong>
    <p style ="text-indent: 10px;">Towels to be provided upon request (free of charge) for minimum room occupancy.</p>
    <p style ="text-indent: 10px;">Free use of cottages.</p>
    <p style ="text-indent: 10px;">50% pool discount.</p>

    <br>

<strong>Term & Conditions</strong>
<div style="height:100px;width:100%;border:1px solid #ccc;font:14px/26px Georgia, Garamond, Serif;overflow:auto;">
 
    <p style="text-indent: 10px;">Payment is through bank deposits and onsite payment only.
    <p style ="text-indent: 10px;">Reservation will be confirmed after 50% of the requested charges is paid.</p>
    <p style ="text-indent: 10px;">Guest is required to present a valid ID and the original deposit slip upon check-in.</p>
    <p style ="text-indent: 10px;">Check-in after 2:00 p.m. and check-out before 12:00 Noon.</p>
    <p style="text-indent: 10px;">Early check-in and late check-out are strictly subjected to room availability.</p>
    <p style ="text-indent: 10px;">Failure to arrive will be treated as No-Show and will incur the first night charge.</p>
    <p style ="text-indent: 10px;">The resort will not be resposible for any loss of personal belongings.</p>
    <p style ="text-indent: 10px;">Smoking is not allowed inside our rooms.</p>

    
</div>


<form action = "confirm.php" method = "POST">
   <div class="form-group">

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="agree" value="agree" required/> Agree with the terms & conditions
                </label>
            </div>
      
    </div>
         
         
<div class="modal-footer">
    <a href = "transaction.php"><button type="button" class="btn btn-default">Back</button></a>
    <button type="submit" name = "submit"  class="btn btn-primary confirm">Confirm Reservation</button></a>
</div>
</form>
</section>

      </body>  
 </html>
   


