<?php  
 $connect = mysqli_connect("localhost", "root", "root31", "reservation_system");  
 $query = "SELECT * FROM reports ORDER BY rep_id desc";  
 $result = mysqli_query($connect, $query);  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
 
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  
           <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
      </head>  
      <body>  
           <br /><br />  
           <div>  
                <form action = 'printpdf.php' target ="_blank" method = 'POST'>
                <div class="col-md-3">  
                     <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" />  
                </div>  
                <div class="col-md-3">  
                     <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" />  
                </div>  
                <div class="col-md-5">  
                     <input type="button" name="filter" id="filter" value="Filter" class="btn btn-info" />  
                    <input type="submit" name="print" id="print" value="Print" class="btn btn-success" />  
                </div>  
                </form>
            

                
                <div style="clear:both"></div>                 
                <br />  
                <div id="order_table">
                <div id="report">  
                     <table class="table table-bordered">  
                          <tr>                  
                            <th>Transaction ID</th>
                            <th>Customer Name</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Total Amount</th>
                            <th>Cash Rendered</th>
                            <th>Status</th>
                          </tr>  
                     <?php  
                     while($row = mysqli_fetch_array($result))  
                     {  
                      echo "<tr id = '$row[rep_id]'>
                        <td>".$row['transaction_id']."</td>
                        <td>".$row['cust_name']."</td>
                        <td>".$row['checkin']."</td>
                        <td>".$row['checkout']."</td>
                        <td>Php ".number_format($row['total_amount'], 2)."</td>
                        <td>Php ".number_format($row['amount_paid'], 2)."</td>
                        <td>".$row['status']."</td>
                        
                        </tr>";
                     }  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
      $(document).ready(function(){ 

           $.datepicker.setDefaults({  
                dateFormat: 'yy-mm-dd'   
           });  
           $(function(){  
                $("#from_date").datepicker();  
                $("#to_date").datepicker();  
           });  
           $('#filter').click(function(){  
            $("#report").detach();
                var from_date = $('#from_date').val();  
                var to_date = $('#to_date').val();  
                if(from_date != '' && to_date != '')  
                {  
                     $.ajax({  
                          url:"filter.php",  
                          method:"POST",  
                          data:{from_date:from_date, to_date:to_date},  
                          success:function(data)  
                          {  
                               $('#order_table').html(data);  
                          }  
                     });  
                }  
                else  
                {  
                     alert("Please Select Date");  
                }  
           }); 

      });  
 </script>