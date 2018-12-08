<?php
	include_once 'includes/dbh.inc.php';
  include 'headerbooking.php';



$room_ids = array();

if(filter_input(INPUT_POST, 'add')){
  if(isset($_SESSION['reservations'])){

    $count = count($_SESSION['reservations']);
    $room_ids = array_column($_SESSION['reservations'], 'id');
    $rooms = array_column($_SESSION['rooms'], 'id');


        if (!in_array(filter_input(INPUT_GET, 'id'), $room_ids)){


          $_SESSION['reservations'][$count] = array
            (
              'id' => filter_input(INPUT_GET, 'id'),
              'type' => filter_input(INPUT_POST, 'room_type'),
              'rate' => filter_input(INPUT_POST, 'room_rate'),
              'checkin' => filter_input(INPUT_POST, 'checkin'),
              'checkout' => filter_input(INPUT_POST, 'checkout'),
              'quantity' => filter_input(INPUT_POST, 'quantity'),
              'nights' => filter_input(INPUT_POST, 'nights')
            );


            foreach ($_SESSION['rooms'] as $key => $room) {
                if ($room['id'] == filter_input(INPUT_GET, 'id')){
                    //add item quantity to the existing product in the array
                    $_SESSION['rooms'][$key]['room_occupied'] += filter_input(INPUT_POST, 'quantity'); 
                }
            }



        }else{

          for ($i = 0; $i < count($rooms); $i++){
                if ($rooms[$i] == filter_input(INPUT_GET, 'id')){
                    //add item quantity to the existing product in the array
                    $_SESSION['rooms'][$i]['room_occupied'] += filter_input(INPUT_POST, 'quantity'); 
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
      'quantity' => filter_input(INPUT_POST, 'quantity'),
      'nights' => filter_input(INPUT_POST, 'nights')
      
    );

      foreach ($_SESSION['rooms'] as $key => $room) {
         if ($room['id'] == filter_input(INPUT_GET, 'id')){
              //add item quantity to the existing product in the array
             $_SESSION['rooms'][$key]['room_occupied'] += filter_input(INPUT_POST, 'quantity'); 
         }
      }

  }
}

if(empty($_SESSION['reservations'])){
      unset($_SESSION['rooms']);
      header("Location: /admin/reservationAdd.php");
    }

if(filter_input(INPUT_GET, 'action') == 'delete'){
    //loop through all products in the shopping cart until it matches with GET id variable
    foreach($_SESSION['reservations'] as $key => $room){
        if ($room['id'] == filter_input(INPUT_GET, 'id')){
            //remove product from the shopping cart when it matches with the GET id
            unset($_SESSION['reservations'][$key]); 

        }
    }


      foreach ($_SESSION['rooms'] as $key => $room) {
         if ($room['id'] == filter_input(INPUT_GET, 'id')){
            $_SESSION['rooms'][$key]['room_occupied'] = 0;
         }
      }


    //reset session array keys so they match with $product_ids numeric array
    $_SESSION['reservations'] = array_values($_SESSION['reservations']);

    if(empty($_SESSION['reservations'])){
      unset($_SESSION['rooms']);
      header("Location: reservationAdd.php");
    }
}


//pre_r($_SESSION);

function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

?>		


  <body>

  <br>
  
	<section class = "container">

  <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title"> 
                  <a style = "text-decoration: none; cursor: pointer;" href = "reservationAdd.php"><i class="fa fa-plus-square"> Add</i></a>
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
           <td>Php <?php echo number_format($room['quantity'] * $room['rate'], 2); ?></td>  
           <td>
              <?php 
              $nights = $room['nights'];
              echo $nights;
              ?>                                
          </td>
           <td>Php <?php echo number_format($room['quantity'] * $room['rate'] * $nights, 2); ?></td>  
           <td>
               <a href="reservationTransaction.php?action=delete&id=<?php echo $room['id']; ?>">
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
             <td align="right">Php <?php echo number_format($total, 2); ?></td>  
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
      <form id = "detailsForm" action="reservationProcess.php" method="POST" >
    <h4>Guest Details</h4>
    <div class="form-group">
        <div class="form-group">
          <input type="text" class="form-control" name = "first" placeholder="First Name" minlength="2">
        </div>
        <div class="form-group">

          <input type="text" class="form-control" name = "last" placeholder="Last Name" minlength="2">
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
    </div>
    
      <div class="modal-footer">
        <!-- <a href = "booknow.php"><button type="button" class="btn btn-default">Back</button></a> -->
        <button type="submit" name = "submit" class="btn btn-primary">Proceed</button>
      </div>
    </form>


    <script type="text/javascript">
 $(document).ready(function(){
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
          }, 'Please input a valid contact number\.')

          $.validator.addMethod("alpha", function(value, element) {
              return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
          }, 'Please input a valid name\.');
          
         $('#detailsForm').validate({
          rules:{
            first: {
              required: true,
              alpha: true
            },
            last: {
              required: true,
              alpha: true
            },
            email:{      
              email: true
            },
            email2: {
            
            equalTo: '#email'
            },
            contact: {
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


/*        function confirmEmail() {
            var email = document.getElementById("email").value
            var confirm_email = document.getElementById("confirm_email").value
            if(email != confirm_email) {
                alert('Email Not Matching!');
            }
        }*/

      });
  </script>
	</section>

  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.3.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js"></script>
  
</body>
</html>

