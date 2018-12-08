<table class="table table-striped table-hover">
 <?php
        session_start();
        include_once "includes/dbh.inc.php";
        
        if(!isset($_POST['submit'])){
          $query = "SELECT * FROM customers where cust_status = 'waiting'";
          $result = mysqli_query($conn, $query);
          $queryResults = mysqli_num_rows($result);
          $_SESSION['reservation'] = $queryResults;

          //page number
          $results_per_page = 5;
          $number_of_pages = ceil($queryResults/$results_per_page);
          $paginationCtrls = "";

          if($number_of_pages == 0){
            $number_of_pages = 1;
          }else{          
            $pageNum = "<li>Page <b>$_SESSION[page]</b> of <b>$number_of_pages</b></li>";
          }
        
          if($_SESSION['page'] < 1){
            $_SESSION['page'] = 1;
          }else if($_SESSION['page'] > $number_of_pages){
            $_SESSION['page'] = $number_of_pages;
          }

          if($number_of_pages != 1){
              

              if($_SESSION['page'] > 1){
                $previous = $_SESSION['page'] - 1;
                $paginationCtrls .= '<li class="page-item"><a href = "reservation.php?page='.$previous.'">Previous</a></li>';

                for ($i = $_SESSION['page'] - 4; $i < $_SESSION['page'];$i++) {
                  if($i > 0){

                    $paginationCtrls .= '<li class="page-item"><a href="reservation.php?page=' . $i . '">' . $i . '</a></li>';
                  }
                }
              }

              
              for($i = $_SESSION['page']+1; $i <= $number_of_pages; $i++){
                $paginationCtrls .= '<li class="page-item"><a href="reservation.php?page=' . $i . '">' . $i . '</a></li>';

                if($i >= $_SESSION['page'] + 4){
                  break;
                }
              }


               if($_SESSION['page'] != $number_of_pages){
                $next = $_SESSION['page'] + 1;
                $paginationCtrls .= '<li class="page-item"><a href = "reservation.php?page='.$next.'">Next</a></li>';
              }

          }

    




          $this_page_first_result = ($_SESSION['page']-1)*$results_per_page;

          $sql = "SELECT * FROM customers
          inner join billing on billing.cust_id = customers.cust_id
          where cust_status = 'waiting' LIMIT $this_page_first_result,$results_per_page";

          $res = mysqli_query($conn, $sql);

        If($queryResults > 0){  
          echo "
          <tr>
          <th>Transaction ID</th>
          <th>Customer Name</th>
          <th>Contact Number</th>
          <th>Balance</th>
          <th>Action</th>
          </tr>"; 
        
        while($row = mysqli_fetch_assoc($res)){       
          echo "<tr id = '$row[cust_id]'>
          <td>".$row['transaction_id']."</td>
          <td>".$row['cust_first']." ".$row['cust_last']."</td>
          <td>".$row['cust_contact']."</td>
          <td>Php ".number_format($row['balance'], 2)."</td>
         
          <td><input type = 'button' data-id = '$row[cust_id]' value = 'Verify' class = 'btn btn-success verify'/>
          <input type = 'button' data-id = '$row[cust_id]' value = 'Cancel' class = 'btn btn-danger cancel'/>
          <input type = 'button'  value = 'Discount' data-id = '$row[cust_id]' class = 'btn btn-warning discount'/>
          </td>
          </tr>";
         }
        }
      }
        ?>

</table>

<nav aria-label="Page navigation example">
  <ul class="pagination pull-right">
      <?php echo $paginationCtrls;?>
  </ul>
  <ul class="pagination pull-left">
    <?php 
      if(isset($pageNum)){
        echo $pageNum;
      }
    ?>
  </ul>
</nav>

