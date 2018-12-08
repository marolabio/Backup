<?php

if(isset($_POST['cust_id']) && isset($_POST['reward_id'])){
    include_once 'includes/dbh.inc.php';
    $data = [];
    $sql = $conn->query("SELECT * FROM rewards WHERE reward_id = '$_POST[reward_id]'");

    if($sql->num_rows > 0){
        while ($row = mysqli_fetch_assoc($sql)){
            array_push($data, array('reward_id' => $row['reward_id'], 'reward_name' => $row['reward_name'], 'reward_points' => $row['reward_points']));
        }
    }

  
    $sql = $conn->query("SELECT * FROM customers WHERE cust_id = '$_POST[cust_id]'");

    if($sql->num_rows > 0){
        while ($row = mysqli_fetch_assoc($sql)){
            array_push($data, array('cust_id' => $row['cust_id'], 'cust_email' => $row['cust_email'], 'cust_points' => $row['cust_points']));
        }
    }

    echo json_encode($data);

}else{
    echo json_encode(["msg" => "Something went wrong"]);
}
