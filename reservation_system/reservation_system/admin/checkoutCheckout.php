<?php 
	include_once 'includes/dbh.inc.php';
	session_start();
	
	if(isset($_POST['res_id'])){
		$res_id = $_POST['res_id'];

		// Get reservation
		$sql = "SELECT * from reservation where res_id = '$res_id'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$cust_id = $row['cust_id'];

		// Get billing
		$sql = "SELECT * from billing where cust_id = '$cust_id'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$balance = $row['balance'];

			if($balance == 0){

			// Checkout reservation
			mysqli_query($conn , "UPDATE reservation set res_status = 'checkedout' where res_id = '$res_id'");


			// Check if there is further reservation by the customer
			$sql = "SELECT * from reservation where cust_id = '$cust_id' AND res_status = 'checkedin'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$queryResults = mysqli_num_rows($result);

				// If all are checked out then update customer and billing table
				if($queryResults == 0){
					$date = date('Y-m-d H:i:sa');
					// Set status to checked out
					mysqli_query($conn , "UPDATE customers set cust_status = 'checkedout', cust_checkout = '$date' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE billing set bill_status = 'checkedout' where cust_id = '$cust_id'");


					// Inserting records to reports table
					$res = mysqli_query($conn, "SELECT * FROM reservation
					where res_id = '$res_id'");
					$queryResults = mysqli_num_rows($res);
					$row = mysqli_fetch_array($res);
						
					// Get id's
					$res_id = $row['res_id'];
					$room_id = $row['room_id'];	
					$bill_id = $row['bill_id'];	
					$user_id = $_SESSION['u_id'];	
					$rep_status = "checkedout";	
					
					// Insert into reports
					mysqli_query($conn , "INSERT INTO reports (cust_id, res_id, room_id, bill_id, user_id, rep_status) 
						values ('$cust_id','$res_id', '$room_id', '$bill_id','$user_id', '$rep_status')");
					

				}else{

					// Inserting records to reports table
					$res = mysqli_query($conn, "SELECT * FROM reservation
					where res_id = '$res_id'");
					$queryResults = mysqli_num_rows($res);
					$row = mysqli_fetch_array($res);
						
					// Get id's
					$res_id = $row['res_id'];	
					$bill_id = $row['bill_id'];	
					$user_id = $_SESSION['u_id'];	
					$rep_status = "checkedout";	
					
					// Insert into reports
					mysqli_query($conn , "INSERT INTO reports (cust_id, res_id, bill_id, user_id, rep_status) 
						values ('$cust_id','$res_id', '$bill_id','$user_id', '$rep_status')");
					

				}

				// Update room availability
				$sql = "SELECT * from reservation where res_id = '$res_id'";
				$result = mysqli_query($conn, $sql);
				while($row = mysqli_fetch_assoc($result)){
				$quantity = $row['quantity'];

					for ($x = 1; $x <= $quantity; $x++){
						// Plus -1 to each room
						$sql = "UPDATE rooms set room_occupied = room_occupied - 1 where room_id = '$row[room_id]'";
						mysqli_query($conn, $sql);
					}
	
				}

				// Redirect
				header("Location: ../admin/checkout.php?checkout=successful");
				exit();

		}else{

			header("Location: ../admin/checkout.php?balance=notpaid");
			exit();
		}


	}else{
		header("Location: ../admin/checkin.php?=error");
		exit();	

	}
 ?>

