	<?php 
	include_once 'includes/dbh.inc.php';
	
 if(isset($_POST['res_id'])){

 	$res_id = $_POST['res_id'];
 	$result = mysqli_query($conn , "SELECT * from reservation where res_id = '$res_id'");
	$row = mysqli_fetch_assoc($result);
	$cust_id = $row['cust_id'];
	
	$checkin = $row['checkin'];
	$checkout = $row['checkout'];
	$today = date('Y-m-d');
	
	if($checkin > $today){

		header("Location: ../admin/checkin.php?checkin=notDate");
		exit();

	}else{

		// Expired
		if($checkout < $today){

			// Set room available
			$sql = "SELECT * from reservation where cust_id = '$cust_id'";
			$result = mysqli_query($conn, $sql);
				while($row = mysqli_fetch_assoc($result)){

					mysqli_query($conn , "UPDATE reservation set res_status = 'noshow' where cust_id = '$cust_id'");

					$quantity = $row['quantity'];

					for ($x = 1; $x <= $quantity; $x++){
						// Plus -1 to each room
						$sql = "update rooms set room_occupied = room_occupied - 1 where room_id = '$row[room_id]'";
						mysqli_query($conn, $sql);
					}

				}


				mysqli_query($conn , "UPDATE customers set cust_status = 'noshow' where cust_id = '$cust_id'");
				mysqli_query($conn , "UPDATE billing set bill_status = 'noshow' where cust_id = '$cust_id'");

				// Inserting records to reports table
				$res = mysqli_query($conn, "SELECT * FROM reservation
				where cust_id = '$cust_id'");
				$queryResults = mysqli_num_rows($res);
				while($row = mysqli_fetch_array($res)){
					// Get id's
					$res_id = $row['res_id'];
					$room_id = $row['room_id'];	
					$bill_id = $row['bill_id'];	
					$user_id = $_SESSION['u_id'];	
					$rep_status = "noshow";	
					
					// Insert into reports
					mysqli_query($conn , "INSERT INTO reports (cust_id, res_id, room_id, bill_id, user_id, rep_status) 
						values ('$cust_id','$res_id', '$room_id', '$bill_id','$user_id', '$rep_status')");
				}
					

				header("Location: ../admin/checkin.php?checkin=exceed");
				exit();

		}else{
			
			// Check in customer
			mysqli_query($conn , "UPDATE reservation set res_status = 'checkedin' where res_id = '$res_id'");
			$sql = "SELECT * from reservation where res_status = 'checkin' AND cust_id = '$cust_id'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				$queryResults = mysqli_num_rows($result);

				if($queryResults == 0){
					$date = date('Y-m-d H:i:sa');
					mysqli_query($conn , "UPDATE customers set cust_status = 'checkedin', cust_checkin = '$date' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE billing set bill_status = 'checkedin' where cust_id = '$cust_id'");
				}

			header("Location: ../admin/checkin.php?checkin=success");
			exit();
		}

	}




}