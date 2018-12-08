<?php 
	include_once 'includes/dbh.inc.php';

	$less = $_POST['less'];
	$cust_id = $_POST['cust_id'];

	$sql = "SELECT * FROM billing where cust_id = '$cust_id'";
    $result = mysqli_query($conn, $sql);
         
      while($row = mysqli_fetch_array($result)){
      $discount = $row['discount'];

      
      	if($discount == 0.00){

			$sql = "UPDATE billing set discount = '$less' where cust_id = '$cust_id'";
			mysqli_query($conn, $sql);

			$sql = "UPDATE billing set balance = balance - '$less' where cust_id = '$cust_id'";
			mysqli_query($conn, $sql);

			// $sql = "UPDATE billing set total_amount = total_amount - '$less' where cust_id = '$cust_id'";
			// mysqli_query($conn, $sql);

			header("Location: reservation.php?discount=success");
			exit();

      	}else{

			header("Location: reservation.php?discount=once");
			exit();
      	}
      }


?>