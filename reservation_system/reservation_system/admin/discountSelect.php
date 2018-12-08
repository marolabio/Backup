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
      $balance = $row['balance'];
      $total_amount = $row['total_amount'];
       
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
                     <td width="70%">Php '.number_format($row["balance"],2).'</td>  
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
        var $Count=parseInt($tr.find("input:text[name='count']").val());
        var $Cost=parseInt($columns.next('td').next('td').html().split('Php')[1]);
         sumTotal+= $Cost/$Qnty*$Count*.2;
         

      }
    });

       $("#price").val(sumTotal);
       $("#less").val(sumTotal);
       
}

  $('#sum').on('click', function() {
     
    calculateSum();
  });

  $("input[type='text']").keyup(function() {
     calculateSum();

  });
    $("input:text[name='count']").keyup(function() {
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
    <th>Person</th>
    <th>Senior or PWD</th>
    <th>Total Amount</th>
  </tr>
  <tr>
    <td><input type="checkbox" name="chck" value="75" /></td>
    <td>Senior or PWD</td>
    <td><input type="text" name="qnty" min = "1" value="1" style = "width: 35px;"></td>
    <td><input type="text" name="count" min = "1" value="1" style = "width: 50px;"></td>
    <td>Php <?php echo $total_amount?></td>
  </tr>


  </table>
</div>
  
  <p align="right">Less: <input type="text" name="price" id="price" style = "width: 20%;" readonly /></p>
  <input type="hidden" name="less" id="less" style = "width: 20%;" readonly />
  <input type="hidden" name="cust_id" value = "<?php echo $cust_id; ?>" style = "width: 20%;" readonly />