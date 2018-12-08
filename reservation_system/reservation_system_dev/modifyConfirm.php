<?php
	session_start();
	include_once 'includes/dbh.inc.php';
	if (isset($_POST['submit'])){

		// Get
		$cust_id = $_SESSION['cust_id'];
		$cust_email = $_SESSION['c_email'];
		$cust_contact = $_SESSION['c_contact'];
		$total = $_SESSION['total'];

		// Update customer details
		$sql = "UPDATE customers SET cust_email = '$cust_email', cust_contact = '$cust_contact' where cust_id = '$cust_id'";
		mysqli_query($conn, $sql);

		// Update customer bill
		$sql = "Update billing set total_amount = '$total', balance = '$total' where cust_id = '$cust_id'";
		mysqli_query($conn, $sql);


		$sql = "SELECT * from reservation where cust_id = '$cust_id'";
		$result = mysqli_query($conn, $sql);
		  while($row = mysqli_fetch_assoc($result)){
			  $bill_id = $row['bill_id'];
			  $quantity = $row['quantity'];

			for ($x = 1; $x <= $quantity; $x++){
				// Plus -1 to each room
				$sql = "update rooms set room_occupied = room_occupied - 1 where room_id = '$row[room_id]'";
				mysqli_query($conn, $sql);
			}
			
		  }

		// Delete old reservations  
		$sql = "Delete from reservation where cust_id = '$cust_id'";
		mysqli_query($conn, $sql);




		foreach ($_SESSION['reservations'] as $key => $room) {

			$cust_id = mysqli_real_escape_string($conn, $cust_id);
			$room_id = mysqli_real_escape_string($conn, $room['id']);
			$checkin = mysqli_real_escape_string($conn, $room['checkin']);
			$checkout = mysqli_real_escape_string($conn, $room['checkout']);
			$quantity = mysqli_real_escape_string($conn, $room['quantity']);
			$nights = mysqli_real_escape_string($conn, $room['nights']);
			$res_status = 'pending';
			$res_type = 'online';


			for ($x = 1; $x <= $quantity; $x++){
				// Plus 1 to each room that will be occupied
				$sql = "UPDATE rooms set room_occupied =  + 1 where room_id = '$room_id'";
				mysqli_query($conn, $sql);
			}

				// Insert reservation
				$sql = "INSERT INTO reservation (cust_id, bill_id, room_id, quantity, nights, checkin, checkout, res_type, res_status) values ('$cust_id', '$bill_id', '$room_id', '$quantity', '$nights', '$checkin','$checkout', '$res_type', '$res_status')";


				if($conn->query($sql)===TRUE){
					$_SESSION['r_id'] = $conn->insert_id;
				}
		}

		
		// Sent updated reservation to customer
		include_once 'phpmailer.php';
}






	