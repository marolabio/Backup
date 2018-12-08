<?php
	include_once 'includes/dbh.inc.php';

	$result = mysqli_query($conn, "select * from reservation where res_status = 'pending'");

	while($row = mysqli_fetch_array($result)){
		$res_date = $row['res_date'];
		$cust_id = $row['cust_id'];
		$room_id = $row['room_id'];
		$quantity = $row['quantity'];

		if(date("Y-m-d H:i:s") >= date('Y-m-d H:i:s', strtotime($res_date. '+1 day'))){

			
			// Update room Availability
			for ($x = 1; $x <= $quantity; $x++){
				// Minus 1 to each room that will be unoccupied
				$sql = "UPDATE rooms set room_occupied = room_occupied - 1 where room_id = '$room_id'";
				mysqli_query($conn, $sql);
			}


			// Change Status
			mysqli_query($conn, "UPDATE reservation set res_status = 'expired' WHERE cust_id = '$cust_id'");
			mysqli_query($conn, "UPDATE billing set bill_status = 'expired' WHERE cust_id = '$cust_id'");
			mysqli_query($conn, "UPDATE customers set cust_status = 'expired' WHERE cust_id = '$cust_id'");


			// Inserting records to reports table
			$res = mysqli_query($conn, "SELECT * FROM reservation
			where cust_id = '$cust_id' AND res_status = 'expired'");
			$queryResults = mysqli_num_rows($res);
			$row = mysqli_fetch_array($res);
				

			// Get id's
			$res_id = $row['res_id'];	
			$bill_id = $row['bill_id'];	
			$user_id = $_SESSION['u_id'];	
			$rep_status = "expired";	
			
			// Insert into reports
			mysqli_query($conn , "INSERT INTO reports (cust_id, res_id, bill_id, user_id, rep_status) 
				values ('$cust_id','$res_id', '$bill_id','$user_id', '$rep_status')");



		}
	}

	$res_date ='';
	$cust_id ='';
	$status ='';
	$result ='';

?>
