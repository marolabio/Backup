<?php 

	include_once 'includes/dbh.inc.php';


    $sql = $conn->query("SELECT * FROM rewards");

    if ($sql->num_rows > 0) {

      echo "<div class = 'table-responsive'>
          <table class = 'table table-bordered table-hover table-condensed'>
            <tr>
              <th>Picture</th>
              <th>Name</th>
              <th>Required Points</th>
              <th>Action</th>
            </tr>  
      ";
      while ($row = mysqli_fetch_assoc($sql)) {
        echo "
          <tr id = '$row[reward_id]'>
            <td data-target = 'reward_img'><img style = 'border-radius: 8px;' height = '50px' max-width = '100px' src='data:image;base64,{$row["reward_img"]}' alt='{$row["reward_img"]}'></td>
            <td data-target = 'reward_name'>$row[reward_name]</td>
            <td data-target = 'reward_points'>$row[reward_points]</td>
            <td>
              <button class = 'btn btn-info edit' data-id = '$row[reward_id]'>Edit</button>
              <button class = 'btn btn-danger delete' data-id = '$row[reward_id]'>Delete</button>
            </td>
          </tr>
        ";  
      }
      echo "</table></div>";

    }else{
      echo "<div class = 'alert alert-success'>Please create rewards</div>";
    }

    


?>




