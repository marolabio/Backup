<?php 

	include_once 'includes/dbh.inc.php';


 
  if (isset($_GET['id']) && isset($_GET['l'])) {
    $cust_id = $_GET['id'];
    $user_load = $_GET['l'];
    $date = date('Y-m-d H:i:s');

    $sql = $conn->query("SELECT cust_id FROM customers WHERE
      cust_id= '$cust_id'
    ");
 
    if ($sql->num_rows == 1) {
      $check = $conn->query("SELECT * FROM transaction WHERE cust_id= '$cust_id' AND tran_status = 'pending'");

      if($check->num_rows == 0) {

        $sql = $conn->query("insert into transaction (cust_id, tran_amount, tran_status) values ('$cust_id', '$user_load', 'pending')");

        echo "Please wait for confirmation";

      }else {
        echo "One transaction at a time";
      }
    }
      
  }else{
    echo "Something went wrong";
  }
  