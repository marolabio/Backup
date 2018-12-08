
<?php 
    session_start();
    include "includes/dbh.inc.php";

    if (isset($_POST['checkin'])){
      $_SESSION['checkin'] = $_POST['checkin'];
      $_SESSION['checkout'] = $_POST['checkout'];
    }

  

    $result = mysqli_query($conn, "update rooms set room_status = 'available'");
    $sql = "SELECT * FROM reservation";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)){
        if($row['checkin'] <= $_SESSION['checkout'] AND $row['checkout'] >= $_SESSION['checkin'] ){
          $no = 1;
          
        }else{
          $no = 0;
        }
        
        if($no == 0){
          $sql = "SELECT * FROM rooms";
          $result1 = mysqli_query($conn, $sql);

          while($row = mysqli_fetch_array($result1)){

            if($row['room_quantity'] > $row['room_occupied']){
              mysqli_query($conn , "update rooms set room_status = 'available' where room_id = $row[room_id] ");
            }else{
              mysqli_query($conn , "update rooms set room_status = 'unavailable' where room_id = $row[room_id]");
            }

          }

        }else{
          $sql = "SELECT * FROM rooms";
          $result2 = mysqli_query($conn, $sql);

          while($row = mysqli_fetch_array($result2)){
            if($row['room_quantity'] > $row['room_occupied']){
              mysqli_query($conn , "update rooms set room_status = 'available' where room_id = $row[room_id] ");
            }else{
              mysqli_query($conn , "update rooms set room_status = 'unavailable' where room_id = $row[room_id]");
            }

        }
      }
    }
    $diff = abs(strtotime($_SESSION['checkout'])  -  strtotime($_SESSION['checkin']));
    $nights = abs(floor($diff / (60 * 60 * 24)));
  


    if(!isset($_SESSION['rooms'])){
      $sql = "SELECT * FROM rooms where room_status = 'available'";
      $result = mysqli_query($conn, $sql);
      $queryResults = mysqli_num_rows($result);

        $_SESSION['rooms'] = array();

        while($row = mysqli_fetch_assoc($result)){
        
          $count = count($_SESSION['rooms']);

          $_SESSION['rooms'][$count] = array
          (
              'id' => $row['room_id'],
              'type' => $row['room_type'],
              'img' => $row['room_img'],
              'rate' => $row['room_rate'],
              'description' => $row['room_description'],
              'max' => $row['room_max'],
              'room_quantity' => $row['room_quantity'],
              'room_occupied' => $row['room_occupied']
          );
        }

    }
    


    If($_SESSION['rooms'] > 0){ 
      echo "
      <div class = 'table-responsive'>
      <table class='table table-striped table-hover' style = 'text-align:center;'><tr>
        
          <th style = 'text-align:center;'>Room Type</th>
          <th style = 'text-align:center;width: 60px;'>Max Occupancy</th>
          <th style = 'text-align:center;'>Description</th>
          <th style = 'text-align:center;'>Rate<small><p class = 'pull-right'>VAT-Inclusive</p></small></th>
          <th style = 'text-align:center;'>Available</th>
          <th style = 'text-align:center;'>Quantity </th>

        </tr>"; 

    foreach($_SESSION['rooms'] as $key => $room){

        if($room['room_quantity'] > $room['room_occupied']){
          $maxNum = $room['room_quantity'] - $room['room_occupied']; 
          echo "<tr>
                    <td><h4>".$room['type']."</h4>
          <a target='_blank' href='data:image;base64,".$room['img']."' data-lightbox = ''>
          <img style = 'border-radius: 8px;' width = '200px' src = 'data:image;base64,".$room['img']."'>
          </a>
          </td>
          <td>".$room['max']."</td>
          <td>".$room['description']."</td>
          <td width = '100px'>Php ".number_format($room['rate'])."</td>

          <td style = 'text-align:center;'><small>Only $maxNum room(s) available</small><br>
            </td></td><td>
          <form action = 'transaction.php?action=add&id=$room[id]' method = 'POST'>

          <input type = 'number' value = '1' style = 'width: 40px' name ='quantity' min = '1' max = '$maxNum'required><br><br><br>
            <input type = 'hidden' id = 'room_id' value = '$room[id]' name ='room_id'/>
            <input type = 'hidden' id = 'room_type' value = '$room[type]' name ='room_type'/>
            <input type = 'hidden' id = 'room_rate' value = '$room[rate]' name ='room_rate'/>
            <input type = 'hidden' id = 'checkin' value = '$_SESSION[checkin]' name ='checkin'/>
            <input type = 'hidden' id = 'checkout' value = '$_SESSION[checkout]' name ='checkout'/>
            <input type = 'hidden' id = 'nights' value = '$nights' name ='nights'/>
            <button type = 'submit' name = 'add' value = 'Book Now' class = 'btn btn-success booknow' id = 'room'>Book now</button>
          </form>
          </tr>";"</table></div>";  
        }
      }

    }else{
      echo '<h1 style = "text-align: center; color: red;  ">No rooms are available</h1>';
    } 
  
?>







