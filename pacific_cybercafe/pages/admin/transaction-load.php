<?php 

	include_once 'includes/dbh.inc.php';

    $query = "SELECT * FROM transaction
              INNER JOIN customers on customers.cust_id = transaction.cust_id
              where tran_status = 'pending'";

    $sql = $conn->query($query);

    if ($sql->num_rows > 0) {

      echo "
          <table class = 'table table-striped table-bordered table-hover table-condensed'>
            <tr>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Transaction Date</th>
              <th>Amount</th>
              <th>Action</th>
            </tr>  
      ";
      while ($row = mysqli_fetch_assoc($sql)) {
        echo "

          <tr>
            <td>$row[cust_id]</td>
            <td>$row[cust_first] $row[cust_last]</td>
            <td>$row[created_at]</td>
            <td>$row[tran_amount]</td>
            <td>
              <button class = 'btn btn-success' id = 'confirm' value = '$row[tran_id]'>Confirm</button>
              <button class = 'btn btn-danger' id = 'delete' value = '$row[tran_id]''>Delete</button>
            </td>
          </tr>
        ";  
      }
      echo "</table>";

    }else{
      echo "<div class = 'alert alert-success'>All done!</div>";
    }



?>

<script>

 $('#confirm').click(function() {
      var val = $(this).attr("value");

      $.ajax({
        type: 'POST',          
        url: 'transaction-confirm.php', 
        data: {'tran_id': val},
        success: function(response){
          alert("Success");
          window.location.href = 'transaction.php';
        },
        error: function(xhr, status, errorThrown){
          //handle ajax error
        }
      });      
    });


    $('#delete').click(function() {
      var val = $(this).attr("value");

      $.ajax({
        type: 'POST',          
        url: 'transaction-delete.php', 
        data: {'tran_id': val},
        success: function(response){
          alert("Success");
          window.location.href = 'transaction.php';
        },
        error: function(xhr, status, errorThrown){
          //handle ajax error
        }
      });      
    });
</script>