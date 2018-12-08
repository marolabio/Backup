<?php   
	include_once 'includes/dbh.inc.php';	
	include_once 'includes/header-login.inc.php';
  session_start();
  
  if(!isset($_SESSION['reservations'])) {
    header("Location: ../modify.php");
    exit();
  }
?>

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



<div class="modal-footer">
    <a href = "loginsuccess.php"><button type="button" class="btn btn-default">Back</button></a>
    <button type="submit" name = "submit" class="btn btn-primary update">Update Reservation</button></a>
</div>
</section>   


      <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "modifyConfirm.php" method = "POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Reservation</h4>
      </div>
      <div class="modal-body">
        
        <h1 style="text-align: center;">Are you sure?</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Yes</button>
      </div>
    </form>
    </div>
  </div>
</div> 

  <script type="text/javascript">
  $(document).ready(function(){
       $(document).on("click", ".update", function () {
         $('#update').modal("show");  

    });
  });
</script>

    <!-- Modals -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
      </body>  
 </html>
   


