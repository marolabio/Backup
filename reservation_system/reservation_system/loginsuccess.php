<?php 
  include_once 'includes/dbh.inc.php';
  include_once 'includes/header-login.inc.php';
  session_start();


if(!isset($_SESSION['cust_id'])){
    // Not logged in
    header('Location: modify.php');
    exit();
}else{
  
    $res = mysqli_query($conn,"SELECT cust_slip FROM customers where cust_id = '$_SESSION[cust_id]'");
    $row = mysqli_fetch_assoc($res);
        
    $img = $row['cust_slip'];
    $file  = base64_encode($img);
    
    if($file != Null){
        
      header('Location: modify.php?depositSlip=sent');
      exit();
    }
    
}



if(!isset($_SESSION['reservations'])){

    $cust_id = $_SESSION['cust_id'];
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
            $_SESSION['res_date'] = $row['res_date'];
            
            
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


$room_ids = array();

if(filter_input(INPUT_POST, 'add')){
  if(isset($_SESSION['reservations'])){

    $count = count($_SESSION['reservations']);

    $room_ids = array_column($_SESSION['reservations'], 'id');

    

        if (!in_array(filter_input(INPUT_GET, 'id'), $room_ids)){
          $_SESSION['reservations'][$count] = array
          (
            'id' => filter_input(INPUT_GET, 'id'),
            'type' => filter_input(INPUT_POST, 'room_type'),
            'rate' => filter_input(INPUT_POST, 'room_rate'),
            'checkin' => filter_input(INPUT_POST, 'checkin'),
            'checkout' => filter_input(INPUT_POST, 'checkout'),
            'nights' => filter_input(INPUT_POST, 'nights'),
            'quantity' => filter_input(INPUT_POST, 'quantity')
          );

            foreach ($_SESSION['rooms'] as $key => $room) {
                if ($room['id'] == filter_input(INPUT_GET, 'id')){
                    //add item quantity to the existing product in the array
                    $_SESSION['rooms'][$key]['room_occupied'] += filter_input(INPUT_POST, 'quantity'); 
                }
            }

        }else{

           for ($i = 0; $i < count($room_ids); $i++){
                if ($room_ids[$i] == filter_input(INPUT_GET, 'id')){
                    //add item quantity to the existing product in the array
                    $_SESSION['reservations'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                }
            }
        }

  }else{ 

    $_SESSION['reservations'][0] = array
    (
      'id' => filter_input(INPUT_GET, 'id'),
      'type' => filter_input(INPUT_POST, 'room_type'),
      'rate' => filter_input(INPUT_POST, 'room_rate'),
      'checkin' => filter_input(INPUT_POST, 'checkin'),
      'checkout' => filter_input(INPUT_POST, 'checkout'),
      'nights' => filter_input(INPUT_POST, 'nights'),
      'quantity' => filter_input(INPUT_POST, 'quantity')
    );

      foreach ($_SESSION['rooms'] as $key => $room) {
         if ($room['id'] == filter_input(INPUT_GET, 'id')){
              //add item quantity to the existing product in the array
             $_SESSION['rooms'][$key]['room_occupied'] += filter_input(INPUT_POST, 'quantity'); 
         }
      }

  }
}

if(filter_input(INPUT_GET, 'action') == 'delete'){
    //loop through all products in the shopping cart until it matches with GET id variable
    foreach($_SESSION['reservations'] as $key => $room){
        if ($room['id'] == filter_input(INPUT_GET, 'id')){
            //remove product from the shopping cart when it matches with the GET id
            unset($_SESSION['reservations'][$key]);
        }
    }
    //reset session array keys so they match with $product_ids numeric array
    $_SESSION['reservations'] = array_values($_SESSION['reservations']);

    if(empty($_SESSION['reservations'])){
      header("Location: modifyAdd.php");
    }
}


//pre_r($_SESSION);

function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
?>

  <section class = "container">
 
  <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title"> 
                  <?php 
                  if(count($_SESSION['reservations']) < 5){
                    echo '
                  <a style = "text-decoration: none; cursor: pointer;" href = "modifyAdd.php"><i class="fa fa-plus-square"> Add</i></a>';
                  }else{
                     echo 'Reservation';
                  }
                  ?>

                </h3>
        
              </div>
                <div class="table-responsive"> 
                      <table class="table table-bordered">  
                          <tr>  
                               <th width="40%">Item Name</th>  
                               <th width="15%">Price</th>  
                               <th width="10%">Night/s</th>  
                               <th width="15%">Amount</th>  
                               <th width="5%">Action</th>  
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
           <td>
               <a href="loginsuccess.php?action=delete&id=<?php echo $room['id']; ?>">
                    <div>Remove</div>
               </a>
           </td>  
        </tr>  
        <?php  
                  $total = $total + ($room['quantity'] * $room['rate'] * $nights);
             endforeach;  
        ?>  
        <tr>  
             <td colspan="3" align="right">Total</td>  
             <td align="right">Php <?php echo number_format($total); ?></td>  
             <td></td>  
        </tr> 

        
        
        <?php  
          endif;
          $_SESSION['total'] = $total;
        ?>  
        </table>  
         </div>
        </div>
  

  <div class = "well">
      <form action = "modifyGuestDetails.php" method = "POST" id="detailsForm">
    <h4>Guest Details</h4>
    <div class="form-group">
    </div>
        <div class="form-group">

          <input type="text" class="form-control" name = "first" placeholder="First name" minlength="2"  readonly value = "<?php if(isset($_SESSION['c_first'])){ echo $_SESSION['c_first'];}?>">
        </div>
        <div class="form-group">

          <input type="text" class="form-control" name = "last" placeholder="Last name" minlength="2"  readonly value = "<?php if(isset($_SESSION['c_last'])){ echo $_SESSION['c_last'];}?>">
        </div>
        <div class="form-group">
          <input type="email" class="form-control" name = "email" id = "email" placeholder="E-mail"  >
        </div>
      <div class="form-group">
          <input type="email" class="form-control" name="email2" placeholder="Confirm E-mail"">
        </div>
      <div class="form-group">   
          <input type="text" class="form-control" name = "contact" placeholder="Contact Number" >
        </div>
      </div>
      <div class="modal-footer">
        <div class = "pull-left control-group">
        <button type='button' class='btn btn-success send' value = "<?php echo $_SESSION['cust_id'];?>">Send Deposit Slip</button>
        <button type="button" class="btn btn-warning logout">Log Out</button>
        </div>
        <button type="submit" name = "submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </section>

    <script type="text/javascript">
      $(document).ready(function(){

        $(document).on("click", ".send", function () {
            var cust_id = $(this).val();
            $(".modal-body #cust_id").val( cust_id );
            $('#send').modal("show");  

        });

        $(document).on("click", ".logout", function () {
            $('#logout').modal("show");  

        });


        $(function(){

          $.validator.setDefaults({
            errorClass: 'help-block',
            highlight: function(element) {
              $(element)
                .closest('.form-group')
                .addClass('has-error');
            },
            unhighlight: function(element) {
              $(element)
                .closest('.form-group')
                .removeClass('has-error');
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
          });

         $.validator.addMethod('validateContact', function(value, element) {
            return this.optional(element) 
              || value.length == 11
              && /\d/.test(value)
              && /^[09]/i.test(value);
          }, 'Your contact number must be valid\.')

         $('#detailsForm').validate({
          rules:{
            first: {
              required: true,
              nowhitespace: true,
              lettersonly: true
            },
            last: {
              required: true,
              nowhitespace: true,
              lettersonly: true
            },
            email:{
              required: true,
              email: true
            },
            email2: {
            required: true,
            equalTo: '#email'
            },
            contact: {
              required: true,
              digits: true,
              validateContact:true
              
            },    
            messages: {
              email: {
              required: 'Please enter an email address.',
              email: 'Please enter a <em>valid</em> email address.' 
            }
          }
          }
          });
        });



  });

  </script>

<!-- Log Out -->
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "modifyLogout.php" method = "POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Log Out</h4>
      </div>
      <div class="modal-body">
        <h1 style="text-align: center;">Are you sure?</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-primary">Log Out</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Send deposit slip -->
<div class="modal fade" id="send" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action = "modifySend.php" method = "POST" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Deposit Slip</h4>
      </div>
      <div class="modal-body">
          <input type="hidden" name="cust_id" id = "cust_id" >
          <input type="file" name = "file" required><br>
          <input type="text" name = "bank" class="form-control" placeholder="Bank Name" required><br>
          <textarea name="message" class="form-control" rows="4" placeholder="Message"></textarea>
          <div class = "info"><h5><span style = "color:red;">Note:</span> Please check the deposit slip to be uploaded is correct. Once sent, no modification can be made.</h5></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit" class="btn btn-success">Send</button>
      </div>
    </form>
    </div>
  </div>
</div>

    <!-- Modals -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js"></script>
</body>
</html>

