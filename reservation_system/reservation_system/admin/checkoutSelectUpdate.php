<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
   
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result)){       
           $output .= '

                <tr>  
                     <td width="30%"><label>Customer Name</label></td>  
                     <td width="70%">'.$row["cust_first"].' '.$row["cust_last"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Total Amount</label></td>  
                     <td width="70%">Php '.number_format($row["total_amount"], 2).'</td>  
                </tr>                  

                <tr>  
                     <td width="30%"><label>Balance</label></td>  
                     <td width="70%">Php '.$row["balance"].'</td>  
                </tr>
    
                ';  
                echo $output;
      }
    }
       
?>

<script type="text/javascript">
  

$(document).ready(function() {

function calculateSum(){
 var sumTotal=0;
    $('table tbody tr').each(function() {
      var $tr = $(this);

      if ($tr.find('input[type="checkbox"]').is(':checked')) {
          
        var $columns = $tr.find('td').next('td').next('td');
         
         var $Qnty=parseInt($tr.find('input[type="text"]').val());
 var $Cost=parseInt($columns.next('td').html().split('Php')[1]);
         sumTotal+=$Qnty*$Cost;
      }
    });

       $("#price").val(sumTotal);
       $("#total").val(sumTotal);
       
}

  $('#sum').on('click', function() {
     
    calculateSum();
  });

  $("input[type='text']").keyup(function() {
     calculateSum();

  });
  
   $("input[type='checkbox']").change(function() {
     calculateSum();

  });



});
</script>
</table>
<div class = "table-responsive">
<table class = 'table table-bordered'>
  <tr>
    <th></th>
    <th>Item</th>
    <th>Quantity</th>
    <th>Cost</th>
  </tr>
  <tr>
    <td><input type="checkbox" name="chck" value="75" /></td>
    <td>Adult Pool</td>
    <td><input type="text" name="qnty" min = "1" value="1"></td>
    <td>Php 84.00</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="chck" value="30" /></td>
    <td>Kiddie Pool</td>
    <td><input type="text" name="qnty" min = "1" value="1"></td>
    <td>Php 33.60</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="chck" value="75" /></td>
    <td>Entrance Fee(Adult)</td>
    <td><input type="text" name="qnty" min = "1" value="1"></td>
    <td>Php 10.00</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="chck" value="75" /></td>
    <td>Entrance Fee(Child)</td>
    <td><input type="text" name="qnty" min = "1" value="1"></td>
    <td>Php 5.00</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="chck" value="75" /></td>
    <td>Excess</td>
    <td><input type="text" name="qnty" min = "1" value="1"></td>
    <td>Php 100.00</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="chck" value="250" /></td>
    <td>Rent of gas</td>
    <td><input type="text" name="qnty" min = "1" value="1"></td>
    <td>Php 200.00</td>
  </tr>

  <tr>
    <td><input type="checkbox" name="chck" value="100" /></td>
    <td>Towel, Blankets, Bedding, Pillows</td>
    <td><input type="text" name="qnty" min = "1" value="1"></td>
    <td>Php 50.00</td>
  </tr>

  <tr>
    <td><input type="checkbox" name="chck" value="100" /></td>
    <td>Rice Cooker, Electric Stove</td>
    <td><input type="text" name="qnty" min = "1" value="1"></td>
    <td>Php 250.00</td>
  </tr>

  <tr>
    <td><input type="checkbox" name="chck" value="170" /></td>
    <td>Extra bed</td>
    <td><input type="text" name="qnty" min = "1" value="1"></td>
    <td>Php 200.00</td>
  </tr>

  </table>
</div>
  
  <p align="right">Total: <input type="text" name="price" id="price" style = "width: 20%;" readonly /></p>
  <input type="hidden" name="total" id="total" style = "width: 20%;" readonly />
  <input type="hidden" name="cust_id" value = "<?php echo $cust_id; ?>" style = "width: 20%;" readonly />