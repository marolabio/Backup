<?php

if(isset($_POST['cust_id'])){
    include_once 'includes/dbh.inc.php';

    $sql = "SELECT * FROM customers where cust_id = '$_POST[cust_id]'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        echo json_encode(['cust_load' => $row['cust_load'],'cust_points' => $row['cust_points']]);
    }
}