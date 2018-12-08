
<table class="table table-striped table-hover">
 <?php
 
        include_once "includes/dbh.inc.php";
        
          $search = $_POST['search'];
          
          $sql = "SELECT * FROM customers
          inner join billing on billing.cust_id = customers.cust_id
          where customers.cust_first LIKE '%".$search."%' AND cust_status = 'checkin'";
          $result = mysqli_query($conn, $sql);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['checkin'] = $queryResults;
        If($queryResults > 0){  
          echo "
          <tr>
          <th>Transaction ID</th>
          <th>Customer Name</th>
          <th>Contact Number</th>
        
          <th>Action</th>
          </tr>"; 
        $c = 0;
        while($row = mysqli_fetch_assoc($result)){
          echo "<tr>
          <td>".$row['transaction_id']."</td>
          <td>".$row['cust_first'].' '.$row['cust_last']."</td>
          <td>".$row['cust_contact']."</td>
        
          <td>

          <input type = 'button'  value = 'Print' data-id = '$row[cust_id]' class = 'btn btn-info print'/>
          <button type='button' class='btn btn-success transaction view' data-toggle='collapse' data-id = '$row[cust_id]' data-target='#".$c."'>View</button></td>

              <div id='".$c."' class='collapse viewDetails'>

              </div>
       
          </tr>";
          }
        } 
      
       
        ?>

                    </table>

<script type="text/javascript">
      $(document).on("click", ".view", function () {
         var cust_id = $(this).data('id');
          
           $.ajax({  
                url:"viewCheckin.php",  
                method:"POST",  
                data:{cust_id:cust_id},  
                success:function(data){  
                     $('.viewDetails').html(data);  
                    
                } 
              });
              
                
    }); 
</script>
                 