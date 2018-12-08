 <?php
	session_start();
	include_once 'includes/dbh.inc.php';	
	//Cancel
	if(isset($_POST['cust_id'])){
		$cust_id = $_POST['cust_id'];

		$sql = "SELECT * from reservation where cust_id = '$cust_id'";
		$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_assoc($result)){
				$room_id = $row['room_id'];
				$quantity = $row['quantity'];
			
				for ($x = 1; $x <= $quantity; $x++){
					// Minus 1 to each room that will be occupied
					$sql = "UPDATE rooms set room_occupied = room_occupied - 1 where room_id = '$room_id'";
					mysqli_query($conn, $sql);
				}

			}
				
		// Change Status to cancelled
		mysqli_query($conn, "UPDATE reservation set res_status = 'cancelled' WHERE cust_id = '$cust_id'");
		mysqli_query($conn, "UPDATE billing set bill_status = 'cancelled' WHERE cust_id = '$cust_id'");
		mysqli_query($conn, "UPDATE customers set cust_status = 'cancelled' WHERE cust_id = '$cust_id'");


		// Inserting records to reports table
		$res = mysqli_query($conn, "SELECT * FROM reservation
		where cust_id = '$cust_id' AND res_status = 'cancelled'");
		$queryResults = mysqli_num_rows($res);
		$row = mysqli_fetch_array($res);
			
		// Get id's
		$res_id = $row['res_id'];	
		$bill_id = $row['bill_id'];	
		$user_id = $_SESSION['u_id'];	
		$rep_status = "cancelled";	
		
		// Insert into reports
		mysqli_query($conn , "INSERT INTO reports (cust_id, res_id, bill_id, user_id, rep_status) 
			values ('$cust_id','$res_id', '$bill_id','$user_id', '$rep_status')");


		// Redirect
		header("Location: ../admin/reservation.php?cancel=success");
		exit();	
	}
?>