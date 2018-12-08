<?php
// reward_id & cust_id

if($_POST['reward_id']){
    include_once 'includes/dbh.inc.php';
    $sql = $conn->query("SELECT * FROM rewards WHERE reward_id = '$_POST[reward_id]'");

    if($sql->num_rows > 0){
        while ($row = mysqli_fetch_assoc($sql)){
            echo json_encode(["reward_name" => $row['reward_name'], "reward_points" => $row['reward_points']]);
        }
    }


}

if($_POST['cust_id']){
    include_once 'includes/dbh.inc.php';
    $sql = $conn->query("SELECT * FROM customers WHERE cust_id = '$_POST[cust_id]'");

    if($sql->num_rows > 0){
        while ($row = mysqli_fetch_assoc($sql)){
            echo json_encode(["cust_points" => $row['cust_points']]);
        }
    }
}
