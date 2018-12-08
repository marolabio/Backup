<?php 

	include_once 'includes/dbh.inc.php';

    $sql = $conn->query("SELECT * FROM rewards");

    if ($sql->num_rows > 0) {
      echo "
      <table id='reward_data' class ='table table-hover'>
      <thead>
        <tr>
          <th>Picture</th>
          <th>Reward Name</th>
          <th>Required Points</th>
          <th>Action</th>
        </tr>
      </thead>
      ";
      while ($row = mysqli_fetch_assoc($sql)) {
        echo "
        <tr>
          <td><img style = 'border-radius: 8px;' width = '100px' height = '60px' src='data:image;base64,{$row["reward_img"]}' alt='{$row["reward_img"]}'></td>
          <td>{$row['reward_name']}</td>
          <td>{$row['reward_points']}</td>
          <td><button class = 'btn btn-primary btnRedeem' data-id='{$row['reward_id']}'>Redeem Now!</button><td>
        </tr>
        ";  
      }


    }else{
      echo "<div class = 'alert alert-info'>There is no available rewards</div>";
    }


?>
